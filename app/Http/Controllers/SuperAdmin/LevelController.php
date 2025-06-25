<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLevelRequest;
use App\Models\Category;
use App\Models\Level;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create($category_id)
    {
        $category = Category::find($category_id);
        if (!$category)
        {
            return redirect()->route("create_category")->with('error', 'Error creating category.');
        }

        return view("SuperAdmin.views.levels.create", compact("category"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $category = Category::find($data["category_id"]);
        if (!$category)
        {
            return redirect()->route("create_category")->with('error', 'Error creating level. Category not found.');
        }
        // dd($category);

        DB::beginTransaction();
        try
        {
            $createdLevels = [];
            for ($i = 1; $i <= $data['number_level']; $i++)
            {
                $level = Level::create([
                    'category_id' => $category->id,
                    'number_level' => $i,
                ]);

                if (!$level)
                {
                    throw new \Exception("Failed to create level {$i}");
                }

                $createdLevels[] = $level;

                for ($j = 1; $j <= 3; $j++)
                {
                    $semester = Semester::create([
                        'number_semester' => $j,
                        'level_id' => $level->id,
                    ]);

                    if (!$semester)
                    {
                        throw new \Exception("Failed to create semester {$j} for level {$i}");
                    }
                }
            }
            DB::commit();
            return redirect()->route('create_category')->with('success', 'Levels and Semesters created successfully');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            $category = Category::find($data["category_id"]);
            $category->delete();
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Failed to create levels and semesters , please try again');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        if (!$category)
        {
            return redirect()->route("all_categories")->with('error', 'please try again');
        }

        $levelsCount = Level::where('category_id', $category->id)->count();
        // dd($levelsCount);

        return view("SuperAdmin.views.levels.edit", compact("category", "levelsCount"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'levels_count' => 'required|integer|min:1|max:10',
        ]);

        $category = Category::find($id);
        if (!$category)
        {
            return redirect()->route("all_categories")->with('error', 'please try again');
        }

        DB::beginTransaction();
        try
        {
            $levels = Level::where('category_id', $category->id)->get();
            foreach ($levels as $level)
            {
                $level->delete();
            }

            for ($i = 1; $i <= $data['levels_count']; $i++)
            {
                $level = Level::create([
                    'category_id' => $category->id,
                    'number_level' => $i,
                ]);

                if (!$level)
                {
                    throw new \Exception("Failed to create level {$i}");
                }

                for ($j = 1; $j <= 3; $j++)
                {
                    Semester::create([
                        'number_semester' => $j,
                        'level_id' => $level->id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('all_categories', ['id' => $category->id])->with('success', 'Levels updated successfully');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update levels , please try again');
        }
    }
}
