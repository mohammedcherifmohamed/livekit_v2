<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::latest()->get();

        return view('admin.students.index', compact('students'));
    }

    public function approve(Student $student): RedirectResponse
    {
        $student->update(['status' => 'approved']);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student request approved successfully.');
    }

    public function reject(Student $student): RedirectResponse
    {
        $student->update(['status' => 'rejected']);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student request rejected.');
    }

    /**
     * Permanently delete a student account (user + student record).
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student account deleted successfully.');
    }
}
