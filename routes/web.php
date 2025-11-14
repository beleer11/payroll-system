<?php

use App\Http\Controllers\ChargeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);

    // Rutas principales de charges
    Route::resource('charges', ChargeController::class);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('employees/cities/{country}', [EmployeeController::class, 'getCities'])->name('employees.cities');
    Route::post('/employees/delete-multiple', [EmployeeController::class, 'destroyMultiple'])->name('employees.destroy-multiple');

    // Rutas específicas para charges
    Route::get('/charges/find-employee/{identification}', [ChargeController::class, 'findEmployee'])->name('charges.find-employee');
    Route::post('/charges/delete-multiple', [ChargeController::class, 'destroyMultiple'])->name('charges.destroy-multiple');

    // Rutas para editar asignaciones (usando EmployeeCharge)
    Route::get('/employee-charges/{employeeCharge}/edit', [ChargeController::class, 'editAssignment'])
        ->name('employee-charges.edit');
    Route::put('/employee-charges/{employeeCharge}', [ChargeController::class, 'updateAssignment'])
        ->name('employee-charges.update');

    // Ruta para eliminar asignaciones individuales
    Route::delete('/employee-charges/{employeeCharge}', [ChargeController::class, 'destroy'])
        ->name('employee-charges.destroy');
});
