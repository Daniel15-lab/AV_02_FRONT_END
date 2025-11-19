<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContaController extends Controller
{
    /**
     * Retorna as contas do usuário logado em JSON (para React).
     */
    public function getContasJson()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Usuário não logado.');
        }

        $contas = Conta::where('user_id', $user->id)
                    ->orderBy('id', 'desc')
                    ->get();

        $totalAbertas = Conta::where('user_id', $user->id)
                            ->where('status', 'Aberta')
                            ->sum('preco');

        return response()->json([
            'contas' => $contas,
            'totalAbertas' => $totalAbertas
        ]);
    }

    /**
     * Tela inicial com as contas do usuário.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Usuário não logado.');
        }

        $contas = Conta::where('user_id', $user->id)
                        ->orderBy('id', 'desc')
                        ->get();

        $totalAbertas = Conta::where('user_id', $user->id)
                            ->where('status', 'Aberta')
                            ->sum('preco');

        return view('TelaInicio', compact('contas', 'totalAbertas'));
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        return view('contas.create');
    }

    /**
     * Salva uma nova conta do usuário logado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Usuário não logado.');
        }

        $conta = new Conta($request->all());
        $conta->user_id = $user->id;
        $conta->save();

        return redirect()->route('TelaInicio')->with('success', 'Conta adicionada com sucesso!');
    }

    /**
     * Exibe uma conta específica.
     */
    public function show(Conta $conta)
    {
        return view('contas.show', compact('conta'));
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Conta $conta)
    {
        // Garante que o usuário só edita sua própria conta
        if ($conta->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        return view('contas.edit', compact('conta'));
    }

    /**
     * Atualiza os dados da conta.
     */
    public function update(Request $request, Conta $conta)
    {
        // Valida usuário
        if ($conta->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $request->validate([
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'data_vencimento' => 'required|date',
        ]);

        $conta->update($request->all());

        return redirect()->route('TelaInicio')->with('success', 'Conta atualizada com sucesso!');
    }

    /**
     * Exclui a conta do usuário logado.
     */
    public function destroy(Conta $conta)
    {
        if ($conta->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        $conta->delete();
        return redirect()->route('TelaInicio')->with('success', 'Conta movida para a lixeira!');
    }
}
