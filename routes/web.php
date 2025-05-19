<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\PenilaianAdminController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\PenilaianKepsekController;
use App\Http\Controllers\PenilaianRekanSejawatController;

// ubah ini jadi halaman login
Route::redirect('/', '/login');

// keknya ga diperlukan
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::redirect('/admin/index', "/admin");
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Route User Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login 


    // CRUD SISWA oleh admin
    Route::get('/datasiswa', [DataSiswaController::class, 'index'])->name('datasiswa.index');
    Route::get('/datasiswa/create', [DataSiswaController::class, 'create'])->name('datasiswa.create');
    Route::post('/datasiswa/store', [DataSiswaController::class, 'store'])->name('datasiswa.store');
    Route::get('/datasiswa/{siswa}', [DataSiswaController::class, 'show'])->name('datasiswa.show');
    Route::get('/datasiswa/{siswa}/edit', [DataSiswaController::class, 'edit'])->name('datasiswa.edit');
    Route::put('/datasiswa/{siswa}', [DataSiswaController::class, 'update'])->name('datasiswa.update');
    Route::delete('/datasiswa/{siswa}', [DataSiswaController::class, 'destroy'])->name('datasiswa.destroy');

    // CRUD GURU oleh admin
    Route::get('/dataguru', [DataGuruController::class, 'index'])->name('dataguru.index');
    Route::get('/dataguru/create', [DataGuruController::class, 'create'])->name('dataguru.create');
    Route::post('/dataguru/store', [DataGuruController::class, 'storeguru'])->name('dataguru.storeguru');
    Route::get('/dataguru/{guru}', [DataGuruController::class, 'show'])->name('dataguru.show');
    Route::get('/dataguru/{guru}/edit', [DataGuruController::class, 'edit'])->name('dataguru.edit');
    Route::put('/dataguru/{id}', [DataGuruController::class, 'update'])->name('dataguru.update');
    Route::delete('/dataguru/{guru}', [DataGuruController::class, 'destroy'])->name('dataguru.destroy');

    // Lihat Data Kriteria oleh admin
    Route::get('datakriteria', [KriteriaController::class, 'index'])->name('datakriteria');

    // Lihat Data Sub Kriteria oleh admin
    Route::get('datasubkriteria', [SubKriteriaController::class, 'index'])->name('datasubkriteria');

    // Penilaian guru oleh admin
    Route::get('/datapenilaian', [PenilaianAdminController::class, 'index'])->name('datapenilaian');
    Route::post('/datapenilaian/store', [PenilaianAdminController::class, 'store'])->name('datapenilaian.store');
    Route::put('/datapenilaian/{penilaian}', [PenilaianAdminController::class, 'update'])->name('datapenilaian.update');

    // Perhitungan
    Route::get('dataperhitungan', [PerhitunganController::class, 'index'])->name('dataperhitungan');
    Route::get('dataperhitungan/hitung/{penilaianadmin_id}', [PerhitunganController::class, 'hitung'])->name('dataperhitungan.hitung');

    // Final Result Data
    Route::prefix('data-hasil-akhir')->name('final-result-data.')->group(function(){
        Route::get('', [\App\Http\Controllers\Admin\FinalResultDataController::class, 'index'])->name('index');
        Route::get('print', [\App\Http\Controllers\Admin\FinalResultDataController::class, 'print'])->name('print');
    });
});


// Route User Guru
Route::prefix('guru')->middleware(['auth'])->as('guru.')->group(function () {
    Route::get('/index', [PenilaianRekanSejawatController::class, 'dashboard'])->name('index');
    Route::get('/penilaian', [PenilaianRekanSejawatController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{guru}', [PenilaianRekanSejawatController::class, 'form'])->name('penilaian.form');
    Route::post('/penilaian', [PenilaianRekanSejawatController::class, 'store'])->name('penilaian.store');
});



// Route User Siswa
// Siswa login -> dashboard
Route::get('siswa/index', [SiswaController::class, 'index'])->name('siswa.index');

// Penilaian siswa
Route::prefix('siswa')->name('siswa.')->middleware('auth')->group(function () {
    Route::get('penilaiansiswa', [SiswaController::class, 'penilaiansiswa'])->name('penilaiansiswa');
    Route::post('penilaiansiswa/store', [SiswaController::class, 'storepenilaian'])->name('penilaiansiswa.store');
    Route::put('penilaiansiswa/{penilaian}', [SiswaController::class, 'updatePenilaian'])->name('penilaiansiswa.update');
});

// Route User Kepala Sekolah
Route::prefix('kepsek')->name('kepsek.')->middleware('auth')->group(function () {
    // Dashboard Kepala Sekolah
    Route::get('/index', [PenilaianKepsekController::class, 'dashboard'])->name('index');
    // Data Penilaian Guru oleh Kepala Sekolah
    Route::get('/penilaian', [PenilaianKepsekController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{guru_id}', [PenilaianKepsekController::class, 'form'])->name('penilaian.form');
    Route::post('/penilaian', [PenilaianKepsekController::class, 'store'])->name('penilaian.store');
});


require __DIR__ . '/auth.php';
