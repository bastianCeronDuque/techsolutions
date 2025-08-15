<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio de Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite(['resources/css/landing/login.css'])
</head>
<body>
  <div class="card">
    <h1>🔐 Iniciar sesión</h1>
    <form id="form">
      <label>Correo</label>
      <input name="email" type="email" required>
      <label>Clave</label>
      <input name="password" type="password" required>
      <button class="btn-primary">Entrar</button>
    </form>
    <div class="msg" id="msg"></div>
    <div class="card2"></div>
    <div class="small">¿No tienes cuenta? <a href="/registro">Regístrate</a></div>
  </div>

  <script>
    const form = document.getElementById('form');
    const msg = document.getElementById('msg');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      msg.textContent = '⏳ Validando...';
      const data = Object.fromEntries(new FormData(form));
      const res = await fetch('/api/login', {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'Accept':'application/json'},
        body: JSON.stringify(data)
      });

      const json = await res.json();
      if (res.ok) {
        msg.textContent = '✅ Login OK.\nToken guardado en localStorage.\n' +
                          'Prueba /api/me con el botón de abajo.';
        localStorage.setItem('token', json.token);
      } else {
        msg.textContent = '❌ ' + (json.message || 'Error') + '\n' + JSON.stringify(json.errors || {}, null, 2);
      }
    });

    // Botón para /api/me
    const btn = document.createElement('button');
    btn.textContent = 'Probar /api/me';
    btn.style.marginTop = '10px';
    document.querySelector('.card2').appendChild(btn);
    btn.addEventListener('click', async () => {
      const token = localStorage.getItem('token');
      if (!token) return msg.textContent = '⚠️ No hay token. Inicia sesión primero.';
      const res = await fetch('/api/me', {
        headers: {'Authorization': 'Bearer ' + token, 'Accept': 'application/json'}
      });
      const json = await res.json();
      msg.textContent = res.ok ? ('👤 Usuario:\n' + JSON.stringify(json.user, null, 2))
                               : ('❌ ' + (json.message || 'No autorizado'));
    });
  </script>
</body>
</html>
