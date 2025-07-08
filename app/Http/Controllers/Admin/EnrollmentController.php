<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchStudentRequest;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\CategoryCourse;
use App\Models\CourseStudent;
use App\Models\SemesterStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SearchStudentRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $student = Student::where("code" , $data["student_code"])->first();
        if(!$student)
        {
            return redirect()->back()->with("error" , "Student not found , please try again");
        }

        $activeSemester = SemesterStudent::where("current" , 1)
            ->where("pass" , 0)
            ->where("student_id" , $student->id)
            ->first();

        if(!$activeSemester)
        {
            return redirect()->back()->with("error" , "Error , please try again");
        }

        // dd($activeSemester);
        $existingEnrollments = CourseStudent::where('student_id', $student->id)
            ->where('semester_id', $activeSemester->semester_id)
            ->exists();

        if ($existingEnrollments)
        {
            return redirect()->route("dashboard_Admin")->with("success", "Student is already enrolled in courses for this semester.");
        }

        $courses = CategoryCourse::with("course")->where("semester_id" , $activeSemester->semester_id)->get();
        if(!$courses)
        {
            return redirect()->back()->with("error" , "Courses not found , please try again");
        }

        // dd($courses);
        return view("Admin.views.enrollment.index" , compact("courses" , "student"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $semester = SemesterStudent::where("current" , 1)
            ->where("pass" , 0)
            ->where("student_id" , $data["student_id"])
            ->first();

        $data["semester_id"] = $semester->semester_id;
        $admin = Auth::guard("Admin")->user();
        $data["category_id"] = $admin->category_id;
        // $existingEnrollments = CourseStudent::where('student_id', $data['student_id'])
        //     ->where('semester_id', $data["semester_id"])
        //     ->exists();

        // // dd($existingEnrollments);
        // if ($existingEnrollments)
        // {
        //     return redirect()->route("dashboard_Admin")->with("success", "Student is already enrolled in courses for this semester.");
        // }

        DB::beginTransaction();
        try
        {
            foreach($data["courses"] as $course)
            {
                // dd($data["courses"]);
                $enrollment = CourseStudent::create([
                    "student_id" => $data["student_id"],
                    "semester_id" => $data["semester_id"],
                    "category_id" => $data["category_id"],
                    "course_id" => $course,
                ]);

                if(!$enrollment)
                {
                    throw new \Exception("Failed to enroll course  , please try again.");
                }
            }

            DB::commit();
            return redirect()->route("dashboard_Admin")->with("success" , "Courses have been successfully enrolled");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route("dashboard_Admin")->with('error', 'Something went wrong , please try again.');
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
