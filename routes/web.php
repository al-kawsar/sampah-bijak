<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Home\HomeController;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\HomepageSliderController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\EventParticipantController;
use App\Http\Controllers\Dashboard\LearningModuleController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PickupScheduleController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\WasteCategoryController;
use App\Http\Controllers\Dashboard\WasteItemController;
use App\Http\Controllers\Dashboard\WasteLocationController;
use App\Http\Controllers\Dashboard\WasteReminderController;
use App\Http\Controllers\Dashboard\WasteReportController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\FileSystemController;

use Illuminate\Support\Facades\Route;

Route::name('home.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
});

Route::name('auth.')->prefix('auth')->middleware('guest')->group(function () {
    Route::controller(LoginController::class)->prefix('login')->group(function () {
        Route::get('/', 'showLoginForm')->name('login.index');
        Route::post('/', 'doLogin')->name('login.submit');
    });
    Route::controller(RegisterController::class)->prefix('register')->group(function () {
        Route::get('/', 'showRegisterForm')->name('register.index');
        Route::post('/', 'doRegister')->name('register.submit');
    });

    Route::match(['get', 'post'], 'logout', [LogoutController::class, 'logout'])->WithoutMiddleware('guest')->middleware('auth')->name('logout');

});


Route::name('app.')->middleware('auth')->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    require_once __DIR__ . '/app/api.php';


    // * HOMEPAGE
    Route::resource('contacts', ContactMessageController::class)->parameters(['contacts' => 'id:id']);
    Route::resource('sliders', HomepageSliderController::class)->parameters(['sliders' => 'id:id']);
    Route::resource('faqs', FAQController::class)->parameters(['faqs' => 'id:id']);

    // * DASHBOARD
    Route::resource('events', EventController::class)
    ->parameters(['events' => 'id:id'])
    ->except(['update']);
    Route::resource('event-participants', EventParticipantController::class)->parameters(['event-participants' => 'id:id']);
    Route::resource('learnings', LearningModuleController::class)->parameters(['learnings' => 'id:id']);
    Route::resource('notifications', NotificationController::class)->parameters(['notifications' => 'id:id']);

    Route::get('pickup-schedules/history', [PickupScheduleController::class, 'histroyPage'])->name('pickup-schedules.history');
    Route::resource('pickup-schedules', PickupScheduleController::class)->parameters(['pickup-schedules' => 'id:id']);


    Route::resource('regions', RegionController::class)->parameters(['regions' => 'id:id']);
    Route::resource('roles', RoleController::class)->parameters(['roles' => 'id:id']);
    Route::resource('users', UserController::class)->parameters(['users' => 'id:id']);
    Route::resource('waste-categories', WasteCategoryController::class)->parameters(['waste-categories' => 'id:id']);
    Route::resource('waste-items', WasteItemController::class)->parameters(['waste-items' => 'id:id']);

    Route::get('locations', [WasteLocationController::class, 'location'])->name('waste-locations.location');
    Route::resource('waste-locations', WasteLocationController::class)->parameters(['waste-locations' => 'id:id']);

    Route::resource('waste-reminders', WasteReminderController::class)->parameters(['waste-reminders' => 'id:id']);
    Route::resource('waste-reports', WasteReportController::class)->parameters(['waste-reports' => 'id:id']);


    Route::name('settings.')->controller(SettingController::class)->prefix('settings')->group(function () {
        Route::get('profile', 'profilePage')->name('profile');
        Route::get('account', 'accountPage')->name('account');
    });

});

Route::middleware('auth')->group(function () {
    Route::post('/file/upload', [FileSystemController::class, 'upload'])->name('file.upload');
});