<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display the specified category details.
     */
    public function show(Category $category)
    {
        // Load some active courses for this category to show a preview
        $courses = $category->courses()->where('is_active', true)->with('teacher')->get();
        
        $isEnrolled = false;
        if (Auth::guard('student')->check()) {
            $isEnrolled = Enrollment::where('student_id', Auth::guard('student')->id())
                ->where('category_id', $category->id)
                ->exists();
        }

        return view('categories.show', compact('category', 'courses', 'isEnrolled'));
    }

    /**
     * Enroll the current student in the category.
     */
    public function enroll(Category $category)
    {
        if (!Auth::guard('student')->check()) {
            return redirect()->route('login')->with('status', 'Please log in as a student to enroll in courses.');
        }

        $studentId = Auth::guard('student')->id();

        // Prevent duplicate enrollments
        $exists = Enrollment::where('student_id', $studentId)
            ->where('category_id', $category->id)
            ->exists();

        if ($exists) {
            return back()->with('success', 'You are already enrolled in this category.');
        }

        Enrollment::create([
            'student_id' => $studentId,
            'category_id' => $category->id,
        ]);

        return redirect()->route('courses.index')->with('success', "Enrolled in {$category->name} successfully!");
    }
}
