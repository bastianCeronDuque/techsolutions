form.addEventListener("submit", async (e) => {
    e.preventDefault();
    msg.innerHTML = '<div class="loading">⏳ Validando credenciales...</div>';

    try {
        const res = await fetch("/api/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({
                email: form.email.value,
                password: form.password.value
            })
        });

        const data = await res.json();

        if (!res.ok) throw data;

        localStorage.setItem("token", data.token);
        msg.innerHTML = '✅ <strong>¡Bienvenido!</strong><br>Redirigiendo...';
        
        setTimeout(() => {
            window.location.href = "/dashboard";
        }, 1500);

    } catch (error) {
        console.error('Error:', error);
        msg.innerHTML = `❌ ${error.message || 'Error de autenticación'}<br>
            <small>${JSON.stringify(error.errors || {}, null, 2)}</small>`;
    }
});