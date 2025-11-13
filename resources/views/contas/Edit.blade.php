<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Editar Conta</h4>
            <a href="{{ route('TelaInicio') }}" class="btn btn-outline-light btn-sm">Voltar</a>
        </div>

        <div class="card-body">
            {{-- Exibe erros de validação, se houver --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erro!</strong> Verifique os campos abaixo:<br><br>
                    <ul>
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Formulário de edição --}}
            <form action="{{ route('contas.update', $conta->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control"
                        value="{{ old('descricao', $conta->descricao) }}" required>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" id="preco" class="form-control"
                        value="{{ old('preco', $conta->preco) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                        <input type="datetime-local" name="data_vencimento" id="data_vencimento" class="form-control"
                            value="{{ old('data_vencimento', $conta->data_vencimento ? date('Y-m-d\TH:i', strtotime($conta->data_vencimento)) : '') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="data_pagamento" class="form-label">Data de Pagamento</label>
                        <input type="datetime-local" name="data_pagamento" id="data_pagamento" class="form-control"
                            value="{{ old('data_pagamento', $conta->data_pagamento ? date('Y-m-d\TH:i', strtotime($conta->data_pagamento)) : '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Aberta" {{ old('status', $conta->status) == 'Aberta' ? 'selected' : '' }}>Aberta</option>
                        <option value="Quitada" {{ old('status', $conta->status) == 'Quitada' ? 'selected' : '' }}>Quitada</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('contas.show', $conta->id) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
