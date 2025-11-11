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
    /*Realiza o login do usuário.*/
    public function login(Request $request)
    {
        // Valida os campos do formulário
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Digite um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ]);

        // Pega apenas os campos necessários
        $credentials = $request->only('email', 'password');

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            // Gera nova sessão e redireciona
            $request->session()->regenerate();
            return redirect()->route('TelaInicio')->with('success', 'Login realizado com sucesso!');
        }

        // Se falhar, retorna com erro
        return back()->withErrors([
            'error' => 'E-mail ou senha inválidos.',
        ])->onlyInput('email'); // mantém o e-mail no campo
    }

    /**
     * Faz logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida e regenera o token da sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Você saiu com sucesso.');
    }
}