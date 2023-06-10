<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Admin\Appointments\CreateAppointmentForm;
use App\Http\Livewire\Admin\Appointments\ListAppointments;
use App\Http\Livewire\Admin\Users\ListUsers;
use App\Http\Livewire\Calendar;
use App\Http\Livewire\Frontend\Categories\All;
use Illuminate\Support\Facades\Route;
define('uploadFile', 'uploads');

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('admin/dashboard', DashboardController::class)->name('admin.dashboard');

Route::get('admin/users', ListUsers::class)->name('admin.users');

Route::get('admin/appointments', ListAppointments::class)->name('admin.appointments');

Route::get('admin/appointments/create', CreateAppointmentForm::class)->name('admin.appointments.create');
Route::get('admin/appointments/edit/{id}', CreateAppointmentForm::class)->name('admin.appointments.edit');

Route::get('admin/calendar', CalendarController::class);


Route::controller(UserController::class)->group(function(){
    Route::get('users', 'index');
    Route::get('users-export', 'export')->name('users.export');
    Route::post('users-import', 'import')->name('users.import');
});
