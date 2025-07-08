<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Auth\GeneralPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\StudentsInCategoryController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\CategoryController;
use App\Http\Controllers\SuperAdmin\CategoryCourseController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\DoctorController;
use App\Http\Controllers\SuperAdmin\LevelController;
use App\Http\Controllers\SuperAdmin\SemesterController;
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
// login admin
Route::get("/login/admin", [LoginController::class, "LoginAdmin"])->name("login_Admin");
// login doctor
Route::get("/login/doctor", [LoginController::class, "LoginDoctor"])->name("login_Doctor");

// check Credential
Route::post("/login/check", [LoginController::class, "checkCredential"])->name("check_credential");

// Super Admin
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
    Route::get('/dashboard/super/admin/level/create/level/to/category/{category_id}', [LevelController::class, 'create'])->name('create_level');
    Route::post('/dashboard/super/admin/level/store/level', [LevelController::class, 'store'])->name('store_level');
    Route::get('/dashboard/super/admin/level/edit/level/{id}', [LevelController::class, 'edit'])->name('edit_level');
    Route::put('/dashboard/super/admin/level/update/level/{id}', [LevelController::class, 'update'])->name('update_level');

    // admin
    Route::get("/dashboard/super/admin/all/admins", [AdminController::class, "index"])->name("all_admins");
    Route::get("/dashboard/super/admin/create/admin", [AdminController::class, "create"])->name("create_admin");
    Route::post("/dashboard/super/admin/store/admin", [AdminController::class, "store"])->name("store_admin");
    Route::get("/dashboard/super/admin/edit/admin/{id}", [AdminController::class, "edit"])->name("edit_admin");
    Route::put("/dashboard/super/admin/update/admin/{id}", [AdminController::class, "update"])->name("update_admin");
    Route::delete("/dashboard/super/admin/delete/admin/{id}", [AdminController::class, "destroy"])->name("delete_admin");

    // course
    Route::get("/dashboard/super/admin/all/courses", [CourseController::class, "index"])->name("all_courses");
    Route::get("dashboard/super/admin/create/course", [CourseController::class, "create"])->name("create_course");
    Route::post("dashboard/super/admin/store/course", [CourseController::class, "store"])->name("store_course");
    Route::get("dashboard/super/admin/edit/course/{id}", [CourseController::class, "edit"])->name("edit_course");
    Route::put("dashboard/super/admin/update/course/{id}", [CourseController::class, "update"])->name("update_course");
    Route::delete("dashboard/super/admin/delete/course/{id}", [CourseController::class, "destroy"])->name("delete_course");

    // assign course to category
    Route::get('/assign/courses/{id}/to/category', [CategoryCourseController::class, 'create'])->name('category_courses');
    Route::post('/categories/courses/{id}', [CategoryCourseController::class, 'store'])->name('category_courses_store');
    Route::get("/dashboard/super/admin/information/this/category/{id}", [CategoryCourseController::class, "show"])->name("category_courses_show");

    Route::get('/category/{category}/level/{level}/semester/{semester}/courses/edit', [CategoryCourseController::class, 'edit'])
    ->name('edit_courses_category');
    Route::post('/category/{category}/level/{level}/semester/{semester}/courses/update', [CategoryCourseController::class, 'update'])
    ->name('update_courses_category');

    // doctor
    Route::get('/dashboard/super/admin/all/doctors', [DoctorController::class, 'index'])->name('all_doctors');
    Route::get('/dashboard/super/admin/create/doctor', [DoctorController::class, 'create'])->name('create_doctor');
    Route::post('/dashboard/super/admin/store/doctor', [DoctorController::class, 'store'])->name('store_doctor');
    Route::get('/dashboard/super/admin/edit/doctor/{id}', [DoctorController::class, 'edit'])->name('edit_doctor');
    Route::put('/dashboard/super/admin/update/doctor/{id}', [DoctorController::class, 'update'])->name('update_doctor');
    Route::delete('/dashboard/super/admin/delete/doctor/{id}', [DoctorController::class, 'destroy'])->name('delete_doctor');

    // active semester
    Route::get('/dashboard/super/admin/active/semester', [SemesterController::class, 'create'])->name('active_semester');
    Route::post('/dashboard/super/admin/store/active/semester', [SemesterController::class, 'store'])->name('store_active_semester');

    // logout
    Route::post('/logout/super/admin', [LoginController::class, 'logoutSuperAdmin'])->name('logout_SuperAdmin');
});

// Admin
Route::middleware(['auth:Admin'])->group(function () {
    Route::get("/dashboard/admin", [AdminDashboardController::class, "index"])->name("dashboard_Admin");

    // student
    Route::get("/dashboard/admin/student/create", [StudentController::class, "create"])->name("create_student");
    Route::post("/dashboard/admin/student/store", [StudentController::class, "store"])->name("store_student");
    Route::post("/dashboard/admin/search", [StudentController::class, "search"])->name("search");

    // Enrollment
    Route::post("/dashboard/admin/student/enrollment", [EnrollmentController::class, "create"])->name("enrollment");
    Route::post("/dashboard/admin/student/enrollment/store", [EnrollmentController::class, "store"])->name("store_enrollment");

    // logout
    Route::post('/logout/admin', [LoginController::class, 'logoutAdmin'])->name('logout_Admin');
});

// Doctor
Route::middleware(["auth:Doctor"])->group(function(){
    Route::get("/dashboard/doctor", [\App\Http\Controllers\Doctor\DashboardController::class, "index"])->name("dashboard_Doctor");

    // students in soecial category
    Route::get("/dashboard/doctor/{id}/students", [StudentsInCategoryController::class, "index"])->name("all_students");
    Route::put("/dashboard/doctor/edit/grade/student/{id}", [StudentsInCategoryController::class, "update"])->name("update_grade");
});
