<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\PenilaianAdminController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\PenilaianKepsekController;
use App\Http\Controllers\PenilaianRekanSejawatController;

Route::redirect('/', '/login');
require __DIR__ . '/auth.php';
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::redirect('/index', "/admin");
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::controller(DataSiswaController::class)->prefix('datasiswa')->name('datasiswa.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
            Route::get('/{siswa}', 'show')->name('show');
            Route::get('/{siswa}/edit', 'edit')->name('edit');
            Route::put('/{siswa}', 'update')->name('update');
            Route::delete('/{siswa}', 'destroy')->name('destroy');
        });

        Route::controller(DataGuruController::class)->prefix('dataguru')->name('dataguru.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'storeguru')->name('storeguru');
            Route::get('/export', 'export')->name('export');
            Route::post('/import', 'import')->name('import');
            Route::get('/{guru}', 'show')->name('show');
            Route::get('/{guru}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{guru}', 'destroy')->name('destroy');
        });

        Route::controller(KriteriaController::class)->group(function () {
            Route::get('datakriteria', 'index')->name('datakriteria');
        });

        Route::controller(SubKriteriaController::class)->group(function () {
            Route::get('datasubkriteria', 'index')->name('datasubkriteria');
        });

        Route::controller(PenilaianAdminController::class)->prefix('datapenilaian')->name('datapenilaian.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{penilaian}', 'update')->name('update');
        });

        Route::controller(PerhitunganController::class)->prefix('dataperhitungan')->name('dataperhitungan.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/hitung/{penilaianadmin_id}', 'hitung')->name('hitung');
        });

        Route::controller(\App\Http\Controllers\Admin\FinalResultDataController::class)
            ->prefix('data-hasil-akhir')
            ->name('final-result-data.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/print', 'print')->name('print');
            });
    });

    Route::controller(PenilaianRekanSejawatController::class)
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {
            Route::get('/index', 'dashboard')->name('index');
            Route::redirect('index', 'penilaian');
            Route::prefix('penilaian')->name('penilaian.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{guru}', 'form')->name('form');
                Route::post('/', 'store')->name('store');
            });
        });

    Route::controller(SiswaController::class)
        ->prefix('siswa')
        ->name('siswa.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::redirect('/', '/siswa/penilaiansiswa');
            Route::prefix('penilaiansiswa')->name('penilaiansiswa.')->group(function () {
                Route::get('/', 'penilaiansiswa')->name('index');
                Route::post('/store', 'storepenilaian')->name('store');
                Route::put('/{penilaian}', 'updatePenilaian')->name('update');
            });
        });

    Route::controller(PenilaianKepsekController::class)
        ->prefix('kepsek')
        ->name('kepsek.')
        ->group(function () {
            Route::get('/index', 'dashboard')->name('index');
            Route::redirect('index', 'penilaian');
            Route::prefix('penilaian')->name('penilaian.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{guru_id}', 'form')->name('form');
                Route::post('/', 'store')->name('store');
            });
        });
});
