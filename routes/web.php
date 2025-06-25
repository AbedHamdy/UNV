<?php

use App\Http\Controllers\Auth\GeneralPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\LevelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", [GeneralPasswordController::class, "index"])->name("home");

Route::post("/general-password", [GeneralPasswordController::class, "check"])->name("check_password");

// login super admin
Route::get("/login/super/admin", [LoginController::class, "LoginSuperAdmin"])->name("login_SuperAdmin");

// check Credential
Route::post("/login/check", [LoginController::class, "checkCredential"])->name("check_credential");

Route::middleware(['auth:SuperAdmin'])->group(function () {
    Route::get("/dashboard/super/admin", [DashboardController::class, "index"])->name("dashboard_SuperAdmin");

    // categories
    Route::get("/dashboard/super/admin/all/categories", [CategoryController::class, "index"])->name("all_categories");
    Route::get("/dashboard/super/admin/create/category", [CategoryController::class, "create"])->name("create_category");
    Route::post("/dashboard/super/admin/store/category", [CategoryController::class, "store"])->name("store_category");
    Route::get("/dashboard/super/admin/edit/category/{id}", [CategoryController::class, "edit"])->name("edit_category");
    Route::put("/dashboard/super/admin/update/category/{id}", [CategoryController::class, "update"])->name("update_category");
    Route::delete("/dashboard/super/admin/delete/category/{id}", [CategoryController::class, "destroy"])->name("delete_category");

    // level
    Route::get('/admin/level/create/level/to/category/{category_id}', [LevelController::class, 'create'])->name('create_level');
    Route::post('/admin/level/store/level', [LevelController::class, 'store'])->name('store_level');
    Route::get('/admin/level/edit/level/{id}', [LevelController::class, 'edit'])->name('edit_level');
    Route::put('/admin/level/update/level/{id}', [LevelController::class, 'update'])->name('update_level');

    // admin
    Route::get("/dashboard/super/admin/all/admins", [AdminController::class, "index"])->name("all_admins");
    Route::get("/dashboard/super/admin/create/admin", [AdminController::class, "create"])->name("create_admin");
    Route::post("/dashboard/super/admin/store/admin", [AdminController::class, "store"])->name("store_admin");
    Route::get("/dashboard/super/admin/edit/admin/{id}", [AdminController::class, "edit"])->name("edit_admin");
    Route::put("/dashboard/super/admin/update/admin/{id}", [AdminController::class, "update"])->name("update_admin");
    Route::delete("/dashboard/super/admin/delete/admin/{id}", [AdminController::class, "destroy"])->name("delete_admin");
});