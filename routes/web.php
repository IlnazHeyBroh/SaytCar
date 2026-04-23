<?php

use App\Http\Controllers\Admin\AdminBbController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BbsController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/home/create', [HomeController::class, 'create'])->name('bb.create');
    Route::post('/home', [HomeController::class, 'store'])->name('bb.store');
    Route::get('/home/{bb}/edit', [HomeController::class, 'edit'])->name('bb.edit');
    Route::patch('/home/{bb}', [HomeController::class, 'update'])->name('bb.update');
    Route::get('/home/{bb}/delete', [HomeController::class, 'delete'])->name('bb.delete');
    Route::delete('/home/{bb}', [HomeController::class, 'destroy'])->name('bb.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{bb}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{bb}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/messages', [ConversationController::class, 'index'])->name('messages.index');
    Route::post('/messages/start/{bb}', [ConversationController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}', [ConversationController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [ConversationController::class, 'send'])->name('messages.send');
    Route::delete('/messages/{conversation}', [ConversationController::class, 'destroy'])->name('messages.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/cars', [AdminBbController::class, 'index'])->name('bbs.index');
    Route::get('/cars/create', [AdminBbController::class, 'create'])->name('bbs.create');
    Route::post('/cars', [AdminBbController::class, 'store'])->name('bbs.store');
    Route::get('/cars/{bb}/edit', [AdminBbController::class, 'edit'])->name('bbs.edit');
    Route::put('/cars/{bb}', [AdminBbController::class, 'update'])->name('bbs.update');
    Route::patch('/cars/{bb}/approve', [AdminBbController::class, 'approve'])->name('bbs.approve');
    Route::patch('/cars/{bb}/reject', [AdminBbController::class, 'reject'])->name('bbs.reject');
    Route::delete('/cars/{bb}', [AdminBbController::class, 'destroy'])->name('bbs.destroy');

    Route::get('/brands', [AdminBrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [AdminBrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [AdminBrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [AdminBrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [AdminBrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/', [BbsController::class, 'index'])->name('index');
Route::get('/catalog', [BbsController::class, 'catalog'])->name('catalog');
Route::get('/about', [BbsController::class, 'about'])->name('about');
Route::get('/contact', [BbsController::class, 'contact'])->name('contact');
Route::get('/blog', [BbsController::class, 'blog'])->name('blog');
Route::get('/sell', [BbsController::class, 'sell'])->name('sell');
Route::get('/calculator', [BbsController::class, 'calculator'])->name('calculator');
Route::get('/brands', [BbsController::class, 'brands'])->name('brands');
Route::get('/team', [BbsController::class, 'team'])->name('team');

Route::get('/{bb}', [BbsController::class, 'detail'])
    ->where('bb', '^[0-9]+$')
    ->name('detail');
