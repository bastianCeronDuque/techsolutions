form.addEventListener("submit", async (e) => {
    e.preventDefault();
    msg.innerHTML = '<div class="loading">⏳ Validando credenciales...</div>';

    try {
        const res = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            credentials: "same-origin", // Importante para que las cookies se incluyan
            body: JSON.stringify({
                email: form.email.value,
                password: form.password.value,
            }),
        });

        const data = await res.json();

        if (!res.ok) throw data;

        // Opcional: aún podemos guardar el token en localStorage como respaldo
        // pero el más importante es la cookie HttpOnly que se establece automáticamente
        if (data.token) {
            localStorage.setItem("token", data.token);
        }

        msg.innerHTML = "✅ <strong>¡Bienvenido!</strong><br>Redirigiendo...";

        setTimeout(() => {
            // Pasar el token también como query parameter como respaldo
            const token = data.token;
            window.location.href = `/dashboard?token=${encodeURIComponent(
                token
            )}`;
        }, 1500);
    } catch (error) {
        console.error("Error:", error);
        msg.innerHTML = `❌ ${error.message || "Error de autenticación"}<br>
            <small>${JSON.stringify(error.errors || {}, null, 2)}</small>`;
    }
});
