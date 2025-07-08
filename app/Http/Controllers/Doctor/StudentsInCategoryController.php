<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CourseStudent;
use App\Models\Doctor;
use App\Models\Grade;
use App\Models\SemesterStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsInCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $category = Category::find($id);
        // dd($category);
        if(!$category)
        {
            return redirect()->back()->with("error" , "Category not found , please try again");
        }

        $doctor = Auth::guard("Doctor")->user();
        $courseId = $doctor->course_id;
        // dd($doctor);
        // $students = Category::with("semester")
        $students = CourseStudent::with(['student', 'grade' => function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            }])
            ->where("category_id" , $id)
            ->where("pass" , false)
            ->where("course_id" , $doctor->course_id)
            ->paginate();


        $doctor = Doctor::with("course")->first();
        $course = $doctor->course->name;
        // dd($students);
        return view("Doctor.views.students.index" , compact("students" , "course"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function update(Request $request , $id)
    {
        $data = $request->validate([
            "grade" => "required|integer|min:0|max:100",
        ]);

        $student = CourseStudent::find($id);
        // dd($student);
        $grade = Grade::where("course_id" , $student->course_id)
            ->where("student_id" , $student->student_id)
            ->first();

        if($grade)
        {
            $newGrade = $grade->update([
                "grade" => $data["grade"],
            ]);

            return redirect()->route("all_students" , $student->category_id)->with("success" , "Grade updated successfully");
        }

        $grade = Grade::create([
            "grade" => $data["grade"],
            "course_id" => $student->course_id,
            "student_id" => $student->student_id,
        ]);

        if(!$grade)
        {
            return redirect()->back()->with("error" , "Field grade create , please try again");
        }

        return redirect()->route("all_students" , $student->category_id)->with("success" , "Grade updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
