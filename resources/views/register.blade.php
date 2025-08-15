<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: system-ui, Arial;
            margin: 0;
            display: grid;
            place-items: center;
            min-height: 100vh;
            background: #f5f7fb
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            width: min(420px, 92vw)
        }

        h1 {
            margin: 0 0 16px
        }

        label {
            display: block;
            margin: 12px 0 4px
        }

        input {
            width: 90%;
            padding: 12px;
            border: 1px solid #dcdfe4;
            border-radius: 10px
        }

        button {
            margin-top: 16px;
            padding: 12px 16px;
            border: 0;
            border-radius: 10px;
            background: #4f46e5;
            color: #fff;
            font-weight: 600;
            cursor: pointer
        }

        .msg {
            margin-top: 12px;
            font-size: 14px;
            white-space: pre-wrap
        }

        .small {
            margin-top: 10px;
            font-size: 13px
        }

        a {
            color: #4f46e5
        }
    </style>
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