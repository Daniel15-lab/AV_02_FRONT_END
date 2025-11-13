<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContaController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

//criacao do usuario
Route::get('/create.user', [UserController::class, 'create'])
->name('user.create');
Route::post('/store.user', [UserController::class, 'store'])
->name('user.store');

//Login
Route::get('/login', [LoginControler::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginControler::class, 'login'])->name('login.enter');
Route::post('/logout', [LoginControler::class, 'logout'])->middleware('auth')->name('logout');

//Redireciona para view Tela Inicio (->middleware('auth')) serve para proteger o usuario
Route::get('/inicio', [ContaController::class, 'index'])->middleware('auth')->name('TelaInicio');

// Redireciona para a view 
Route::get('/usuario', function () {
    return view('users/Usuario');
})->middleware('auth')->name('usuario');

// Editar usuário
Route::get('/user/{id}/edit', [UserController::class, 'edit'])
->middleware('auth')->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])
->middleware('auth')->name('user.update');

// Soft delete
Route::delete('/user/{id}', [UserController::class, 'destroy'])
->middleware('auth')->name('user.destroy');

// Tela de criar nova conta
Route::get('/contas/create', [ContaController::class, 'create'])->name('contas.create');

// Enviar formulário de criação
Route::post('/contas', [ContaController::class, 'store'])->name('contas.store');

// Exibir uma conta
Route::get('/contas/{conta}', [ContaController::class, 'show'])->name('contas.show');

// Editar
Route::get('/contas/{conta}/edit', [ContaController::class, 'edit'])->name('contas.edit');

// Atualizar
Route::put('/contas/{conta}', [ContaController::class, 'update'])->name('contas.update');

// Deletar
Route::delete('/contas/{conta}', [ContaController::class, 'destroy'])->name('contas.destroy');