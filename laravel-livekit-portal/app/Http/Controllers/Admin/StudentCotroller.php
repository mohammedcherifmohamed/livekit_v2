<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCotroller extends Controller
{
    public function index(): View
    {
        $students = Student::with('user')->latest()->get();

        return view('admin.students.index', compact('students'));
    }

    public function approve(Student $student): RedirectResponse
    {
        $student->update(['status' => 'approved']);

        if ($student->user) {
            $student->user->update(['is_approved' => true]);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student request approved successfully.');
    }

    public function reject(Student $student): RedirectResponse
    {
        $student->update(['status' => 'rejected']);

        if ($student->user) {
            $student->user->update(['is_approved' => false]);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student request rejected.');
    }
}
