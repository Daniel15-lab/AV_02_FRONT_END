<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Mostra o formulário de login
    public function showLoginForm()
    {
        return view('TelaInicio'); // o nome da view que você já criou
    }

    // Faz o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // evita ataque de sessão
            return redirect()->route('TelaInicio'); // redireciona pra página inicial
        }

        return back()->withErrors([
            'error' => 'E-mail ou senha incorretos.',
        ]);
    }

    // Faz logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso.');
    }
}
