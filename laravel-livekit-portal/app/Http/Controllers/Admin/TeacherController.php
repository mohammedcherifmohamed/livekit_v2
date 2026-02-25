<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(): View
    {
        $teachers = Teacher::latest()->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function approve(Teacher $teacher): RedirectResponse
    {
        $teacher->update(['status' => 'approved']);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher request approved successfully.');
    }

    public function reject(Teacher $teacher): RedirectResponse
    {
        $teacher->update(['status' => 'rejected']);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher request rejected.');
    }

    /**
     * Permanently delete a teacher account (user + teacher record).
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher account deleted successfully.');
    }
}
