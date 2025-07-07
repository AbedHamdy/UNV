<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Course;
use App\Models\Doctor;
use App\Models\GeneralPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::paginate();
        // dd($doctors);
        return view('SuperAdmin.views.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        if(!$courses)
        {
            return redirect()->route('create_course')->with('error', 'Please create a course first.');
        }

        return view('SuperAdmin.views.doctors.create' , compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();
        $course = Course::find($data['course_id']);

        if (!$course)
        {
            return redirect()->back()->with('error', 'Please select a valid course.');
        }

        $newImage = null;
        DB::beginTransaction();

        try
        {
            if ($request->hasFile('image'))
            {
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $newImage = time() . rand(10000, 50000) . "." . $ext;

                $path = public_path('images/doctors');
                if (!file_exists($path))
                {
                    mkdir($path, 0777, true);
                }

                $image->move($path, $newImage);
                $data['image'] = $newImage;
            }

            $data['password'] = Hash::make($data['password']);
            $doctor = Doctor::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'image' => $data['image'] ?? null,
                'course_id' => $data['course_id'],
            ]);

            if (!$doctor)
            {
                throw new \Exception('Failed to create doctor');
            }

            do
            {
                $code = random_int(10000, 99999);
            } while (GeneralPassword::where('general_code', $code)->exists());

            $generalPassword = GeneralPassword::create([
                'general_code' => $code,
                'accessible_type' => Doctor::class,
                'accessible_id' => $doctor->id,
            ]);

            if (!$generalPassword)
            {
                throw new \Exception('Failed to create general password , please try again/');
            }

            DB::commit();

            return redirect()->route('create_doctor')->with('success', 'Doctor created successfully');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            if ($newImage && File::exists(public_path('images/doctors/' . $newImage)))
            {
                File::delete(public_path('images/doctors/' . $newImage));
            }

            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor)
        {
            return redirect()->back()->with('error', 'Doctor not found.');
        }

        DB::beginTransaction();
        try
        {
            if ($doctor->image && File::exists(public_path('images/doctors/' . $doctor->image)))
            {
                File::delete(public_path('images/doctors/' . $doctor->image));
            }

            $doctor->delete();

            GeneralPassword::where('accessible_type', Doctor::class)
                ->where('accessible_id', $doctor->id)
                ->delete();

            DB::commit();

            return redirect()->route('all_doctors')->with('success', 'Doctor deleted successfully.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
