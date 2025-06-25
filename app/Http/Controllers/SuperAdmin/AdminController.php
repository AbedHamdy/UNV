<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAdminRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\GeneralPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('category')->paginate();
        // dd($admins);
    
        return view("SuperAdmin.views.admins.index", compact("admins"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("SuperAdmin.views.admins.create" , compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        $category = Category::find($data['category_id']);
        if (!$category)
        {
            return redirect()->back()->with('error', 'Please try again.');
        }

        $newImage = null;

        DB::beginTransaction();

        try
        {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $newImage = time() . rand(10000, 50000) . "." . $ext;

                $path = public_path('images/admins');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $image->move($path, $newImage);
                $data['image'] = $newImage;
            }

            $data['password'] = Hash::make($data['password']);

            $admin = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'image' => $data['image'] ?? null,
                'category_id' => $data['category_id'],
            ]);

            if (!$admin)
            {
                throw new \Exception('Failed to create admin');
            }

            // dd($admin);

            do
            {
                $code = random_int(10000, 99999);
            } while (GeneralPassword::where('general_code', $code)->exists());

            // dd($code);
            $general_pss = GeneralPassword::create([
                'general_code' => $code,
                'accessible_type' => Admin::class,
                'accessible_id' => $admin->id,
            ]);

            // dd($general_pss);

            if (!$general_pss)
            {
                throw new \Exception('Failed to create general password');
            }

            DB::commit();

            return redirect()->route('create_admin')->with('success', 'Admin created successfully');
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            if ($newImage && File::exists(public_path('images/admins/' . $newImage)))
            {
                File::delete(public_path('images/admins/' . $newImage));
            }

            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $categories = Category::all();
        // dd($admin);
        return view('SuperAdmin.views.admins.edit', compact('admin', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditAdminRequest $request, string $id)
    {
        $data = $request->validated();
        // dd($data);
        $admin = Admin::findOrFail($id);
        $category = Category::find($data['category_id']);
        if (!$category)
        {
            return redirect()->back()->with('error', 'Please try again.');
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

                $path = public_path('images/admins');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($admin->image && File::exists(public_path('images/admins/' . $admin->image)))
                {
                    File::delete(public_path('images/admins/' . $admin->image));
                }

                $image->move($path, $newImage);
                $data['image'] = $newImage;
            }
            else
            {
                $data['image'] = $admin->image;
            }

            if (isset($data['password']) && !empty($data['password']))
            {
                $data['password'] = Hash::make($data['password']);
            }
            else 
            {
                unset($data['password']);
            }

            $admin->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => isset($data['password']) ? $data['password'] : $admin->password,
                'image' => isset($data['image']) ? $data['image'] : null,
                'category_id' => $data['category_id'],
            ]);

            DB::commit();

            return redirect()->route('all_admins', ['id' => $id])->with('success', 'Admin updated successfully');
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            if ($newImage && File::exists(public_path('images/admins/' . $newImage)))
            {
                File::delete(public_path('images/admins/' . $newImage));
            }

            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin)
        {
            return redirect()->back()->with('error', 'Admin not found , please try again.');
        }
        $admin->delete();
        return redirect()->route('all_admins')->with('success', 'Admin deleted successfully.');
    }
}
