<?php
use Illuminate\Support\Facades\Route;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
<!--  Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-light" href="{{ route('welcome') }}">Marca I</a>
            
            <!-- Botão mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <!--<li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Início</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#">Contato</a></li>-->

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

<!--  Conteúdo principal -->
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Cadastrar Usuário</h4>
        </div>
        
        <div class="card-body">
            <!-- Mensagens de sucesso/erro -->
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <form action="{{ route('user.store') }}" method="POST">
                <!-- Formulário -->
                         @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nome:</label>
                        <input type="text" class="form-control bg-light" id="name" name="name"
                               placeholder="Digite o nome" value="{{ old('name') }}" >
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control bg-light" id="email" name="email"
                               placeholder="Digite o e-mail" value="{{ old('email') }}" >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Senha do usuario" minlength="6" required>
                    </div> 
                    
                    <button type="submit" class="btn btn-success">Cadastrar</button>
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
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>