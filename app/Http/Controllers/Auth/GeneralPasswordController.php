<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckGeneralPasswordRequest;
use App\Models\GeneralPassword;
use Illuminate\Http\Request;

class GeneralPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("general_password");
    }

    /**
     * Check general password and return special view.
     */
    public function check(CheckGeneralPasswordRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $generalPassword = GeneralPassword::where("general_code", $data["general_password"])->first();
        if(!$generalPassword)
        {
            return redirect()->back()->withErrors(["general_password" => "The provided password is incorrect."]);
        }

        $type = $generalPassword->accessible_type;
        $path = class_basename($type);
        // dd($path);
        return redirect()->route("login_" . $path);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
