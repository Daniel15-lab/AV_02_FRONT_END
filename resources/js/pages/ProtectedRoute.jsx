import React, { useEffect, useState } from "react";
import { Navigate } from "react-router-dom";

export default function ProtectedRoute({ children }) {
    const [loading, setLoading] = useState(true);
    const [isLogged, setIsLogged] = useState(false);

    useEffect(() => {
        fetch("/user-logado", {
            credentials: "same-origin", // envia cookies da sessão Laravel
        })
            .then((res) => res.json())
            .then((data) => {
                setIsLogged(data.auth);
                setLoading(false);
            })
            .catch(() => {
                setIsLogged(false);
                setLoading(false);
            });
    }, []);

    if (loading) return <p>Carregando...</p>;
    if (!isLogged) return <Navigate to="/" replace />;

    return children;
}
