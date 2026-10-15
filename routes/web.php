<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnasayfaController;

use App\Http\Controllers\Admin\ServisNoktasiController;
use App\Http\Controllers\Admin\MarkaController;
use App\Http\Controllers\Admin\AracModelController;
use App\Http\Controllers\Admin\PaketController;

// Admin rotaları — sadece admin girebilir
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('servis-noktalari', ServisNoktasiController::class)
        ->names('admin.servis')
        ->parameters(['servis-noktalari' => 'servis_noktasi']);
    Route::resource('araclar', \App\Http\Controllers\Admin\AracController::class)
        ->names('admin.arac')
        ->parameters(['araclar' => 'arac']);
    Route::post('araclar/{arac}/toggle-one-cikan', [\App\Http\Controllers\Admin\AracController::class, 'toggleOneCikan'])
        ->name('admin.arac.toggleOneCikan');
    Route::delete('araclar/fotograf/{foto}', [\App\Http\Controllers\Admin\AracController::class, 'fotografSil'])
        ->name('admin.arac.fotograf.destroy');
    Route::post('araclar/fotograf/{foto}/kapak', [\App\Http\Controllers\Admin\AracController::class, 'fotografKapakYap'])
        ->name('admin.arac.fotograf.kapak');

    Route::resource('markalar', MarkaController::class)
        ->names('admin.marka')
        ->parameters(['markalar' => 'marka']);
    Route::resource('markalar.modeller', AracModelController::class)
        ->names('admin.marka.modeller')
        ->parameters(['markalar' => 'marka', 'modeller' => 'aracModel']);
    Route::get('api/modeller/{marka}', [AracModelController::class, 'apiModeller'])
        ->name('admin.api.modeller');

    Route::resource('markalar.modeller.paketler', PaketController::class)
        ->names('admin.paket')
        ->parameters(['markalar' => 'marka', 'modeller' => 'aracModel', 'paketler' => 'paket']);

    Route::get('api/paketler/{model}', [PaketController::class, 'apiByModel'])
        ->name('admin.api.paketler');
    Route::post('api/paketler/{model}', [PaketController::class, 'apiStore'])
        ->name('admin.api.paketler.store');
});

Route::get('/', [AnasayfaController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
