<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/landing/dashboard.css', 'resources/js/landing/dashboard.js'])
</head>

<body>
    <div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <span>🔒</span>
                <h2>MiApp</h2>
            </div>
            <nav>
                <ul>
                    <li class="active"><a href="#"><i class="icon">📊</i> Dashboard</a></li>
                    <li><a href="#"><i class="icon">👤</i> Perfil</a></li>
                    <li><a href="#"><i class="icon">⚙️</i> Configuración</a></li>
                    <li><a href="#"><i class="icon">📝</i> Contenido</a></li>
                </ul>
            </nav>
            <div class="logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class="icon">🚪</i> Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <div class="user-info">
                    <span>👋 Hola, {{ Auth::user()->name }}</span>
                </div>
            </header>

            <div class="content">
                <div class="cards-container">
                    <!-- Card 1 -->
                    <div class="card">
                        <div class="card-header">
                            <h3>📈 Estadísticas</h3>
                        </div>
                        <div class="card-body">
                            <p>Bienvenido a tu panel de control</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="card">
                        <div class="card-header">
                            <h3>🔄 Actividad reciente</h3>
                        </div>
                        <div class="card-body">
                            <ul class="activity-list">
                                <li>✅ Sesión iniciada hoy</li>
                                <li>🕒 Último acceso: {{ now()->format('d/m/Y H:i') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Sección adicional -->
                <div class="quick-actions">
                    <button class="action-btn">
                        <span>➕</span>
                        <span>Nuevo proyecto</span>
                    </button>
                    <button class="action-btn">
                        <span>📤</span>
                        <span>Exportar datos</span>
                    </button>
                </div>
            </div>
        </main>
    </div>
</body>

</html>