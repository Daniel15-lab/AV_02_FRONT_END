<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;

class UserController extends Controller
{
    // Carrega o formulário para cadastro de novo usuário
    public function create()
    {
        //caregar view
        return view('users.create');
    }
        public function store(Request $request)
    {
        try {
        //caregar view
        User::create($request->all());

        return redirect()->route('user.create')->with('success', 'Usuario Cadastrado');

        }catch (Exception $e){
              return back()->withInput()->with('error', 'Usuario não Cadastrado');
    }
}
}