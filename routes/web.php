<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return '<h1>ini adalah halaman tentang aplikasi event hub</h1>';
}); 

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/kontak', function () {
    return view('contact');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});

Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);



Route::get('/app', [HomeController::class,'index']);

Route::get('/checkout/{event}',
    [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}',
    [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show');
Route::get('/ticket', [TicketController::class, 'show'])->name('ticket.show');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


Route::group(['prefix' => 'admin', 'as' =>'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/events', [EventsController::class, 'index'])->name('events.index');  
    Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
    Route::post('/events', [EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventsController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventsController::class, 'destroy'])->name('events.destroy');
    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('partners', PartnerController::class)->except(['show']);
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', EventsController::class);
        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions.index');

        Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions.index');
});
});
