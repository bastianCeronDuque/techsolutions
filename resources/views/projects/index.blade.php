<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos - TechSolutions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 300;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #27ae60;
            color: white;
            font-size: 0.9rem;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
            font-size: 0.9rem;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-logout {
            background: #95a5a6;
            color: white;
        }

        .btn-logout:hover {
            background: #7f8c8d;
        }

        .content {
            padding: 40px;
        }

        .actions {
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .stats {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .stat-label {
            color: #7f8c8d;
            margin-top: 5px;
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .project-card {
            background: white;
            border: 1px solid #ecf0f1;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .project-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .project-details {
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .detail-label {
            font-weight: 600;
            color: #34495e;
        }

        .detail-value {
            color: #7f8c8d;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-en_progreso {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-completado {
            background: #d4edda;
            color: #155724;
        }

        .project-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .monto {
            font-size: 1.2rem;
            font-weight: bold;
            color: #27ae60;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .actions {
                flex-direction: column;
                align-items: stretch;
            }

            .projects-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Mis Proyectos</h1>
            <div class="user-info">
                <p>👤 {{ auth()->user()->name }}</p>
                <p>✉️ {{ auth()->user()->email }}</p>
                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">🏠 Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-logout">🚪 Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="actions">
                <a href="{{ route('projects.create') }}" class="btn btn-success">
                    ➕ Nuevo Proyecto
                </a>
                <x-uf-value />
            </div>

            @if($projects->count() > 0)
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number">{{ $projects->count() }}</div>
                        <div class="stat-label">Total Proyectos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $projects->where('estado', 'completado')->count() }}</div>
                        <div class="stat-label">Completados</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $projects->where('estado', 'en_progreso')->count() }}</div>
                        <div class="stat-label">En Progreso</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${{ number_format($projects->sum('monto'), 0, ',', '.') }}</div>
                        <div class="stat-label">Inversión Total</div>
                    </div>
                </div>

                <div class="projects-grid">
                    @foreach($projects as $project)
                        <div class="project-card">
                            <div class="project-title">
                                {{ $project->nombre }}
                            </div>
                            
                            <div class="project-details">
                                <div class="detail-row">
                                    <span class="detail-label">📅 Fecha Inicio:</span>
                                    <span class="detail-value">{{ $project->fecha_inicio->format('d/m/Y') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">👤 Responsable:</span>
                                    <span class="detail-value">{{ $project->responsable }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">💰 Monto:</span>
                                    <span class="detail-value monto">${{ number_format($project->monto, 0, ',', '.') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">🔄 Estado:</span>
                                    <span class="status-badge status-{{ $project->estado }}">
                                        {{ ucwords(str_replace('_', ' ', $project->estado)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="project-actions">
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-primary">
                                    👁️ Ver
                                </a>
                                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
                                    ✏️ Editar
                                </a>
                                <form method="POST" action="{{ route('projects.destroy', $project) }}" 
                                      style="display: inline;"
                                      onsubmit="return confirm('¿Estás seguro de eliminar el proyecto \'{{ $project->nombre }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 4rem; margin-bottom: 20px;">📋</div>
                    <h3>No tienes proyectos aún</h3>
                    <p>¡Crea tu primer proyecto para empezar!</p>
                    <div style="margin-top: 30px;">
                        <a href="{{ route('projects.create') }}" class="btn btn-success">
                            ➕ Crear mi primer proyecto
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
