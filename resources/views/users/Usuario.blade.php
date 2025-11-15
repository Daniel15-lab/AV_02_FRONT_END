<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TelaUsuario</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
          crossorigin="anonymous">
</head>
<body>
    
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="{{ route('TelaInicio') }}">Marca I</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>    

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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

<!-- Área central -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Perfil do Usuário</h3>
    </div>


    <!-- Card de informações do usuário -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ Auth::user()->name }}</h5>
            <p class="card-text mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="card-text"><strong>ID do usuário:</strong> {{ Auth::user()->id }}</p>
        </div>
    </div>

    <!-- Ações -->
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center">
            
            <!-- Botão de deletar -->
            <form action="{{ route('user.destroy', Auth::user()->id) }}" 
                  method="POST" 
                  class="delete-user-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-confirm-delete" 
                        data-nome="{{ Auth::user()->name }}">
                    <i class="bi bi-trash"></i> Deletar Usuário
                </button>
            </form>

            <!-- Botão para editar -->
            <a href="{{ route('user.edit', Auth::user()->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Editar Usuário
            </a>

        </div>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <!-- Texto será preenchido via JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Excluir</button>
      </div>
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
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let formToSubmit = null;
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        const confirmButton = document.getElementById('confirmDeleteBtn');

        // Quando o usuário clicar em "Excluir"
        document.querySelectorAll('.btn-confirm-delete').forEach(button => {
            button.addEventListener('click', function () {
                formToSubmit = this.closest('form');
                const nomeUsuario = this.dataset.nome;
                document.querySelector('#confirmDeleteModal .modal-body').innerText =
                    `Tem certeza que deseja excluir o usuário "${nomeUsuario}"`;
                modal.show();
            });
        });

        // Confirma exclusão
        confirmButton.addEventListener('click', function () {
            if (formToSubmit) {
                formToSubmit.submit();
            }
            modal.hide();
        });
    });
</script>

</body>
</html>
