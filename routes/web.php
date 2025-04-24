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
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\MailSettingController;
use App\Http\Controllers\Backend\MailInquiryController;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');


// News Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show')->where('slug', '[a-z0-9-]+');
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
        Route::delete('bulk-delete', [BlogController::class, 'bulkDelete'])->name('bulkDelete');
        Route::delete('{blog}', [BlogController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('mail-inquiries')->name('mail-inquiries.')->group(function () {
        Route::get('/', [MailInquiryController::class, 'index'])->name('index');
        Route::get('trash', [MailInquiryController::class, 'trash'])->name('trash');
        Route::get('{mailInquiry}', [MailInquiryController::class, 'show'])->name('show');

        Route::post('{mailInquiry}/reply', [MailInquiryController::class, 'reply'])->name('reply');
        Route::put('{mailInquiry}/mark-read', [MailInquiryController::class, 'markAsRead'])->name('mark-read');
        Route::put('{mailInquiry}/mark-unread', [MailInquiryController::class, 'markAsUnread'])->name('mark-unread');
        Route::put('{mailInquiry}/restore', [MailInquiryController::class, 'restore'])->name('restore');
        Route::put('{mailInquiry}/trash', [MailInquiryController::class, 'moveToTrash'])->name('move-to-trash');

        // Bulk actions
        Route::put('bulk-mark-read', [MailInquiryController::class, 'bulkMarkAsRead'])->name('bulk-mark-read');
        Route::put('bulk-mark-unread', [MailInquiryController::class, 'bulkMarkAsUnread'])->name('bulk-mark-unread');
        Route::delete('bulk-destroy', [MailInquiryController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('bulk-trash', [MailInquiryController::class, 'bulkMoveToTrash'])->name('bulk-move-to-trash');
        Route::delete('bulk-restore', [MailInquiryController::class, 'bulkRestore'])->name('bulk-restore');
        Route::delete('{mailInquiry}', [MailInquiryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
        Route::post('/clear-cache', [SettingController::class, 'clearCache'])
            ->name('clear-cache');
    });

    Route::prefix('mail-settings')->name('mail-settings.')->group(function () {
        Route::get('/', [MailSettingController::class, 'index'])->name('index');
        Route::post('/', [MailSettingController::class, 'update'])->name('update');
    });
});
