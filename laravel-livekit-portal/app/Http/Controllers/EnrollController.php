<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendToStudent;
use App\Mail\SendEnrollmentToAdmin;
use App\Models\Dashboard;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Admin\StudentsController ;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Category as CategoryModel ;


use App\Models\Enrollment ;

class EnrollController extends Controller
{

public function enrollCourse(Request $request,$category_id){

// dd($category);

    try {

        $category = CategoryModel::findOrFail($category_id);

        Enrollment::create([
            "student_id" => Auth::guard('student')->id(),
            "category_id" => $category_id,
            "status" => "pending"
        ]);

        $data = [
            'course_name' => $category->name,
            'student_email' => Auth::user()->email,
            'course_price' => $category->price,
            'course_duration' =>"1 week default",
            'student_name' => Auth::user()->name,
            'phone' => "099 default",
            'subject' => 'Enrollment Confirmation',
            'message' => 'You have successfully enrolled in the course.',
        ];

        $AdminData = [
            'course_name' => $category->name,
            'course_price' => $category->price,
            'course_duration' => "1 week default",
            'student_name' => Auth::user()->name,
            'student_email' => Auth::user()->email,
            'phone' => "099 default",
            'subject' => 'New Course Enrollment',
            'message' => 'A new student has enrolled in the course.',
        ];

        // Send email To Student 
        Mail::to(Auth::user()->email)->send(new SendToStudent($data));
        // Send email To Admin
        Mail::to('mdg85505@gmail.com')->send(new SendEnrollmentToAdmin($AdminData));


        return view("mail.EnrollSuccess");

    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}


public function testData(){

    $data = Quizes::with("questions.options")->get();
    return view("testData",compact('data'));

}
}
