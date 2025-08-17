<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio de Sesión</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/landing/login.css', 'resources/js/landing/login.js'])
</head>
<body>
  <div class="card">
    <h1>🔐 Iniciar sesión</h1>
    <form id="form">
      <div class="form-group">
        <label>Correo</label>
        <input name="email" type="email" required placeholder="tu@email.com">
      </div>
      <div class="form-group">
        <label>Clave</label>
        <input name="password" type="password" required placeholder="••••••••">
      </div>
      <button type="submit" class="btn-primary">Entrar</button>
    </form>
    <div id="msg" class="msg"></div>
    <div class="small">¿Aún no tienes una cuenta? <a class="ancla-footer" href="/registro">Regístrate gratis</a></div>
  </div>
</body>
</html>