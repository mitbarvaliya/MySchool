<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /* ================= AUTH ================= */

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:teachers,email',
            'password' => 'required|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {

            if (!file_exists(public_path('teachers'))) {
                mkdir(public_path('teachers'), 0777, true);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('teachers'), $photoName);
        }

        Teacher::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'photo'    => $photoName,
        ]);

        return redirect()->route('teacher.login')
            ->with('success', 'Registration successful. Please login.');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return back()->with('error', 'Invalid email or password');
        }

        Session::put('teacher_id', $teacher->id);
        Session::put('teacher_name', $teacher->name);
        Session::put('teacher_photo', $teacher->photo);

        return redirect()->route('teacher.dashboard');
    }


    public function logout()
    {
        Session::forget(['teacher_id', 'teacher_name', 'teacher_photo']);

        return redirect()->route('teacher.login')
            ->with('success', 'Logged out successfully.');
    }


    /* ================= DASHBOARD ================= */

    public function dashboard()
    {
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login')
                ->with('error', 'Please login first.');
        }

        // SHOW ALL STUDENTS (No teacher_id filter)
        $students = Student::orderBy('id', 'desc')->get();

        return view('teacher.dashboard', compact('students'));
    }


    /* ================= STUDENT CRUD ================= */

    public function storeStudent(Request $request)
    {
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {

            if (!file_exists(public_path('students'))) {
                mkdir(public_path('students'), 0777, true);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('students'), $photoName);
        }

        Student::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'photo'    => $photoName,
        ]);

        return back()->with('success', 'Student added successfully');
    }


    public function updateStudent(Request $request, $id)
    {
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login');
        }

        $student = Student::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($student->id),
            ],
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $student->name  = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        if ($request->hasFile('photo')) {

            if ($student->photo && file_exists(public_path('students/' . $student->photo))) {
                unlink(public_path('students/' . $student->photo));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('students'), $photoName);

            $student->photo = $photoName;
        }

        $student->save();

        return back()->with('success', 'Student updated successfully');
    }


    public function deleteStudent($id)
    {
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login');
        }

        $student = Student::findOrFail($id);

        if ($student->photo && file_exists(public_path('students/' . $student->photo))) {
            unlink(public_path('students/' . $student->photo));
        }

        $student->delete();

        return back()->with('success', 'Student deleted successfully');
    }
}
