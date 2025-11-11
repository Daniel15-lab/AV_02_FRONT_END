<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    // Lista todas as contas e envia para a view
    public function index()
    {
        $contas = Conta::orderBy('id', 'desc')->get();
        return view('TelaInicio', compact('contas'));
        // 👆 Aqui você pode usar 'TelaInicio' ou 'contas.index', dependendo do nome da view
    }

    // Mostra o formulário de criação
    public function create()
    {
        return view('contas.create');
    }

    // Salva uma nova conta
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        Conta::create($request->all());

        return redirect()->route('TelaInicio')->with('success', 'Conta adicionada com sucesso!');
    }

    // Exibe uma conta específica
    public function show(Conta $conta)
    {
        return view('contas.show', compact('conta'));
    }

    // Mostra o formulário de edição
    public function edit(Conta $conta)
    {
        return view('contas.edit', compact('conta'));
    }

    //  Atualiza os dados
    public function update(Request $request, Conta $conta)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        $conta->update($request->all());

        return redirect()->route('TelaInicio')->with('success', 'Conta atualizada com sucesso!');
    }

    //  Exclui a conta
    public function destroy(Conta $conta)
    {
        $conta->delete();
        return redirect()->route('TelaInicio')->with('success', 'Conta excluída com sucesso!');
    }
}
