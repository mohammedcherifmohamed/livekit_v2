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
            ->latest()
            ->get();

        // Everyone else sees only ACTIVE courses from other users
        $activeCourses = Course::where('is_active', true)
            ->where('user_id', '!=', $user->id)
            ->with('user')
            ->latest()
            ->get();

        return view('courses.index', compact('myCourses', 'activeCourses'));
    }

    /**
     * Show the course creation form.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'room_name'   => 'required|string|max:100|alpha_dash|unique:courses,room_name',
        ]);

        Course::create([
            'user_id'     => auth()->id(),
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'room_name'   => strtolower($validated['room_name']),
            'is_active'   => false,
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course created! Launch it when you are ready.');
    }

    /**
     * Launch a course (set active = true) and redirect creator into the LiveKit room.
     */
    public function launch(Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);

        $course->update(['is_active' => true]);

        // Hand the creator off to the Next.js / LiveKit room
        $token = auth()->user()->createToken('handover_token')->plainTextToken;

        return redirect("http://localhost:3000/rooms/{$course->room_name}?token={$token}");
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
}
