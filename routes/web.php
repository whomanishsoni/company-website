<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\JoinController;

// Backend Controllers
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\MemberController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BlogController;

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

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home'); // Home page
Route::get('/services', [HomeController::class, 'services'])->name('services'); // Services page
Route::get('/about', [HomeController::class, 'about'])->name('about'); // About page
Route::get('/contact', [HomeController::class, 'contact'])->name('contact'); // Contact page

// News Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index'); // News page
    Route::get('/{id}', [NewsController::class, 'show'])->name('show'); // Single news page
});

// Join Routes
Route::prefix('join')->name('join.')->group(function () {
    Route::get('/', [JoinController::class, 'index'])->name('index'); // Join page
    Route::post('/', [JoinController::class, 'store'])->name('store'); // Join form submission
});

// Authentication Routes (login, register, password reset, etc.)
Auth::routes();

// Backend Routes (Protected by auth middleware)
Route::middleware('auth')->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customer Routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('search', [CustomerController::class, 'search'])->name('search');
        Route::get('data', [CustomerController::class, 'data'])->name('data');
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // User Routes
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Member Routes
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('create', [MemberController::class, 'create'])->name('create');
        Route::post('/', [MemberController::class, 'store'])->name('store');
        Route::get('{member}', [MemberController::class, 'show'])->name('show');
        Route::get('{member}/edit', [MemberController::class, 'edit'])->name('edit');
        Route::put('{member}', [MemberController::class, 'update'])->name('update');
        Route::delete('{member}', [MemberController::class, 'destroy'])->name('destroy');
    });

    // Category Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Tag Routes
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('{tag}', [TagController::class, 'show'])->name('show');
        Route::get('{tag}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('{tag}', [TagController::class, 'destroy'])->name('destroy');
    });

    // Blog Routes
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('create', [BlogController::class, 'create'])->name('create');
        Route::post('/', [BlogController::class, 'store'])->name('store');
        Route::get('{blog}', [BlogController::class, 'show'])->name('show');
        Route::get('{blog}/edit', [BlogController::class, 'edit'])->name('edit');
        Route::put('{blog}', [BlogController::class, 'update'])->name('update');
        Route::delete('{blog}', [BlogController::class, 'destroy'])->name('destroy');
    });

});