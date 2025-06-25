<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLoginRequest;
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

    /**
     * Check email and password.
     */
    public function checkCredential(ValidateLoginRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $model = match ($data['role']) {
            'SuperAdmin' => SuperAdmin::class,
            // 'Admin' => Admin::class,
            // 'Doctor' => Doctor::class,
            // 'Student' => Student::class,
            // default => null,
        };
        // dd($model);
        if (!$model::where('email', $data['email'])->exists())
        {
            return redirect()->back()->with('email' , 'This email does not exist.');
        }
        
        if(Auth::guard($data["role"])->attempt([
            "email" => $data["email"],
            "password" => $data["password"]
        ]))
        {
            Auth::guard($data["role"])->user();
            return redirect()->route("dashboard_".$data['role']);
        }

        return redirect()->back()->with('password', 'The provided password is incorrect.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
