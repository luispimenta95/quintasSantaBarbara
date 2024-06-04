<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController as Host;
use App\Http\Controllers\AppController as App;
use App\Http\Controllers\ReservaController as Reserva;

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

Route::get('/', [Host::class, 'index']);
Route::post('/salvar-reserva', [Host::class, 'receberDados']);
Route::get('/reservas', [Reserva::class, 'show']);
Route::get('/gerar-contrato', [App::class, 'gerarContrato']);
