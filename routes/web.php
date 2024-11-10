<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController as Host;
use App\Http\Controllers\AppController as App;
use App\Http\Controllers\ReservaController as Reserva;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MobileController as Mobile;
use App\Http\Controllers\DataController;


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 Route::get('/acesso', [RegisteredUserController::class, 'create'])
                ->name('register');
Route::get('/reservas-mobile', [Mobile::class, 'reserva'])->name('reservas-mobile');
Route::get('/path', [Mobile::class, 'getPath'])->name('path');
Route::get('/bloquear-datas', [DataController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/iniciar-reserva', [Host::class, 'index']);
    Route::post('/salvar-reserva', [Host::class, 'receberDados']);
    Route::get('/reservas', [Reserva::class, 'show']);
    Route::get('/gerar-contrato', [App::class, 'gerarContrato']);
});

require __DIR__.'/auth.php';
