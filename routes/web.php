<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| AUTHENTICATED (SEMUA ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('pegawai')) {
            return redirect()->route('pegawai.dashboard');
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        abort(403, 'User does not have the right roles.');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.update');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('/users', UserController::class);
    Route::resource('/books', BookController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/loans', [LoanController::class, 'adminIndex'])->name('admin.loans.index');
});

/*
|--------------------------------------------------------------------------
| PEGAWAI ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|pegawai'])->prefix('pegawai')->group(function () {

    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');

    Route::resource('/books', BookController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::resource('/loans', LoanController::class);  
});


Route::prefix('pegawai')->middleware(['auth', 'role:pegawai'])->group(function () {
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('pegawai.dashboard');
    Route::get('/loans/create', [PegawaiController::class, 'createLoan'])->name('loans.create');  // Adjust controller/method as needed
});

Route::middleware(['auth', 'role:pegawai|admin'])->prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/books', [AdminBookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [AdminBookController::class, 'show'])->name('books.show');

});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::post('/loans', [LoanController::class, 'store'])->name('mahasiswa.loans.store');
});

/*
|--------------------------------------------------------------------------
| MAHASISWA ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {

    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');

    Route::get('/loans', [LoanController::class, 'index'])->name('mahasiswa.loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('mahasiswa.loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('mahasiswa.loans.store');

    Route::post('/loans/{loan}/extend', [LoanController::class, 'extend'])->name('mahasiswa.loans.extend');
    Route::post('/loans/{loan}/renew', [LoanController::class, 'renew'])->name('mahasiswa.loans.renew');

    Route::get('/loans/history', [LoanController::class, 'history'])->name('mahasiswa.loans.history');
    Route::get('/loans/recommendations', [LoanController::class, 'recommendations'])->name('mahasiswa.loans.recommendations');


    Route::get('/books/{id}', [BookController::class, 'show'])->name('mahasiswa.books.show');

    Route::get('/loans/{loan}/review', [ReviewController::class, 'create'])->name('loans.review');
    Route::post('/loans/{loan}/review', [ReviewController::class, 'store'])->name('loans.review.store');
});


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('books', BookController::class);
    });

Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {
        Route::resource('books', BookController::class);
    });

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/reservations', [\App\Http\Controllers\ReservationController::class, 'index'])
        ->name('mahasiswa.reservations.index');

    Route::post('/reservations', [\App\Http\Controllers\ReservationController::class, 'store'])
        ->name('mahasiswa.reservations.store');  
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/analytics', [App\Http\Controllers\AdminController::class, 'analytics'])->name('admin.analytics');
});


Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->group(function () {
    Route::get('/loans/create', [PegawaiController::class, 'createLoan'])
        ->name('pegawai.loans.create');

 

});




Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa']) // middleware opsional, sesuaikan
    ->group(function () {
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
    });


    Route::prefix('dashboard')->middleware(['auth', 'role:admin,pegawai'])->group(function () {
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
});
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])
    ->name('mahasiswa.reservations.destroy');


Route::middleware(['auth'])->group(function () {
    Route::get('/pegawai/reservations', [ReservationController::class, 'index'])->name('pegawai.reservations.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');
});

Route::post('/pegawai/notifications/mark-all-as-read', [PegawaiController::class, 'markAllAsRead'])
    ->name('pegawai.notifications.markAllAsRead');


Route::post('/mahasiswa/notifications/mark-all-as-read', [MahasiswaController::class, 'markAllAsRead'])
    ->name('mahasiswa.notifications.markAllAsRead');


Route::middleware('auth')->group(function () {
    Route::delete('/account/delete', [UserController::class, 'destroyAccount'])->name('account.delete');    
});

Route::resource('reservations', ReservationController::class);

Route::delete('/loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');



/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


