<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\CompanyController;
use App\Http\Controllers\Backend\Admin\HomeController;
use App\Http\Controllers\Backend\Admin\PendingController;
use App\Http\Controllers\Backend\Admin\RequestsController;
use App\Http\Controllers\Backend\Admin\RolesController;
use App\Http\Controllers\Backend\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Controllers\Frontend\TransactionController;

// Admin Authentication

Route::middleware('guest')->group(function () {

    Route::get('admin/login', [AuthenticatedSessionController::class, 'createAdmin'])
    ->name('admin.login');

Route::post('admin/login', [AuthenticatedSessionController::class, 'storeAdmin']);

});

//admin main functions
// Route::group(['prefix'=> LaravelLocalization::setLocale()],function(){

// Route::prefix('admin')->middleware(['UserType'])->group(function () {


// Route::get('/', [HomeController::class,'index'])->name('admin.home');
// //companies management
// Route::resource('all_companies',CompanyController::class);

// // roles
// Route::resource('roles', RolesController::class)->names([
//     'index'   => 'dashboard.roles.index',
//     'create'  => 'dashboard.roles.create',
//     'store'   => 'dashboard.roles.store',
//     'show'    => 'dashboard.roles.show',
//     'edit'    => 'dashboard.roles.edit',
//     'update'  => 'dashboard.roles.update',
//     'destroy' => 'dashboard.roles.destroy',
// ]);


// // user management
// Route::resource('users',UserController::class) ;

// // admins management
// Route::resource('admins',AdminController::class) ;




// // pendings 

// Route::get('pendings',[PendingController::class,'index'])->name('index.pending') ;
// Route::get('pendings/{id}/edit',[PendingController::class,'edit'])->name('edit.pending') ;
// Route::put('pendings/{id}/edit',[PendingController::class,'update'])->name('update.pending') ;
// Route::get('pendings/{id}',[PendingController::class,'show'])->name('show.pending') ;




// // requests price 

// Route::get('requests/price',[RequestsController::class,'index'])->name('requests.price') ;
// Route::get('price/{id}/edit',[RequestsController::class,'edit'])->name('requests.edit');
// Route::post('price/{id}/store',[RequestsController::class,'update'])->name('requests.store');



// Route::post('/submissions/{id}/mark-as-completed', [TransactionController::class, 'markAsCompleted'])
//     ->name('submissions.markAsCompleted');

// });

// Route::patch('/companies/{company}/mark-as-completed',[PendingController::class, 'markAsCompleted'])->name('companies.markAsCompleted');

// }) ;





// pending payments 
Route::post('pending/session',  [PendingController::class, 'session'])->name('pending.session');
Route::get('pending/success', [PendingController::class, 'success'])->name('pending.success');
