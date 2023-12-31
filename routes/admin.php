<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;

//Guest Route Group
Route::middleware(['guest'])->group(function () {
    // Admin Auth Route
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');
        Route::get('/forgot-password', 'forgot_password')->name('forgot_password');
    });
});

//Authenticated Admin Route
Route::middleware(['admin:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile_imgUpload',[ProfileController::class,'imgUpload'])->name('profile.img.Upload');
    // update
    Route::put('/profile-update',[ProfileController::class, 'updateProfile'])->name('profile.update');
    // PASSWORD UPDATE
    Route::put('/password_update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(AuthorController::class)->name('author.')->prefix('/backend/author')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/change-status', 'change_status')->name('change_status');
    });

    Route::controller(CategoryController::class)->name('category.')->prefix('/backend/category')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/change-status', 'change_status')->name('change_status');
    });

    Route::controller(SubcategoryController::class)->name('subcategory.')->prefix('/backend/subcategory')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/change-status', 'change_status')->name('change_status');
        Route::get('/get-all-sub-category','getSubcategory')->name('get');
    });


    // Books Route start Here
    Route::controller(BookController::class)->name('books.')->prefix('/backend/books')->group(function(){
        Route::get('/addBooks', 'addBooks')->name('addBooks');
        Route::get('/allBooks', 'allBooks')->name('allBooks');
        Route::post('/storeBook', 'storeBook')->name('storeBook');
        Route::get('/change-status', 'change_status')->name('change_status');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
    });
    // Books Route Ends Here
});
