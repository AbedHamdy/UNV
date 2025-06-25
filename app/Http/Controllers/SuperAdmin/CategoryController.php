<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('levels')->paginate();

        return view("SuperAdmin.views.categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("SuperAdmin.views.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $category = Category::create($data);
        if(!$category)
        {
            return redirect()->back()->with('error', 'Failed to create category.');
        }

        return redirect()->route("create_level" , ['category_id' => $category->id])->with('success', 'Category created successfully! Now add levels to this category.');
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
        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with('error', 'Category not found , please try again');
        }

        return view("SuperAdmin.views.categories.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $data = $request->validated();
        // dd($data);
        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with('error', 'Category not found , please try again');
        }

        $category->update($data);
        return redirect()->route("edit_level", ['id' => $category->id])->with('success', 'Category updated successfully. Now you can edit levels for this category.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->back()->with('error', 'Category not found , please try again');
        }

        $category->delete();
        return redirect()->route("all_categories")->with('success', 'Category deleted successfully.');
    }
}
