<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchStudentRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Category;
use App\Models\GeneralPassword;
use App\Models\Level;
use App\Models\Semester;
use App\Models\SemesterStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function search(SearchStudentRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated();
            $admin = Auth::guard('Admin')->user();

            $levelCount = Level::where('category_id', $admin->category_id)->count();

            $student = Student::where('code', $data["student_code"])->first();
            if (!$student) {
                return redirect()->route('dashboard_Admin')->with('error', 'Student not found. Please try again.');
            }

            $lastActiveSemester = SemesterStudent::where('student_id', $student->id)
                ->where('current', true)
                ->where('pass', false)
                ->first();

            if (!$lastActiveSemester)
            {
                $hasAnySemester = SemesterStudent::where('student_id', $student->id)->exists();
                if (!$hasAnySemester)
                {
                    return redirect()->route('dashboard_Admin')->with('error', 'The student is not enrolled in any semester.');
                }

                $lastActiveSemester = SemesterStudent::where('student_id', $student->id)
                    ->where('current', true)
                    ->where('pass', false)
                    ->first();
                // return redirect()->route('dashboard_Admin')->with('error', 'No active semester found for this student.');
                return redirect()->route('dashboard_Admin')->with('success', 'The student has graduated.');
            }

            $studentSemester = Semester::with('level')->find($lastActiveSemester->semester_id);
            $activeSemester = Semester::with('level')->where('status', true)->first();

            if ($studentSemester->number_semester === $activeSemester->number_semester)
            {
                $isLastLevel = $studentSemester->level->number_level == $levelCount;
                $isGraduatedTerm = in_array($studentSemester->number_semester, [2, 3]);

                if ($isLastLevel && $isGraduatedTerm)
                {
                    $lastActiveSemester->update([
                        'current' => false,
                        'pass' => true,
                    ]);

                    DB::commit();
                    return redirect()->route('dashboard_Admin')->with('success', 'The student has completed all semesters and is now marked as graduated.');
                }

                return redirect()->route('dashboard_Admin')->with('error', 'The student is already registered in the current active semester.');
            }

            if
                (
                    ($studentSemester->number_semester == 1 && $activeSemester->number_semester == 2) ||
                    ($studentSemester->number_semester == 2 && $activeSemester->number_semester == 3)
                )
            {
                $lastActiveSemester->update([
                    'current' => false,
                    'pass' => true,
                ]);

                $semesterInStudentLevel = Semester::where('level_id', $studentSemester->level->id)
                    ->where('number_semester', $activeSemester->number_semester)
                    ->first();

                if (!$semesterInStudentLevel)
                {
                    DB::rollback();
                    return redirect()->route('dashboard_Admin')->with('error', 'Semester not found.');
                }

                SemesterStudent::create([
                    'student_id' => $student->id,
                    'semester_id' => $semesterInStudentLevel->id,
                    'current' => true,
                    'pass' => false,
                ]);
                // dd($result);

                DB::commit();
                return redirect()->route('dashboard_Admin')->with('success', 'Student has been moved to semester ' . $activeSemester->number_semester . ' successfully.');
            }

            if (in_array($studentSemester->number_semester, [2, 3]) && $activeSemester->number_semester == 1)
            {
                $nextLevel = Level::where('category_id', $admin->category_id)
                    ->where('number_level', $studentSemester->level->number_level + 1)
                    ->first();
                // dd($nextLevel);
                if (!$nextLevel)
                {
                    return redirect()->route('dashboard_Admin')->with('error', 'Next level not found.');
                }

                $firstSemesterInNextLevel = Semester::where('level_id', $nextLevel->id)
                    ->where('number_semester', 1)
                    ->first();

                if (!$firstSemesterInNextLevel)
                {
                    return redirect()->route('dashboard_Admin')->with('error', 'First semester of next level not found.');
                }

                $lastActiveSemester->update([
                    'current' => false,
                    'pass' => true,
                ]);

                SemesterStudent::create([
                    'student_id' => $student->id,
                    'semester_id' => $firstSemesterInNextLevel->id,
                    'current' => true,
                    'pass' => false,
                ]);

                // dd($firstSemesterInNextLevel);

                DB::commit();
                return redirect()->route('dashboard_Admin')->with('success', 'Student has been moved to level ' . $nextLevel->number_level . ', semester 1 successfully.');
            }

            DB::rollBack();

            return redirect()->route('dashboard_Admin')->with('error', 'The student cannot be moved to this semester.');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('dashboard_Admin')->with('error', 'An error occurred. Please try again later.');
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admin = Auth::guard('Admin')->user();
        // dd($admin);
        $endStudent = Student::where('category_id', $admin->category_id)
            ->orderBy('id', 'desc')
            ->first();

        // dd($endStudent);
        $code = $endStudent ? $endStudent->code + 1 : 20250001;
        // dd($code);

        return view("Admin.views.students.create", compact("code"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $admin = Auth::guard('Admin')->user();
        $data["category_id"] = $admin->category_id;
        $firstLevel = Level::where('category_id', $admin->category_id)
            ->where('number_level', 1)
            ->first();
        if (!$firstLevel) {
            return redirect()->route('create_student')->with('error', 'Please try again.');
        }

        $firstSemester = Semester::where('level_id', $firstLevel->id)
            ->where("number_semester", 1)
            ->first();
        if (!$firstSemester) {
            return redirect()->route('create_student')->with('error', 'Please try again.');
        }
        // dd($firstSemester);
        $data["email"] = $data["code"] . "@unv.edu.eg";
        $data["password"] = Hash::make($data["code"]);

        DB::beginTransaction();
        try {
            $student = Student::create($data);
            if (!$student) {
                throw new \Exception("Failed to create student");
            }

            $semester = SemesterStudent::create([
                'student_id' => $student->id,
                'semester_id' => $firstSemester->id
            ]);

            if (!$semester) {
                throw new \Exception("Failed to create semester student");
            }

            do {
                $code = $student["code"];
            } while (GeneralPassword::where('general_code', $code)->exists());

            $general_pss = GeneralPassword::create([
                'general_code' => $code,
                'accessible_type' => Student::class,
                'accessible_id' => $student->id,
            ]);

            if (!$general_pss) {
                throw new \Exception('Failed to create general password for student');
            }

            DB::commit();

            return redirect()->route('create_student')->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('create_student')->with('error', 'Failed to create student , please try again.');
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
