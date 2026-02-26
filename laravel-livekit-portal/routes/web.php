<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\Admin\EnrollmentController;

Route::get('/', function () {
    $categories = Category::orderBy('price', 'desc')->get();
    return view('welcome', compact('categories'));
})->name("home.load");



Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::post('/categories/{category}/enroll', [EnrollController::class, 'enrollCourse'])->name('categories.enroll')->middleware('auth:student');

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    // Admin login routes
    Route::get('/admin/login', [WebAuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [WebAuthController::class, 'login']); // Re-using the same login logic which handles 'role'
    Route::post('/register', [WebAuthController::class, 'register']);
});



Route::middleware(['auth:web,teacher,student', 'check_enrollment'])->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        $enrollments = [];
        if (auth()->guard('student')->check()) {
            $enrollments = \App\Models\Enrollment::where('student_id', auth()->guard('student')->id())
                ->with('category')
                ->where('status', 'approved')
                ->get();
        }
        return view('dashboard', compact('enrollments'));
    })->name('dashboard');

    Route::get('/meet/{room}', [RoomController::class, 'show'])->name('room.show');

    // Course management
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

    // Only approved teachers can create and manage their courses
    Route::middleware('is_teacher')->group(function () {
        Route::get('/courses/create',            [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses',                  [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit',     [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}',          [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}',       [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::patch('/courses/{course}/launch', [CourseController::class, 'launch'])->name('courses.launch');
        Route::patch('/courses/{course}/end',    [CourseController::class, 'end'])->name('courses.end');
    });
});



Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    Route::get('teachers', [AdminTeacherController::class, 'index'])->name('teachers.index');
    Route::post('teachers/{teacher}/approve', [AdminTeacherController::class, 'approve'])->name('teachers.approve');
    Route::post('teachers/{teacher}/reject', [AdminTeacherController::class, 'reject'])->name('teachers.reject');
    Route::delete('teachers/{teacher}', [AdminTeacherController::class, 'destroy'])->name('teachers.destroy');

    Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::post('students/{student}/approve', [AdminStudentController::class, 'approve'])->name('students.approve');
    Route::post('students/{student}/reject', [AdminStudentController::class, 'reject'])->name('students.reject');
    Route::delete('students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');

    // Enrollment management
    Route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('enrollments/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::put('enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('enrollments.update');
    Route::post('enrollments/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('enrollments.reject');
    Route::delete('enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
});
