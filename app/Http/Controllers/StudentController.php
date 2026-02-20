<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    /* ---------- REGISTER ---------- */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png'
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

        return redirect()->route('students.login')
            ->with('success', 'Registered successfully. Please login.');
    }

    /* ---------- LOGIN ---------- */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            return back()->with('error', 'Invalid credentials.');
        }

        Session::put('student_id', $student->id);

        return redirect()->route('students.dashboard');
    }

    /* ---------- DASHBOARD ---------- */
    public function dashboard()
    {
        if (!Session::has('student_id')) {
            return redirect()->route('students.login')
                ->with('error', 'Please login first.');
        }

        $student = Student::findOrFail(Session::get('student_id'));

        return view('students.dashboard', compact('student'));
    }

    /* ---------- UPDATE PROFILE ---------- */
    public function update(Request $request)
    {
        if (!Session::has('student_id')) {
            return redirect()->route('students.login');
        }

        $student = Student::findOrFail(Session::get('student_id'));

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email,' . $student->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $student->name  = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {

            // Delete old image
            if ($student->photo && file_exists(public_path('students/' . $student->photo))) {
                unlink(public_path('students/' . $student->photo));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('students'), $photoName);

            $student->photo = $photoName;
        }

        $student->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /* ---------- DELETE ACCOUNT ---------- */
    public function deleteAccount()
    {
        if (!Session::has('student_id')) {
            return redirect()->route('students.login');
        }

        $student = Student::findOrFail(Session::get('student_id'));

        if ($student->photo && file_exists(public_path('students/' . $student->photo))) {
            unlink(public_path('students/' . $student->photo));
        }

        $student->delete();

        Session::forget('student_id');

        return redirect()->route('students.login')
            ->with('success', 'Account deleted successfully.');
    }

    /* ---------- LOGOUT ---------- */
    public function logout()
    {
        Session::forget('student_id');
        return redirect()->route('students.login');
    }
        public function profile()
    {
        $student = \App\Models\Student::where('id', session('student_id'))->first();

        if(!$student){
            return redirect('/student/login');
        }

        return view('students.profile', compact('student'));
    }

}
