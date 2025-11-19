import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

export default function ContaDetalhes() {
  const { id } = useParams(); // pega o ID da conta da rota
  const navigate = useNavigate();

  const [conta, setConta] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    // Buscar detalhes da conta via API
    fetch(`/contas/${id}/json`, {
      credentials: "same-origin",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error("Erro ao buscar conta");
        return res.json();
      })
      .then((data) => {
        setConta(data);
        setLoading(false);
      })
      .catch((err) => {
        console.error(err);
        setError("Não foi possível carregar os detalhes da conta.");
        setLoading(false);
      });
  }, [id]);

  const handleDelete = async () => {
    if (!window.confirm("Tem certeza que deseja excluir esta conta?")) return;

    try {
      const res = await fetch(`/contas/${id}`, {
        method: "DELETE",
        credentials: "same-origin",
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      });

      if (res.ok) {
        navigate("/inicio");
      } else {
        alert("Erro ao excluir a conta");
      }
    } catch (err) {
      console.error(err);
      alert("Erro ao conectar ao servidor");
    }
  };

  if (loading) return <div className="container mt-5">Carregando...</div>;
  if (error) return <div className="container mt-5 text-danger">{error}</div>;

  return (
    <div className="container mt-5">
      <div className="card shadow-sm">
        <div className="card-header bg-dark text-white d-flex justify-content-between align-items-center">
          <h4>Detalhes da Conta #{conta.id}</h4>
          <button className="btn btn-secondary btn-sm" onClick={() => navigate("/inicio")}>
            Voltar
          </button>
        </div>

        <div className="card-body">
          <div className="mb-3">
            <h5 className="text-muted">Descrição:</h5>
            <p>{conta.descricao}</p>
          </div>

          <div className="mb-3">
            <h5 className="text-muted">Preço:</h5>
            <p>R$ {Number(conta.preco).toFixed(2).replace(".", ",")}</p>
          </div>

          <div className="mb-3">
            <h5 className="text-muted">Data de Vencimento:</h5>
            <p>{new Date(conta.data_vencimento).toLocaleString("pt-BR")}</p>
          </div>

          <div className="mb-3">
            <h5 className="text-muted">Data de Pagamento:</h5>
            <p>
              {conta.data_pagamento
                ? new Date(conta.data_pagamento).toLocaleString("pt-BR")
                : <span className="text-muted">Não paga ainda</span>}
            </p>
          </div>

          <div className="mb-3">
            <h5 className="text-muted">Status:</h5>
            {conta.status === "Aberta" ? (
              <span className="badge bg-info">Aberta</span>
            ) : (
              <span className="badge bg-success">Quitada</span>
            )}
          </div>
        </div>

        <div className="card-footer d-flex justify-content-end">
          <button
            className="btn btn-primary me-2"
            onClick={() => navigate(`/contas/${conta.id}/edit`)}
          >
            Editar
          </button>
          <button className="btn btn-danger" onClick={handleDelete}>
            Excluir
          </button>
        </div>
      </div>
    </div>
  );
}
