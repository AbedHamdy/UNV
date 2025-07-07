<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
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
    public function create()
    {
        return view('SuperAdmin.views.semester_active.active');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'semester' => 'required|in:1,2,3',
        ]);

        // مصفوفة بأسماء الترمات
        $semesterNames = [
            1 => 'First Semester',
            2 => 'Second Semester',
            3 => 'Summer Semester',
        ];

        DB::beginTransaction();
        try
        {
            Semester::query()->update(['status' => false]);
            Semester::where("number_semester", $data['semester'])
                ->update(["status" => true]);

            DB::commit();

            $semesterName = $semesterNames[$data['semester']];
            return redirect()->route("dashboard_SuperAdmin")->with('success', 'The ' . $semesterName . ' has been activated successfully.');

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }
}
