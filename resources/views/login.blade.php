<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio de Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite(['resources/css/landing/login.css', 'resources/js/landing/login.js'])
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
</body>
</html>
