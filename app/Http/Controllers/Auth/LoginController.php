<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLoginRequest;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function LoginSuperAdmin()
    {
        return view("SuperAdmin.views.login");
    }

    public function LoginAdmin()
    {
        return view("Admin.views.login");
    }

    public function LoginDoctor()
    {
        return view("Doctor.views.login");
    }

    /**
     * Check email and password.
     */
    public function checkCredential(ValidateLoginRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $model = match ($data['role']) {
            'SuperAdmin' => SuperAdmin::class,
            'Admin' => Admin::class,
            'Doctor' => Doctor::class,
            // 'Student' => Student::class,
            // default => null,
        };

        // dd($model);
        if (!$model::where('email', $data['email'])->exists())
        {
            return redirect()->back()->withErrors(['email' => 'This email does not exist.']);
        }

        if(Auth::guard($data["role"])->attempt([
            "email" => $data["email"],
            "password" => $data["password"]
        ]))
        {
            Auth::guard($data["role"])->user();
            // dd($data["role"]);
            return redirect()->route("dashboard_".$data['role']);
        }
        // dd($data);


        return redirect()->back()->withErrors(['password' => 'The provided password is incorrect.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logoutSuperAdmin(Request $request)
    {
        Auth::guard('SuperAdmin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('Admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
