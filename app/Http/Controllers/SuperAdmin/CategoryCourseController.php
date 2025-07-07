<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryCourseRequest;
use App\Models\Category;
use App\Models\CategoryCourse;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryCourseController extends Controller
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
    public function create($id)
    {
        $category = Category::find($id);
        // dd($category);
        if (!$category)
        {
            return redirect()->back()->with('error', 'Category not found , please try again.');
        }

        $levels = $category->levels;
        // $semesters = $levels->flatMap->semesters;
        // dd($semesters);
        $assignedCourseIds = CategoryCourse::where('category_id', $id)
            ->pluck('course_id')
            ->toArray();
        // dd($assignedCourseIds);
        if(empty($assignedCourseIds))
        {
            $courses = Course::all();
        }
        else
        {
            $courses = Course::whereNotIn('id', $assignedCourseIds)->get();
        }
        return view('SuperAdmin.views.categories.assign_course', compact('category', 'levels' , "courses"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryCourseRequest $request , $id)
    {
        $data = $request->validated();
        // dd($data);
        $semester_id = Semester::select("id")
            ->where("level_id" , $data["level_id"])
            ->where("number_semester" , $data["semester_number"])
            ->first();
        // dd($semester_id);
        $data["semester_id"] = $semester_id->id;
        DB::beginTransaction();
        try
        {
            foreach ($data['courses'] as $course_id)
            {
                CategoryCourse::create([
                    'category_id' => $id,
                    'course_id' => $course_id,
                    'level_id' => $data['level_id'],
                    "semester_id" => $data["semester_id"],
                    // 'semester_number' => $data['semester_number'],
                ]);
            }

            DB::commit();
            return redirect()->route('all_categories')->with('success', 'Courses assigned to category successfully.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage())->withInput();
        }
        // return view("SuperAdmin.views.categories.select_courses" , compact(""));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with([
            'levels.semesters.courses'
        ])->find($id);

        if(!$category)
        {
            return redirect()->back()->with("error" , "Category not found , please try again.");
        }

        return view('SuperAdmin.views.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category_id, $level_id, $semester_id)
    {
        // dd("Edit courses for category: $category_id, level: $level_id, semester: $semester_id");
        $category = Category::find($category_id);
        if (!$category)
        {
            return redirect()->back()->with('error', 'Category not found, please try again.');
        }

        $level = $category->levels()->find($level_id);
        if (!$level)
        {
            return redirect()->back()->with('error', 'Level not found, please try again.');
        }

        $semester = $level->semesters()->find($semester_id);
        if (!$semester)
        {
            return redirect()->back()->with('error', 'Semester not found, please try again.');
        }

        $courses = CategoryCourse::with('course')
            ->where('category_id', $category_id)
            ->where('level_id', $level_id)
            ->where('semester_id', $semester_id)
            ->get()
            ->pluck('course');

        // dd($courses);
        if ($courses->isEmpty())
        {
            return redirect()->back()->with('error', 'No courses assigned to this category, level, and semester.');
        }

        return view('SuperAdmin.views.categories.edit_courses', compact('category', 'level', 'semester', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category_id, $level_id, $semester_id)
    {
        $data = $request->validate([
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
        ]);

        DB::beginTransaction();
        try
        {
            CategoryCourse::where('category_id', $category_id)
                ->where('level_id', $level_id)
                ->where('semester_id', $semester_id)
                ->delete();

            foreach ($data['courses'] ?? [] as $course_id)
            {
                CategoryCourse::create([
                    'category_id' => $category_id,
                    'course_id' => $course_id,
                    'level_id' => $level_id,
                    'semester_id' => $semester_id,
                ]);
            }

            DB::commit();

            return redirect()->route('all_categories')->with('success', 'Courses updated successfully.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
