import React from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter, Routes, Route } from "react-router-dom";

import Login from "./pages/Login";
import CadastrarUsuario from "./pages/CadastrarUsuario";
import TelaInicio from "./pages/TelaInicio";
import TelaUsuario from "./pages/TelaUsuario";
import EditarUsuario from "./pages/EditarUsuario";
import ContaDetalhes from "./pages/ContaDetalhes";
import AdicionarConta from "./pages/AdicionarConta";
import EditarConta from "./pages/EditarConta";

import ProtectedRoute from "./components/ProtectedRoute";

ReactDOM.createRoot(document.getElementById("app")).render(
  <React.StrictMode>
    <BrowserRouter>
      <Routes>
        {/* Rotas públicas */}
        <Route path="/" element={<Login />} />
        <Route path="/create.user" element={<CadastrarUsuario />} />

        {/* Rotas protegidas */}
        <Route path="/inicio" element={<ProtectedRoute><TelaInicio /></ProtectedRoute>} />
        <Route path="/usuario" element={<ProtectedRoute><TelaUsuario /></ProtectedRoute>} />
        <Route path="/usuario/editar" element={<ProtectedRoute><EditarUsuario /></ProtectedRoute>} />

        <Route path="/conta/adicionar" element={<ProtectedRoute><AdicionarConta /></ProtectedRoute>} />
        <Route path="/conta/:id" element={<ProtectedRoute><ContaDetalhes /></ProtectedRoute>} />
        <Route path="/conta/:id/editar" element={<ProtectedRoute><EditarConta /></ProtectedRoute>} />

        {/* 404 */}
        <Route path="*" element={<h1>Página não encontrada</h1>} />
      </Routes>
    </BrowserRouter>
  </React.StrictMode>
);
