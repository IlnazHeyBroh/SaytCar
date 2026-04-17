<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BbsController;
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

// Authentication routes (должны быть ПЕРВЫМИ)
Auth::routes();

// Protected routes (require authentication) - ДОЛЖНЫ БЫТЬ ПЕРЕД ПУБЛИЧНЫМИ
// Явно регистрируем /home ПЕРВЫМ, чтобы он точно не перехватывался другими маршрутами
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    // BB management routes
    Route::get('/home/create', [HomeController::class, 'create'])->name('bb.create');
    Route::post('/home', [HomeController::class, 'store'])->name('bb.store');
    Route::get('/home/{bb}/edit', [HomeController::class, 'edit'])->name('bb.edit');
    Route::patch('/home/{bb}', [HomeController::class, 'update'])->name('bb.update');
    Route::get('/home/{bb}/delete', [HomeController::class, 'delete'])->name('bb.delete');
    Route::delete('/home/{bb}', [HomeController::class, 'destroy'])->name('bb.destroy');
});

// Public routes
Route::get('/', [BbsController::class, 'index'])->name('index');
Route::get('/catalog', [BbsController::class, 'catalog'])->name('catalog');
Route::get('/about', [BbsController::class, 'about'])->name('about');
Route::get('/contact', [BbsController::class, 'contact'])->name('contact');
Route::get('/blog', [BbsController::class, 'blog'])->name('blog');
Route::get('/sell', [BbsController::class, 'sell'])->name('sell');
Route::get('/calculator', [BbsController::class, 'calculator'])->name('calculator');
Route::get('/brands', [BbsController::class, 'brands'])->name('brands');
Route::get('/team', [BbsController::class, 'team'])->name('team');

// Детальная страница объявления (должна быть ПОСЛЕДНЕЙ, только числовые ID)
// Используем более строгое условие, чтобы исключить все известные пути
Route::get('/{bb}', [BbsController::class, 'detail'])
    ->where('bb', '^[0-9]+$')
    ->name('detail');