import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import * as bootstrap from "bootstrap";

export default function TelaInicio() {
  const navigate = useNavigate();
  const [contas, setContas] = useState([]);
  const [paginaAtual, setPaginaAtual] = useState(1);
  const itensPorPagina = 5;
  const [total, setTotal] = useState(0);
  const [contaExcluir, setContaExcluir] = useState(null);

  // Checa se usuário está logado
  useEffect(() => {
    const verificarLogin = async () => {
      try {
        const res = await fetch("/user-logado", {
          credentials: "same-origin",
        });
        const data = await res.json();
        if (!data.auth) {
          navigate("/"); // Redireciona para login se não autenticado
        } else {
          carregarContas();
        }
      } catch (err) {
        console.error("Erro ao verificar login:", err);
        navigate("/");
      }
    };
    verificarLogin();
  }, []);

  const carregarContas = async () => {
    try {
      const res = await axios.get("/contas-json");
      const contasFormatadas = res.data.contas.map((c) => ({
        ...c,
        vencFormatado: new Date(c.data_vencimento).toLocaleString("pt-BR"),
        pagFormatado: c.data_pagamento
          ? new Date(c.data_pagamento).toLocaleString("pt-BR")
          : "-",
      }));
      setContas(contasFormatadas);

      const soma = contasFormatadas.reduce(
        (acc, c) => acc + parseFloat(c.preco),
        0
      );
      setTotal(soma);
    } catch (err) {
      console.error(err);
    }
  };

  // Logout
  const handleLogout = async () => {
    try {
      await axios.post(
        "/logout",
        {},
        {
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
          },
        }
      );
      navigate("/"); // Volta para login
    } catch (err) {
      console.error("Erro ao sair:", err);
    }
  };

  // Paginação
  const indiceInicial = (paginaAtual - 1) * itensPorPagina;
  const contasPaginadas = contas.slice(
    indiceInicial,
    indiceInicial + itensPorPagina
  );
  const totalPaginas = Math.ceil(contas.length / itensPorPagina);

  const changePage = (page) => {
    if (page < 1 || page > totalPaginas) return;
    setPaginaAtual(page);
  };

  const excluirConta = async () => {
    if (!contaExcluir) return;
    await axios.delete(`/contas/${contaExcluir}`);
    setContaExcluir(null);
    carregarContas();
    const modal = bootstrap.Modal.getInstance(
      document.getElementById("confirmDeleteModal")
    );
    modal.hide();
  };

  return (
    <>
      {/* NAVBAR */}
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
              <li className="nav-item">
                <a className="btn btn-success btn-sm" href="/usuario">
                  Usuário
                </a>
              </li>
              <li className="nav-item ms-3">
                <button
                  className="btn btn-danger btn-sm"
                  onClick={() => {
                    const modal = new bootstrap.Modal(
                      document.getElementById("logoutModal")
                    );
                    modal.show();
                  }}
                >
                  Sair
                </button>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div className="container mt-5">
        <div className="d-flex justify-content-between align-items-center mb-3">
          <h3>Contas a Pagar</h3>
          <a href="/conta/adicionar" className="btn btn-success">
            + Adicionar
          </a>
        </div>

        <h5 className="mb-3">
          Total:{" "}
          <strong>
            R$ {total.toLocaleString("pt-BR", { minimumFractionDigits: 2 })}
          </strong>
        </h5>

        {/* tabela e paginação */}
        {/* ... você pode reutilizar a tabela e modais que já tinha */}
      </div>

      {/* Modal Logout */}
      <div className="modal fade" id="logoutModal" tabIndex="-1">
        <div className="modal-dialog modal-dialog-centered">
          <div className="modal-content shadow-lg border-0">
            <div className="modal-header bg-warning">
              <h5 className="modal-title">Encerrar Sessão</h5>
              <button
                type="button"
                className="btn-close"
                data-bs-dismiss="modal"
              ></button>
            </div>
            <div className="modal-body">
              Tem certeza que deseja sair da sua conta?
            </div>
            <div className="modal-footer">
              <button className="btn btn-secondary" data-bs-dismiss="modal">
                Cancelar
              </button>
              <button className="btn btn-warning" onClick={handleLogout}>
                Sair
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
