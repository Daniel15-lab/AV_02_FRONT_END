<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginControler;
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>vou endoidar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="{{ route('welcome') }}">Marca I</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!--<li class="nav-item"><a class="nav-link active" href="#">Usuário</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#">Sobre</a></li> se eu precisar mais tarde-->
                <!--<li class="nav-item"><a class="nav-link" href="#">Contato</a></li> se eu precisar mais tarde-->

                <!-- Exibe botão Sair apenas se o usuário estiver logado -->
                @if(Auth::check())
                    <li class="nav-item ms-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-danger btn-sm btn-confirm-logout">Sair</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- Modal de confirmação de logout -->
<div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="confirmLogoutLabel">Confirmar Saída</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja sair da sua conta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="confirmLogoutBtn" class="btn btn-warning text-dark">Sair</button>
      </div>
    </div>
  </div>
</div>
<!-- Mensagens de erro -->
<div class="container mt-3">
    @error('error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
<!-- Área central -->
<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="p-4 border rounded shadow-sm bg-white">
            <h1 class="text-center mb-4">Login</h1>

            <!-- Formulário -->
            <form id="formLogin" action="{{ route('login.enter') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control bg-light" id="email" name="email"
                           placeholder="Digite o e-mail" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Senha do usuário"  required>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.create') }}" class="btn btn-success">Cadastrar</a>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--script para o logout-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let logoutForm = null;
        const logoutModal = new bootstrap.Modal(document.getElementById('confirmLogoutModal'));
        const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');

        // Quando clicar no botão de sair
        document.querySelectorAll('.btn-confirm-logout').forEach(button => {
            button.addEventListener('click', function () {
                logoutForm = this.closest('form');
                logoutModal.show();
            });
        });

        // Quando confirmar no modal
        confirmLogoutBtn.addEventListener('click', function () {
            if (logoutForm) logoutForm.submit();
            logoutModal.hide();
        });
    });
</script>
<!--bootstrap js-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>

