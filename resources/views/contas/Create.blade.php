<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4>Adicionar Conta</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('contas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <input type="text" name="descricao" id="descricao" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" id="preco" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                    <input type="datetime-local" name="data_vencimento" id="data_vencimento" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="data_pagamento" class="form-label">Data de Pagamento</label>
                    <input type="datetime-local" name="data_pagamento" id="data_pagamento" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Aberta">Aberta</option>
                        <option value="Quitada">Quitada</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('TelaInicio') }}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
