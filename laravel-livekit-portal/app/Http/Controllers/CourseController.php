<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Dashboard: show the current user's inactive courses + other users' active courses.
     */
    public function index()
    {
        $user = auth()->user();

        // Owner sees all their courses (both pending and active)
        $myCourses = Course::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->get();

        // Students see ACTIVE courses from other users.
        // Teachers do not need to see other people's courses.
        if ($user->role === 'teacher') {
            $activeCourses = collect();
        } else {
            $activeCourses = Course::where('is_active', true)
                ->where('user_id', '!=', $user->id)
                ->with(['user', 'category'])
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
        abort_if($course->user_id !== auth()->id(), 403);

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

        Course::create([
            'user_id'     => auth()->id(),
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
        abort_if($course->user_id !== auth()->id(), 403);

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
        abort_if($course->user_id !== auth()->id(), 403);

        $course->update(['is_active' => true]);

        // Reuse the existing room route logic (RoomController@show)
        return redirect()->route('room.show', $course->room_name);
    }

    /**
     * End a course (set active = false).
     */
    public function end(Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);

        $course->update(['is_active' => false]);

        return redirect()->route('courses.index')
            ->with('success', 'Course ended.');
    }

    /**
     * Delete a course.
     */
    public function destroy(Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);

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
