import { useState } from "react";
import { useNavigate } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

export default function AdicionarConta() {
  const navigate = useNavigate();
  const [conta, setConta] = useState({
    descricao: "",
    preco: "",
    data_vencimento: "",
    data_pagamento: "",
    status: "Aberta",
  });
  const [errors, setErrors] = useState([]);

  const handleChange = (e) => {
    setConta({ ...conta, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors([]);

    try {
      const res = await fetch("/contas", {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: JSON.stringify(conta),
      });

      if (res.ok) {
        navigate("/inicio"); // volta para a tela inicial
      } else if (res.status === 422) {
        const data = await res.json();
        setErrors(data.errors || ["Erro de validação"]);
      } else {
        alert("Erro inesperado ao salvar a conta");
      }
    } catch (err) {
      console.error(err);
      alert("Erro ao conectar ao servidor");
    }
  };

  return (
    <div className="container mt-5">
      <div className="card shadow-sm">
        <div className="card-header bg-dark text-white">
          <h4>Adicionar Conta</h4>
        </div>
        <div className="card-body">
          {errors.length > 0 && (
            <div className="alert alert-danger">
              <strong>Erro!</strong>
              <ul className="mb-0">
                {errors.map((err, i) => (
                  <li key={i}>{err}</li>
                ))}
              </ul>
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <label htmlFor="descricao" className="form-label">
                Descrição
              </label>
              <input
                type="text"
                id="descricao"
                name="descricao"
                className="form-control"
                value={conta.descricao}
                onChange={handleChange}
                required
              />
            </div>

            <div className="mb-3">
              <label htmlFor="preco" className="form-label">
                Preço (R$)
              </label>
              <input
                type="number"
                step="0.01"
                id="preco"
                name="preco"
                className="form-control"
                value={conta.preco}
                onChange={handleChange}
                required
              />
            </div>

            <div className="mb-3">
              <label htmlFor="data_vencimento" className="form-label">
                Data de Vencimento
              </label>
              <input
                type="datetime-local"
                id="data_vencimento"
                name="data_vencimento"
                className="form-control"
                value={conta.data_vencimento}
                onChange={handleChange}
                required
              />
            </div>

            <div className="mb-3">
              <label htmlFor="data_pagamento" className="form-label">
                Data de Pagamento
              </label>
              <input
                type="datetime-local"
                id="data_pagamento"
                name="data_pagamento"
                className="form-control"
                value={conta.data_pagamento}
                onChange={handleChange}
              />
            </div>

            <div className="mb-3">
              <label htmlFor="status" className="form-label">
                Status
              </label>
              <select
                name="status"
                id="status"
                className="form-select"
                value={conta.status}
                onChange={handleChange}
                required
              >
                <option value="Aberta">Aberta</option>
                <option value="Quitada">Quitada</option>
              </select>
            </div>

            <div className="d-flex justify-content-between">
              <button
                type="button"
                className="btn btn-secondary"
                onClick={() => navigate("/inicio")}
              >
                Voltar
              </button>
              <button type="submit" className="btn btn-success">
                Salvar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

