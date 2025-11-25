import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api/api";

export default function EditarUsuario() {
    const navigate = useNavigate();

    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");

    const [errors, setErrors] = useState([]);
    const [successMessage, setSuccessMessage] = useState("");

    // Carregar dados do usuário
    useEffect(() => {
        api.get("/me")
            .then((res) => {
                setUser(res.data);
                setName(res.data.name);
                setEmail(res.data.email);
            })
            .catch(() => {
                localStorage.removeItem("token");
                navigate("/");
            })
            .finally(() => setLoading(false));
    }, []);

    // Enviar formulário
    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setSuccessMessage("");

        try {
            const res = await api.put(`/user/${user.id}`, {
                name,
                email,
                password,
                password_confirmation: passwordConfirmation
            });

            setSuccessMessage("Usuário atualizado com sucesso!");
            setTimeout(() => {
            navigate("/usuario");
            }, 1000);
        } catch (err) {
            if (err.response?.status === 422) {
                setErrors(Object.values(err.response.data.errors).flat());
            } else {
                setErrors(["Erro ao atualizar usuário"]);
            }
        }
    };

    // Logout JWT
    const handleLogout = () => {
        localStorage.removeItem("token");
        navigate("/");
    };

    if (loading) return <h2>Carregando...</h2>;

    return (
        <div className="bg-light min-vh-100">

            {/* Navbar */}
            <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
                <div className="container-fluid">
                    <span
                        className="navbar-brand text-light"
                        style={{ cursor: "pointer" }}
                        onClick={() => navigate("/inicio")}   // <--- redireciona!
                    >
                        Marca I
                    </span>

                    <button className="btn btn-danger btn-sm" onClick={handleLogout}>
                        Sair
                    </button>
                </div>
            </nav>

            <div className="container mt-5">
                <div className="card shadow-sm">

                    <div className="card-header bg-white">
                        <h4>Editar Usuário</h4>
                    </div>

                    <div className="card-body">
                        {successMessage && (
                            <div className="alert alert-success">{successMessage}</div>
                        )}

                        {errors.length > 0 && (
                            <div className="alert alert-danger">
                                <ul>
                                    {errors.map((err, index) => (
                                        <li key={index}>{err}</li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label">Nome:</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    required
                                />
                            </div>

                            <div className="mb-3">
                                <label className="form-label">E-mail:</label>
                                <input
                                    type="email"
                                    className="form-control"
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

                            <button type="submit" className="btn btn-success">
                                Confirmar Mudanças
                            </button>

                            <button
                                type="button"
                                className="btn btn-secondary ms-2"
                                onClick={() => navigate("/usuario")}
                            >
                                Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}
