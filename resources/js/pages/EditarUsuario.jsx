import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

export default function EditUser({ user }) {
  const navigate = useNavigate();

  // States do formulário
  const [name, setName] = useState(user.name || "");
  const [email, setEmail] = useState(user.email || "");
  const [password, setPassword] = useState("");
  const [passwordConfirmation, setPasswordConfirmation] = useState("");

  const [errors, setErrors] = useState([]);
  const [successMessage, setSuccessMessage] = useState("");

  // Modal de logout
  useEffect(() => {
    const logoutModal = new bootstrap.Modal(document.getElementById("confirmLogoutModal"));
    const confirmLogoutBtn = document.getElementById("confirmLogoutBtn");
    let logoutForm = null;

    document.querySelectorAll(".btn-confirm-logout").forEach((button) => {
      button.addEventListener("click", function () {
        logoutForm = this.closest("form");
        logoutModal.show();
      });
    });

    confirmLogoutBtn.addEventListener("click", function () {
      if (logoutForm) logoutForm.submit();
      logoutModal.hide();
    });
  }, []);

  // Enviar formulário
  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors([]);
    setSuccessMessage("");

    try {
      const res = await fetch(`/user/${user.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        credentials: "same-origin",
        body: JSON.stringify({
          name,
          email,
          password,
          password_confirmation: passwordConfirmation,
        }),
      });

      const data = await res.json();

      if (res.ok) {
        setSuccessMessage("Usuário atualizado com sucesso!");
      } else if (res.status === 422) {
        // Validação Laravel
        setErrors(data.errors ? Object.values(data.errors).flat() : ["Erro de validação"]);
      } else {
        setErrors(["Erro inesperado ao atualizar usuário"]);
      }
    } catch (err) {
      console.error(err);
      setErrors(["Erro ao conectar ao servidor"]);
    }
  };

  return (
    <div className="bg-light min-vh-100">
      {/* Navbar */}
      <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
        <div className="container-fluid">
          <a className="navbar-brand text-light" href="/inicio">
            Marca I
          </a>
          <button
            className="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
          >
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarNav">
            <ul className="navbar-nav ms-auto">
              <li className="nav-item ms-3">
                <form action="/logout" method="POST">
                  <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]').getAttribute("content")} />
                  <button type="button" className="btn btn-danger btn-sm btn-confirm-logout">Sair</button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      {/* Modal logout */}
      <div className="modal fade" id="confirmLogoutModal" tabIndex="-1">
        <div className="modal-dialog modal-dialog-centered">
          <div className="modal-content shadow-lg border-0">
            <div className="modal-header bg-warning text-dark">
              <h5 className="modal-title">Confirmar Saída</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div className="modal-body">Tem certeza que deseja sair da sua conta?</div>
            <div className="modal-footer">
              <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="confirmLogoutBtn" className="btn btn-warning text-dark">Sair</button>
            </div>
          </div>
        </div>
      </div>

      {/* Conteúdo */}
      <div className="container mt-5">
        <div className="card shadow-sm">
          <div className="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 className="mb-0">Editar Usuário</h4>
          </div>

          <div className="card-body">
            {/* Mensagens */}
            {successMessage && <div className="alert alert-success">{successMessage}</div>}
            {errors.length > 0 && (
              <div className="alert alert-danger">
                <ul className="mb-0">
                  {errors.map((err, i) => <li key={i}>{err}</li>)}
                </ul>
              </div>
            )}

            {/* Formulário */}
            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <label className="form-label">Nome:</label>
                <input
                  type="text"
                  className="form-control bg-light"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  required
                />
              </div>

              <div className="mb-3">
                <label className="form-label">E-mail:</label>
                <input
                  type="email"
                  className="form-control bg-light"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Nova Senha (opcional):</label>
                <input
                  type="password"
                  className="form-control"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Deixe em branco se não quiser mudar"
                />
              </div>

              <div className="mb-3">
                <label className="form-label">Confirmar Nova Senha:</label>
                <input
                  type="password"
                  className="form-control"
                  value={passwordConfirmation}
                  onChange={(e) => setPasswordConfirmation(e.target.value)}
                />
              </div>

              <button type="submit" className="btn btn-success">Confirmar Mudanças</button>
              <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate("/usuario")}>Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}
