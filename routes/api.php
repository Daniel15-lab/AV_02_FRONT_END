<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContaController;

// LOGIN 
Route::post('/login', [LoginController::class, 'login']);

// CADASTRO DE USUÁRIO 
Route::post('/register', [UserController::class, 'store']);

// ROTAS PROTEGIDAS POR JWT
Route::middleware('auth:api')->group(function () {

    // usuário autenticado
    Route::get('/me', [LoginController::class, 'me']);

    // rota usada pelo React para verificar se está logado
    Route::get('/user-logado', function () {
        return response()->json(['auth' => true]);
    });

    // logout
    Route::post('/logout', [LoginController::class, 'logout']);

    // ### CONTAS ###
    Route::get('/contas-json', [ContaController::class, 'getContasJson']);
    Route::get('/contas/{id}', [ContaController::class, 'showContaJson']);
    Route::post('/contas', [ContaController::class, 'store']);
    Route::put('/contas/{id}/update-json', [ContaController::class, 'updateJson']);
    Route::delete('/contas/{id}', [ContaController::class, 'destroy']);

    // ### USUÁRIOS ###
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});

// test do DNS
Route::get('/test-dns', function () {
    return checkdnsrr('gmail.com', 'MX') ? 'OK' : 'FAIL';
});
