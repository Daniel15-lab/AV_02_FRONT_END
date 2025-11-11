<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TelaInicio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>

<!--  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-light" href="{{ route('TelaInicio') }}">Marca I</a>
            
            <!-- Botão mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>    
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-success btn-sm" href="{{ route('usuario') }}">Usuário</a>
                </li>
                <!--<li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#">Contato</a></li>-->

                 <!-- Exibe botão Sair apenas se o usuário estiver logado -->
                @if(Auth::check())
                    <li class="nav-item ms-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Contas a Pagar</h3>
        <div>
            <a href="#" class="btn btn-success">+ Adicionar</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Data de Vencimento</th>
                        <th>Data de Pagamento</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contas as $conta)
                    <tr>
                        <td>{{ $conta->id }}</td>
                        <td>{{ $conta->descricao }}</td>
                        <td>R$ {{ number_format($conta->preco, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($conta->data_pagamento)
                                {{ \Carbon\Carbon::parse($conta->data_pagamento)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($conta->status == 'Aberta')
                                <span class="badge bg-info">Aberta</span>
                            @else
                                <span class="badge bg-success">Quitada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('contas.show', $conta->id) }}" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="{{ route('contas.edit', $conta->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('contas.destroy', $conta->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>
</html>
