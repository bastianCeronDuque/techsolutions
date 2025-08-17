<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/landing/register.css', 'resources/js/landing/register.js'])
</head>
<body>
    <div class="card">
        <h1>📝 Registro</h1>
        <!-- Cambiado a id="registerForm" para coincidir con el JS -->
        <form id="registerForm">
            @csrf
            <div class="form-group">
                <label>Nombre completo</label>
                <input name="name" type="text" required placeholder="Ej: María González">
            </div>
            
            <div class="form-group">
                <label>Correo electrónico</label>
                <input name="email" type="email" required placeholder="ejemplo@correo.com">
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input name="password" type="password" required minlength="6" placeholder="Mínimo 6 caracteres">
            </div>
            
            <div class="form-group">
                <label>Confirmar contraseña</label>
                <input name="password_confirmation" type="password" required placeholder="Repite tu contraseña">
            </div>
            
            <!-- Cambiado a id="registerBtn" -->
            <button type="submit" class="btn-primary" id="registerBtn">
                <span class="btn-text">Crear cuenta</span>
                <span class="btn-loading hidden">⌛</span>
            </button>
        </form>
        <!-- Asegúrate que este div exista -->
        <div id="registerMsg" class="msg"></div>
        <div class="small">¿Ya tienes una cuenta? <a class="ancla-footer" href="/login">Inicia sesión</a></div>
    </div>
</body>
</html>