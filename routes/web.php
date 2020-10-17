<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'throttle:website'], function () {
    Route::get('/', [\App\Http\Controllers\Website\SiteController::class, 'index'])->name('website.index');
    Route::get('website/banner', [\App\Http\Controllers\Website\SiteController::class, 'all_banner']);
    Route::get('website/cv/info', [\App\Http\Controllers\Website\SiteController::class, 'all_cvInfo']);
    Route::get('blog', [\App\Http\Controllers\Website\SiteController::class, 'blog'])->name('website.blog');
    Route::get('blog/{id}', [\App\Http\Controllers\Website\SiteController::class, 'blog_single'])->name('website.blog.id');
    Route::get('blog/by/category/{id}', [\App\Http\Controllers\Website\SiteController::class, 'blog_by_cat'])->name('website.blog.cat');
});

Route::get('/admin/authentication/attempt', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');

Route::post('/admin/authentication/attempt', [\App\Http\Controllers\Admin\AuthController::class, 'loginnow'])->name('login')->middleware('throttle:admin');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'throttle:admin']], function () {
    Route::get('/', function () {
        return redirect()->route('banner.index');
    })->name('admin.index');
    Route::get('/user', function () {
        return view('admin.components.user');
    })->name('user.index');
    Route::post('/user/change/avatar', [\App\Http\Controllers\Admin\UserController::class, 'changeAvatar']);
    Route::post('/user/personal/info', [\App\Http\Controllers\Admin\UserController::class, 'personalInfo']);
    Route::post('/user/contact', [\App\Http\Controllers\Admin\UserController::class, 'addContact']);
    Route::get('/user/contact', [\App\Http\Controllers\Admin\UserController::class, 'getContact']);
    Route::delete('/user/contact/{id}', [\App\Http\Controllers\Admin\UserController::class, 'deleteContact']);
    //user info
    Route::post('/user/info', [\App\Http\Controllers\Admin\UserController::class, 'saveInfo']);
    Route::post('/user/address', [\App\Http\Controllers\Admin\UserController::class, 'saveAddress']);
    Route::post('/user/bio', [\App\Http\Controllers\Admin\UserController::class, 'saveBio']);


    Route::post('/admin/authentication/attempt', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    Route::resource('banner', \App\Http\Controllers\Admin\BannerController::class);

    Route::post('custom/banner/active/{id}', [\App\Http\Controllers\Admin\BannerController::class, 'bannerActive']);

    Route::post('custom/banners/deactivate/{id}', [\App\Http\Controllers\Admin\BannerController::class, 'bannerDeactivate']);
    Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class);
    Route::post('blogs/category', [\App\Http\Controllers\Admin\BlogController::class, 'blog_cat_create']);
    Route::get('blogs/delete/items', [\App\Http\Controllers\Admin\BlogController::class, 'all_deleted_items']);
    Route::delete('blogs/category/delete/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'blog_cat_delete']);
    Route::delete('blogs/category/force/delete/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'blog_cat_force_delete']);
    Route::delete('blogs/deactivate/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'blog_deactivate']);
    Route::post('blogs/activate/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'blog_activate']);
    Route::post('blogs/category/recover/{id}', [\App\Http\Controllers\Admin\BlogController::class, 'blog_cat_recover']);
    Route::get('blogs/category', [\App\Http\Controllers\Admin\BlogController::class, 'blog_cat']);
    Route::resource('cvmaker', \App\Http\Controllers\Admin\CvController::class);
    Route::delete('cvmaker/delete/{id}/{type}', [\App\Http\Controllers\Admin\CvController::class, 'destroy']);
});

