<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Principal;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PrincipalController extends Controller
{
    /* ================= REGISTER ================= */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:principals,email',
            'password' => 'required|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {

            // Create folder if not exists
            if (!file_exists(public_path('principals'))) {
                mkdir(public_path('principals'), 0777, true);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();

            // Move image to public/principals
            $photo->move(public_path('principals'), $photoName);
        }

        Principal::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'photo'    => $photoName
        ]);

        return redirect()->route('principal.login')
            ->with('success', 'Principal Registered Successfully');
    }


    /* ================= LOGIN ================= */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $principal = Principal::where('email', $request->email)->first();

        if ($principal && Hash::check($request->password, $principal->password)) {

            Session::put('principal_id', $principal->id);
            Session::put('principal_name', $principal->name);
            Session::put('principal_photo', $principal->photo);

            return redirect()->route('principal.dashboard');
        }

        return back()->with('error', 'Invalid Email or Password');
    }


    /* ================= DASHBOARD ================= */
    public function dashboard()
    {
        if (!Session::has('principal_id')) {
            return redirect()->route('principal.login')
                ->with('error', 'Please login first');
        }

        $students  = Student::all();
        $teachers  = Teacher::all();
        $principal = Principal::find(Session::get('principal_id'));

        return view('principal.dashboard', compact('students', 'teachers', 'principal'));
    }


    /* ================= LOGOUT ================= */
    public function logout()
    {
        Session::forget(['principal_id', 'principal_name', 'principal_photo']);

        return redirect()->route('principal.login')
            ->with('success', 'Logged out successfully');
    }


    /* ================= UPDATE STUDENT ================= */
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'age'     => 'nullable|integer',
            'address' => 'nullable|string|max:255',
        ]);

        $student->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'age'     => $request->age,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Student Updated Successfully');
    }


    /* ================= DELETE STUDENT ================= */
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);

        // Delete student photo
        if ($student->photo && file_exists(public_path('students/' . $student->photo))) {
            unlink(public_path('students/' . $student->photo));
        }

        $student->delete();

        return back()->with('success', 'Student Deleted Successfully');
    }


    /* ================= UPDATE TEACHER ================= */
    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $teacher->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Teacher Updated Successfully');
    }


    /* ================= DELETE TEACHER ================= */
    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);

        // Delete teacher photo
        if ($teacher->photo && file_exists(public_path('teachers/' . $teacher->photo))) {
            unlink(public_path('teachers/' . $teacher->photo));
        }

        $teacher->delete();

        return back()->with('success', 'Teacher Deleted Successfully');
    }
}
