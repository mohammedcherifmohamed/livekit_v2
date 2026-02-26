<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Dashboard: show the current user's inactive courses + other users' active courses.
     */
    public function index()
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('teacher')->user() ?? Auth::guard('student')->user();

        if (Auth::guard('teacher')->check()) {
            $user = Auth::guard('teacher')->user();
            // Teacher Dashboard: Their own courses
            $myCourses = Course::where('teacher_id', $user->id)
                ->with('category')
                ->latest()
                ->get();
            $activeCourses = collect();
        } elseif (Auth::guard('student')->check()) {
            $user = Auth::guard('student')->user();
            // Student: Only courses in categories they have an APPROVED and NON-EXPIRED enrollment in
            $enrollments = \App\Models\Enrollment::where('student_id', $user->id)
                ->where('status', 'approved')
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                })
                ->get()
                ->keyBy('category_id');

            $categoryIds = $enrollments->keys();
            
            $myCourses = collect(); 
            $activeCourses = Course::whereIn('category_id', $categoryIds)
                ->with(['teacher', 'category'])
                ->latest()
                ->get();

            // Attach enrollment info to each course for the view
            foreach ($activeCourses as $course) {
                $course->enrollment = $enrollments[$course->category_id] ?? null;
            }
        } else {
            // Admin or other: See everything active
            $myCourses = collect();
            $activeCourses = Course::where('is_active', true)
                ->with(['teacher', 'category'])
                ->latest()
                ->get();
        }

        return view('courses.index', compact('myCourses', 'activeCourses'));
    }

    /**
     * Show the course creation form.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('courses.create', compact('categories'));
    }

    /**
     * Show the edit form for an existing course.
     */
    public function edit(Course $course)
    {
        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        abort_if($course->teacher_id !== $userId, 403);

        $categories = \App\Models\Category::all();

        return view('courses.edit', compact('course', 'categories'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'room_name'   => 'required|string|max:100|alpha_dash|unique:courses,room_name',
        ]);

        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        Course::create([
            'teacher_id'     => $userId,
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'room_name'   => strtolower($validated['room_name']),
            'is_active'   => false,
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course created! Launch it when you are ready.');
    }

    /**
     * Update an existing course.
     */
    public function update(Request $request, Course $course)
    {
        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        abort_if($course->teacher_id !== $userId, 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'room_name'   => 'required|string|max:100|alpha_dash|unique:courses,room_name,' . $course->id,
        ]);

        $course->update([
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'room_name'   => strtolower($validated['room_name']),
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Launch a course (set active = true) and redirect creator into the LiveKit room.
     * Uses the same handover logic as the existing RoomController.
     */
    public function launch(Course $course)
    {
        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        abort_if($course->teacher_id !== $userId, 403);

        $course->update(['is_active' => true]);

        // Reuse the existing room route logic (RoomController@show)
        return redirect()->route('room.show', $course->room_name);
    }

    /**
     * End a course (set active = false).
     */
    public function end(Course $course)
    {
        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        abort_if($course->teacher_id !== $userId, 403);

        $course->update(['is_active' => false]);

        return redirect()->route('courses.index')
            ->with('success', 'Course ended.');
    }

    /**
     * Delete a course.
     */
    public function destroy(Course $course)
    {
        $userId = Auth::guard('web')->id() ?? Auth::guard('teacher')->id() ?? Auth::guard('student')->id();
        abort_if($course->teacher_id !== $userId, 403);

        // Optional: prevent deleting while live
        if ($course->is_active) {
            return redirect()->route('courses.index')
                ->with('success', 'Please end the course before deleting it.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
