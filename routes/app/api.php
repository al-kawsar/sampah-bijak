<?php

use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\HomepageSliderController;
use App\Http\Controllers\Dashboard\FAQController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\LearningModuleController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PickupScheduleController;
use App\Http\Controllers\Dashboard\RegionController;
use App\Http\Controllers\Dashboard\EventParticipantController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\UserProfileController;
use App\Http\Controllers\Dashboard\WasteCategoryController;
use App\Http\Controllers\Dashboard\WasteItemController;
use App\Http\Controllers\Dashboard\WasteLocationController;
use App\Http\Controllers\Dashboard\WasteReminderController;
use App\Http\Controllers\Dashboard\WasteReportController;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {

    // * HOMEPAGE API
    Route::get('/contacts', [ContactMessageController::class, 'getData'])->withoutMiddleware('auth')->name('contacts.api');
    Route::get('/sliders', [HomepageSliderController::class, 'getData'])->withoutMiddleware('auth')->name('sliders.api');
    Route::get('/faqs', [FAQController::class, 'getData'])->withoutMiddleware('auth')->name('faqs.api');


    // * DASHBOARD API
    Route::get('/events', [EventController::class, 'getData'])->withoutMiddleware('auth')->name('events.api');
    Route::get('/event-participants', [EventParticipantController::class, 'getData'])->name('event-participants.api');
    Route::put('/events/{id:id}', [EventController::class, 'update'])->name('events.update');

    // EVENT participant
    Route::get('/learnings', [LearningModuleController::class, 'getData'])->withoutMiddleware('auth')->name('learnings.api');
    Route::get('/learnings/{id}', [LearningModuleController::class, 'getDetailData'])->name('learnings.api.detail');

    Route::get('/notifications', [NotificationController::class, 'getData'])->name('notifications.api');

    Route::get('/pickup-schedules', [PickupScheduleController::class, 'getData'])->name('pickup-schedules.api');
    Route::get('/pickup-schedules/oos', [PickupScheduleController::class, 'getDetailData'])->name('pickup-schedules.detail');

    Route::get('/regions', [RegionController::class, 'getData'])->withoutMiddleware('auth')->name('regions.api');
    Route::get('/roles', [RoleController::class, 'getData'])->name('roles.api');
    Route::get('/users', [UserController::class, 'getData'])->name('users.api');
    Route::get('/user/profile', [UserProfileController::class, 'getData'])->name('user-profile.api');
    Route::get('/waste-categories', [WasteCategoryController::class, 'getData'])->withoutMiddleware('auth')->name('waste-categories.api');
    Route::get('/waste-items', [WasteItemController::class, 'getData'])->name('waste-items.api');
    Route::get('/waste-locations', [WasteLocationController::class, 'getData'])->withoutMiddleware('auth')->name('waste-locations.api');
    Route::get('/waste-reminders', [WasteReminderController::class, 'getData'])->name('waste-reminders.api');
    Route::get('/waste-reports', [WasteReportController::class, 'getData'])->name('waste-reports.api');

});