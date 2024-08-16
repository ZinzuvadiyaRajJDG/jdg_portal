<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CareersConroller;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OTController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebpageController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', [WebpageController::class, 'FrontIndex']);

  
Auth::routes();
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    
    Route::post('/careers/update-status', [CareersConroller::class, 'updateStatus'])->name('careers.update_status');
    Route::resource('careers', CareersConroller::class);

    Route::resource('permissions', PermissionsController::class);
    
    Route::resource('users', UserController::class);
    Route::post('users/status/{id}', [UserController::class,'changeStatus']);
    
    Route::resource('teams', TeamController::class);
    Route::post('teams/status/{id}', [TeamController::class,'changeStatus']);
    
    Route::resource('products', ProductController::class);
    
    Route::get('profile', [ProfileController::class,'index']);
    Route::get('edit_profile', [ProfileController::class,'edit_profile']);
    Route::post('update_profile', [ProfileController::class,'update']);

    Route::get('change_password', [ChangePasswordController::class,'displaychangepassword']);
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

    Route::get('/attendance/clockout', [AttendanceController::class,'clockoutdisplay']);
    Route::get('/attendance/user/{id}', [AttendanceController::class,'adminShow']);
    Route::post('/attendance/clockout', [AttendanceController::class,'clockout']);
    Route::resource('attendance', AttendanceController::class);
    Route::post('/attendance/clock-pause', [AttendanceController::class,'clockPause']);
    Route::post('/attendance/clock-resume', [AttendanceController::class,'clockResume']);
    Route::post('attendance/update-status', [AttendanceController::class,'updateStatus']);


    Route::resource('holiday', HolidayController::class);

    Route::get('webpage/banner/create', [WebpageController::class,'BannerCreate']);
    Route::post('webpage/banner/store', [WebpageController::class,'BannerStore'])->name('webpage.banner.store');

    Route::get('webpage/notice/create', [WebpageController::class,'NoticeCreate']);
    Route::post('webpage/notice/store', [WebpageController::class,'NoticeStore'])->name('webpage.notice.store');
    
    Route::get('webpage/iconlink/index', [WebpageController::class,'IconLink']);
    Route::get('webpage/iconlink/create', [WebpageController::class,'IconLinkCreate']);
    Route::post('webpage/iconlink/store', [WebpageController::class,'IconLinkStore'])->name('webpage.iconlink.store');
    Route::get('webpage/iconlink/edit/{id}', [WebpageController::class, 'IconLinkEdit'])->name('webpage.iconlink.edit');
    Route::post('webpage/iconlink/update/{id}', [WebpageController::class, 'IconLinkUpdate'])->name('webpage.iconlink.update');
    Route::delete('webpage/iconlink/destroy/{id}', [WebpageController::class, 'IconLinkDestroy'])->name('webpage.iconlink.destroy');
    
    Route::get('webpage/quicklink/index', [WebpageController::class,'QuickLink']);
    Route::get('webpage/quicklink/create', [WebpageController::class,'QuickLinkCreate']);
    Route::post('webpage/quicklink/store', [WebpageController::class,'QuickLinkStore'])->name('webpage.quicklink.store');
    Route::get('webpage/quicklink/edit/{id}', [WebpageController::class, 'QuickLinkEdit'])->name('webpage.quicklink.edit');
    Route::post('webpage/quicklink/update/{id}', [WebpageController::class, 'QuickLinkUpdate'])->name('webpage.quicklink.update');
    Route::delete('webpage/quicklink/destroy/{id}', [WebpageController::class, 'QuickLinkDestroy'])->name('webpage.quicklink.destroy');
    
    Route::resource('webpage', WebpageController::class);

    Route::resource('kpipoints', KpiController::class);

    Route::resource('leave', LeaveController::class);
    Route::post('leave/update-status',[LeaveController::class,'updateStatus']);

    Route::resource('salary', SalaryController::class);
    Route::post('update-salary-status', [SalaryController::class, 'updateSalaryStatus']);


    Route::get('overtime/clockout', [OTController::class,'clockoutdisplay'])->name('overtime.clockoutdisplay');
    Route::resource('overtime', OTController::class);
    Route::post('overtime/clockout', [OTController::class,'clockout'])->name('overtime.clockout');


});


Route::get('/migrate', function () {
    Artisan::call('migrate --path=/database/migrations/2024_08_09_072940_add_user_id_column_in_kpipoints_table.php');
    return "MIGRATE SUCCESS";
})->name('migrate');


Route::get('/migration', function () {
    Artisan::call('make:migration add_user_id_column_in_kpipoints_table');
    return "MIGRATION SUCCESS";
});

Route::get('/controller', function () {
    Artisan::call('make:controller KpiController');
    return "CONTROLLER SUCCESS";
});

Route::get('/model', function () {
    Artisan::call('make:model Kpipoint');
    return "MODEL SUCCESS";
});