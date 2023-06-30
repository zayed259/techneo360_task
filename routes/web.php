<?php

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\DashboardController;
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

# Employee panel routes
Route::prefix('/employee')->name('employee.')->middleware(['auth:employee', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

# Admin panel routes
Route::prefix('/admin')->name('admin.')->middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    # Employee routes
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');

    # Employee detail routes
    Route::get('/employee_details/create/{id}', [EmployeeController::class, 'createEmployeeDetail'])->name('employee_details.create');
    Route::post('/employee_details/store', [EmployeeController::class, 'storeEmployeeDetail'])->name('employee_details.store');
    Route::get('/employee_details/{id}', [EmployeeController::class, 'show'])->name('employee_details.show');
    Route::get('/employee_details/{id}/edit', [EmployeeController::class, 'editEmployeeDetail'])->name('employee_details.edit');
    Route::put('/employee_details/{id}', [EmployeeController::class, 'updateEmployeeDetail'])->name('employee_details.update');

    # Employee contact routes
    Route::get('/employee_contacts/create/{id}', [EmployeeController::class, 'createEmployeeContact'])->name('employee_contacts.create');
    Route::post('/employee_contacts/store', [EmployeeController::class, 'storeEmployeeContact'])->name('employee_contacts.store');
    Route::get('/employee_contacts/{id}', [EmployeeController::class, 'showEmployeeContact'])->name('employee_contacts.show');
    Route::get('/employee_contacts/{id}/edit', [EmployeeController::class, 'editEmployeeContact'])->name('employee_contacts.edit');
    Route::put('/employee_contacts/{id}', [EmployeeController::class, 'updateEmployeeContact'])->name('employee_contacts.update');


});

Route::get('/', function () {
    return view('auth.login');
})->name('home')->middleware(['guest:admin', 'guest:employee']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
