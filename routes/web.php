<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Livewire\Counter;
use App\Http\Controllers\AcademiqueController;
use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\CycleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    //academique
    Route::get('/academique', [AcademiqueController::class, 'index']);
    Route::post('/storeAcademique', [AcademiqueController::class, 'store'])->name('store_academique');
    Route::get('/fetchallAcademique', [AcademiqueController::class, 'fetchAll'])->name('fetchAll_academique');
    Route::delete('/deleteAcademique', [AcademiqueController::class, 'delete'])->name('delete_academique');
    Route::get('/editAcademique', [AcademiqueController::class, 'edit'])->name('edit_academique');
    Route::post('/updateAcademique', [AcademiqueController::class, 'update'])->name('update_academique');

    //annee academique
    Route::get('/anneeacademique', [AnneeAcademiqueController::class, 'index'])->name('annee_academique');
    Route::post('/storeAnneeAcademique', [AnneeAcademiqueController::class, 'store'])->name('store_annee_academique');
    Route::get('/fetchallAnneeAcademique', [AnneeAcademiqueController::class, 'fetchAll'])->name('fetchAll_annee_academique');
    Route::delete('/deleteAnneeAcademique', [AnneeAcademiqueController::class, 'delete'])->name('delete_annee_academique');
    Route::get('/editAnneeAcademique', [AnneeAcademiqueController::class, 'edit'])->name('edit_annee_academique');
    Route::post('/updateAnneeAcademique', [AnneeAcademiqueController::class, 'update'])->name('update_annee_academique');

    //cycle
    Route::get('/cycle-list',[CycleController::class, 'index'])->name('cycles.list');
    Route::post('/add-cycle',[CycleController::class,'addCycle'])->name('add.cycle');
    Route::get('/getCycleList',[CycleController::class, 'getCycleList'])->name('get.cycles.list');
    Route::post('/getCycleDetails',[CycleController::class, 'getCycleDetails'])->name('get.cycle.details');
    Route::post('/updateCycleDetails',[CycleController::class, 'updateCycleDetails'])->name('update.cycle.details');
    Route::post('/deleteCycle',[CycleController::class,'deleteCycle'])->name('delete.cycle');
    Route::post('/deleteSelectedCycles',[CycleController::class,'deleteSelectedCycles'])->name('delete.selected.cycles');
});
