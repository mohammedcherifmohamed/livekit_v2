<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherCotroller extends Controller
{
    public function index(): View
    {
        $teachers = Teacher::with('user')->latest()->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function approve(Teacher $teacher): RedirectResponse
    {
        $teacher->update(['status' => 'approved']);

        if ($teacher->user) {
            $teacher->user->update(['is_approved' => true]);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher request approved successfully.');
    }

    public function reject(Teacher $teacher): RedirectResponse
    {
        $teacher->update(['status' => 'rejected']);

        if ($teacher->user) {
            $teacher->user->update(['is_approved' => false]);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher request rejected.');
    }
}
