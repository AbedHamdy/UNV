<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate();
        // if($courses->isEmpty())
        // {
        //     return redirect()->route("create_course")->with("error" , "Please create course first");
        // }
        return view("SuperAdmin.views.courses.index" , compact("courses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("SuperAdmin.views.courses.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $course = Course::create($data);
        if(!$course)
        {
            return redirect()->back()->with("error" , "Please try again");
        }

        return redirect()->route("create_course")->with("success" , "Course created successfully");
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
    public function edit($id)
    {
        $course = Course::find($id);
        if(!$course)
        {
            return redirect()->route("all_courses")->with("error" , "Not found this course");
        }

        return view("SuperAdmin.views.courses.edit" , compact("course"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseRequest $request, $id)
    {
        $data = $request->validated();
        // dd($data);
        $course = Course::find($id);
        if(!$course)
        {
            return redirect()->back()->with("error" , "Not found this course , Please try again");
        }

        $course->name = $data["name"];
        $course->save();

        return redirect()->route("all_courses")->with("success" , "Course name updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        if(!$course)
        {
            return redirect()->back()->with("error" , "Not found this course , please try again");
        }

        $course->delete();
        return redirect()->route("all_courses")->with("success" , "Course deleted successfully");
    }
}
