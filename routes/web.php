<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('products/export', function () {
    return Excel::download(new ProductsExport, 'products.xlsx');
})->name('products.export');
Route::post('products/import', [ProductController::class, 'import'])->name('products.import');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('', 'index')->name('products');
    Route::get('index', 'index')->name('products.index');
    Route::get('create', 'create')->name('products.create');
    Route::post('store', 'store')->name('products.store');
    Route::get('show/{id}', 'show')->name('products.show');
    Route::get('edit/{id}', 'edit')->name('products.edit');
    Route::put('edit/{id}', 'update')->name('products.update');
    Route::delete('destroy', 'destroy')->name('products.destroy');
});
// Route::group(['middleware' => ['role:super-admin|admin']],function () {
Route::group(['middleware' => ['isAdmin']], function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);

    // Route::get('permissions/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);
    Route::delete('permissions/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);


    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::delete('roles/delete', [App\Http\Controllers\RoleController::class, 'destroy'])
        // ->middleware('permission:delete role')
    ;
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::delete('users/delete', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('permission:delete user');
});
