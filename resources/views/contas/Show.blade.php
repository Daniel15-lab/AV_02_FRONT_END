<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4>Detalhes da Conta #{{ $conta->id }}</h4>
            <a href="{{ route('TelaInicio') }}" class="btn btn-secondary btn-sm">Voltar</a>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <h5 class="text-muted">Descrição:</h5>
                <p>{{ $conta->descricao }}</p>
            </div>

            <div class="mb-3">
                <h5 class="text-muted">Preço:</h5>
                <p>R$ {{ number_format($conta->preco, 2, ',', '.') }}</p>
            </div>

            <div class="mb-3">
                <h5 class="text-muted">Data de Vencimento:</h5>
                <p>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y H:i') }}</p>
            </div>

            <div class="mb-3">
                <h5 class="text-muted">Data de Pagamento:</h5>
                <p>
                    @if($conta->data_pagamento)
                        {{ \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y H:i') }}
                    @else
                        <span class="text-muted">Não paga ainda</span>
                    @endif
                </p>
            </div>

            <div class="mb-3">
                <h5 class="text-muted">Status:</h5>
                @if ($conta->status == 'Aberta')
                    <span class="badge bg-info">Aberta</span>
                @else
                    <span class="badge bg-success">Quitada</span>
                @endif
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('contas.edit', $conta) }}" class="btn btn-primary me-2">Editar</a>

            <form action="{{ route('contas.destroy', $conta) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta conta?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
