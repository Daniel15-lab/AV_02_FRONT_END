<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginControler;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContaController;
use Illuminate\Support\Facades\Auth;

// View principal (React)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Cadastro usuário (React)
Route::get('/create.user', function () {
    return view('welcome');
})->name('user.create');

// Rotas protegidas (React controla front-end)
Route::middleware('auth')->group(function () {
    Route::get('/inicio', function () {
        return view('welcome');
    })->name('TelaInicio');

    Route::get('/usuario', function () {
        return view('welcome');
    })->name('usuario');

    Route::get('/usuario/editar', function () {
        return view('welcome');
    });

    Route::get('/conta/adicionar', function () {
        return view('welcome');
    });

    Route::get('/conta/{id}', function () {
        return view('welcome');
    });

    Route::get('/conta/{id}/editar', function () {
        return view('welcome');
    });

    // Endpoints de CRUD do back-end
    Route::post('/contas', [ContaController::class, 'store'])->name('contas.store');
    Route::put('/contas/{conta}', [ContaController::class, 'update'])->name('contas.update');
    Route::delete('/contas/{conta}', [ContaController::class, 'destroy'])->name('contas.destroy');
    Route::get('/contas-json', [ContaController::class, 'getContasJson'])->name('contas.json');

    // Usuário CRUD via back-end
    Route::post('/store.user', [UserController::class, 'store'])->name('user.store'); // Criar usuário
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

// Rota para verificar se o usuário está logado
Route::get('/user-logado', function () {
    return response()->json(['auth' => Auth::check()]);
});

// Autenticação
Route::post('/login', [LoginControler::class, 'login'])->name('login.enter');
Route::post('/logout', [LoginControler::class, 'logout'])->name('logout');
