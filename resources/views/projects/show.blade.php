<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->nombre }} - TechSolutions</title>
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
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: #3498db;
            color: white;
            padding: 30px;
            position: relative;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .status-indicator {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .status-pendiente {
            background: rgba(255, 243, 205, 0.9);
            color: #856404;
        }

        .status-en_progreso {
            background: rgba(209, 236, 241, 0.9);
            color: #0c5460;
        }

        .status-completado {
            background: rgba(212, 237, 218, 0.9);
            color: #155724;
        }

        .content {
            padding: 40px;
        }

        .project-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .detail-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            border-left: 5px solid #3498db;
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .detail-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .detail-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 1.3rem;
            color: #34495e;
            font-weight: 500;
        }

        .detail-value.monto {
            color: #27ae60;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .detail-value.date {
            color: #e67e22;
        }

        .detail-value.responsable {
            color: #8e44ad;
        }

        .project-info {
            background: #ecf0f1;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #bdc3c7;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-value {
            color: #34495e;
            font-weight: 500;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            padding-top: 30px;
            border-top: 2px solid #ecf0f1;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
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

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .project-meta {
            background: white;
            border: 1px solid #ecf0f1;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .meta-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #3498db;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -23px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3498db;
        }

        .days-elapsed {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .header {
                text-align: center;
            }

            .status-indicator {
                position: static;
                margin-top: 15px;
                display: inline-block;
            }

            .project-details {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="status-indicator status-{{ $project->estado }}">
                @if($project->estado === 'pendiente') ⏳ @endif
                @if($project->estado === 'en_progreso') 🔄 @endif  
                @if($project->estado === 'completado') ✅ @endif
                {{ ucwords(str_replace('_', ' ', $project->estado)) }}
            </div>
            <h1>👁️ {{ $project->nombre }}</h1>
            <p>Detalles completos del proyecto</p>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="project-details">
                <div class="detail-card">
                    <span class="detail-icon">💰</span>
                    <div class="detail-title">Presupuesto</div>
                    <div class="detail-value monto">
                        ${{ number_format($project->monto, 0, ',', '.') }} CLP
                    </div>
                </div>

                <div class="detail-card">
                    <span class="detail-icon">📅</span>
                    <div class="detail-title">Fecha de Inicio</div>
                    <div class="detail-value date">
                        {{ $project->fecha_inicio->format('d/m/Y') }}
                    </div>
                    <div class="days-elapsed">
                        {{ $project->fecha_inicio->diffForHumans() }}
                    </div>
                </div>

                <div class="detail-card">
                    <span class="detail-icon">👤</span>
                    <div class="detail-title">Responsable</div>
                    <div class="detail-value responsable">
                        {{ $project->responsable }}
                    </div>
                </div>
            </div>

            <div class="project-meta">
                <div class="meta-title">
                    📊 Información del Proyecto
                </div>
                
                <div class="project-info">
                    <div class="info-row">
                        <div class="info-label">
                            🆔 ID del Proyecto
                        </div>
                        <div class="info-value">#{{ $project->id }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            📋 Nombre del Proyecto
                        </div>
                        <div class="info-value">{{ $project->nombre }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            🔄 Estado Actual
                        </div>
                        <div class="info-value">
                            <span class="status-indicator status-{{ $project->estado }}" style="position: static; padding: 5px 15px; font-size: 0.8rem;">
                                {{ ucwords(str_replace('_', ' ', $project->estado)) }}
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            📅 Fecha de Inicio
                        </div>
                        <div class="info-value">{{ $project->fecha_inicio->format('d/m/Y') }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            👤 Responsable
                        </div>
                        <div class="info-value">{{ $project->responsable }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            💰 Presupuesto
                        </div>
                        <div class="info-value" style="color: #27ae60; font-weight: bold;">
                            ${{ number_format($project->monto, 0, ',', '.') }} CLP
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            👨‍💼 Creado por
                        </div>
                        <div class="info-value">{{ $project->creator->name ?? 'Usuario' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            📅 Fecha de Creación
                        </div>
                        <div class="info-value">{{ $project->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($project->updated_at != $project->created_at)
                    <div class="info-row">
                        <div class="info-label">
                            ✏️ Última Modificación
                        </div>
                        <div class="info-value">{{ $project->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="project-meta">
                <div class="meta-title">
                    📈 Línea de Tiempo
                </div>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <strong>Proyecto Creado</strong>
                        <div class="days-elapsed">{{ $project->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    @if($project->updated_at != $project->created_at)
                    <div class="timeline-item">
                        <strong>Última Actualización</strong>
                        <div class="days-elapsed">{{ $project->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                    
                    <div class="timeline-item">
                        <strong>Inicio Programado</strong>
                        <div class="days-elapsed">{{ $project->fecha_inicio->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                    ⬅️ Volver a la Lista
                </a>
                
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
                    ✏️ Editar Proyecto
                </a>

                <form method="POST" action="{{ route('projects.destroy', $project) }}" 
                      style="display: inline;"
                      onsubmit="return confirm('⚠️ ¿Estás seguro de eliminar el proyecto \'{{ $project->nombre }}\'?\n\nEsta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        🗑️ Eliminar Proyecto
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
