<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/landing/register.css'])
</head>

<body>
    <div class="card">
        <h1>📝 Registro</h1>
        <form id="form">
            <label>Nombre</label>
            <input name="name" required>
            <label>Correo</label>
            <input name="email" type="email" required>
            <label>Clave</label>
            <input name="password" type="password" required minlength="6">
            <button>Crear cuenta</button>
        </form>
        <div class="msg" id="msg"></div>
        <div class="small">¿Ya tienes cuenta? <a href="/login">Inicia sesión</a></div>
    </div>

    <script>
        const form = document.getElementById('form');
        const msg = document.getElementById('msg');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            msg.textContent = '⏳ Enviando...';
            const data = Object.fromEntries(new FormData(form));
            const res = await fetch('/api/register', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            msg.textContent = res.ok
                ? '✅ ' + json.message + '\nTu token:\n' + json.token
                : '❌ ' + (json.message || 'Error') + '\n' + JSON.stringify(json.errors || {}, null, 2);
        });
    </script>
</body>

</html>