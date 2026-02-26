<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'category'])->latest()->get();
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function approve(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'validity_days' => 'required|integer|min:1',
        ]);

        $enrollment->update([
            'status' => 'approved',
            'validity_days' => $request->validity_days,
            'expires_at' => Carbon::now()->addDays((int) $request->validity_days),
        ]);

        return back()->with('success', "Enrollment approved for {$request->validity_days} days.");
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'validity_days' => 'required|integer|min:1',
        ]);

        $enrollment->update([
            'validity_days' => $request->validity_days,
            'expires_at' => Carbon::now()->addDays((int) $request->validity_days),
        ]);

        return back()->with('success', "Enrollment updated. New validity: {$request->validity_days} days from today.");
    }

    public function reject(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'rejected']);
        return back()->with('success', 'Enrollment rejected.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return back()->with('success', 'Enrollment deleted.');
    }
}
