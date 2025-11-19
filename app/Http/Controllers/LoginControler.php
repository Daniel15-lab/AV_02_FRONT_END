<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginControler extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm()
    {
        return view('TelaInicio');
    }

    /**
     * Realiza o login do usuário via JSON.
     */
    public function login(Request $request)
    {
        // Validação básica
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        // Pega os dados enviados
        $credentials = $request->only('email', 'password');

        // Tenta autenticar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                "message" => "ok"
            ], 200);
        }

        // Login inválido
        return response()->json([
            "message" => "invalid"
        ], 401);
    }

    /**
     * Faz logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida a sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            "message" => "logged_out"
        ], 200);
    }
}
