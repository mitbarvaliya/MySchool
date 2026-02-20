<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PrincipalController;

Route::view('/', 'welcome');


// ===================== STUDENT =====================

// Register
Route::get('/student/register', fn () => view('students.register'))->name('students.register');
Route::post('/student/register', [StudentController::class, 'store'])->name('students.store');

// Login
Route::get('/student/login', fn () => view('students.login'))->name('students.login');
Route::post('/student/login', [StudentController::class, 'login'])->name('students.login.post');

// Dashboard (Protect Later with Middleware)
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');

// Logout
Route::post('/student/logout', [StudentController::class, 'logout'])->name('students.logout');



// ===================== TEACHER =====================

// Register
Route::get('/teacher/register', fn()=>view('teacher.register'))->name('teacher.register');
Route::post('/teacher/register', [TeacherController::class,'register'])->name('teacher.register.post');

// Login
Route::get('/teacher/login', fn()=>view('teacher.login'))->name('teacher.login');
Route::post('/teacher/login',[TeacherController::class,'login'])->name('teacher.login.post');

// Dashboard
Route::get('/teacher/dashboard',[TeacherController::class,'dashboard'])->name('teacher.dashboard');

// Student CRUD by teacher
Route::post('/teacher/student',[TeacherController::class,'storeStudent'])->name('teacher.student.store');
Route::put('/teacher/student/{id}',[TeacherController::class,'updateStudent'])->name('teacher.student.update');
Route::delete('/teacher/student/{id}',[TeacherController::class,'deleteStudent'])->name('teacher.student.delete');

// Logout
Route::post('/teacher/logout',[TeacherController::class,'logout'])->name('teacher.logout');



// ===================== PRINCIPAL =====================

// Register
Route::get('/principal/register', fn () => view('principal.register'))->name('principal.register');
Route::post('/principal/register', [PrincipalController::class, 'register'])->name('principal.register.post');

// Login
Route::get('/principal/login', fn () => view('principal.login'))->name('principal.login');
Route::post('/principal/login', [PrincipalController::class, 'login'])->name('principal.login.post');

// Dashboard
Route::get('/principal/dashboard', [PrincipalController::class, 'dashboard'])
    ->name('principal.dashboard');

// Logout
Route::post('/principal/logout', [PrincipalController::class, 'logout'])
    ->name('principal.logout');


// ---------- PRINCIPAL CONTROL STUDENT ----------
Route::put('/principal/student/{id}', [PrincipalController::class, 'updateStudent'])
    ->name('principal.student.update');

Route::delete('/principal/student/{id}', [PrincipalController::class, 'deleteStudent'])
    ->name('principal.student.delete');


// ---------- PRINCIPAL CONTROL TEACHER ----------
Route::put('/principal/teacher/{id}', [PrincipalController::class, 'updateTeacher'])
    ->name('principal.teacher.update');

Route::delete('/principal/teacher/{id}', [PrincipalController::class, 'deleteTeacher'])
    ->name('principal.teacher.delete');

Route::get('/student/profile', [StudentController::class, 'profile'])
    ->name('student.profile');