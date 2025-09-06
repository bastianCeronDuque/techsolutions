<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TechSolutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .stat-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .stat-card.warning {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #333;
        }
        
        .stat-card.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }
        
        .project-card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-left: 4px solid #4facfe;
        }
        
        .project-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .navbar-custom {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            margin-bottom: 2rem;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            color: white;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pendiente { background: #fff3cd; color: #856404; }
        .status-en_progreso { background: #d1ecf1; color: #0c5460; }
        .status-completado { background: #d4edda; color: #155724; }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }
        
        .uf-container {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Header Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="fas fa-rocket me-2"></i>TechSolutions
                </a>
                
                <div class="d-flex align-items-center">
                    <!-- UF Value -->
                    <div class="uf-container me-4">
                        <x-uf-value />
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" 
                           id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2 fs-5"></i>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-2">¡Bienvenido, {{ auth()->user()->name }}! 👋</h1>
                            <p class="text-muted mb-0">Gestiona tus proyectos de manera eficiente desde aquí</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('projects.create') }}" class="btn btn-gradient btn-lg">
                                <i class="fas fa-plus me-2"></i>Nuevo Proyecto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-project-diagram fa-3x mb-3"></i>
                    <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
                    <div>Total Proyectos</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card success">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <div class="stat-number">{{ $stats['completados'] ?? 0 }}</div>
                    <div>Completados</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card warning">
                    <i class="fas fa-clock fa-3x mb-3"></i>
                    <div class="stat-number">{{ $stats['en_progreso'] ?? 0 }}</div>
                    <div>En Progreso</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card purple">
                    <i class="fas fa-dollar-sign fa-3x mb-3"></i>
                    <div class="stat-number">${{ number_format($stats['inversion_total'] ?? 0, 0, ',', '.') }}</div>
                    <div>Inversión Total</div>
                </div>
            </div>
        </div>

        <!-- Projects Management Section -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    <!-- Section Header -->
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <h3 class="mb-0">
                                <i class="fas fa-tasks me-2 text-primary"></i>Mis Proyectos Recientes
                            </h3>
                            <small class="text-muted">Últimos 6 proyectos creados</small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Ver Todos
                            </a>
                        </div>
                    </div>

                    @if(isset($recentProjects) && $recentProjects->count() > 0)
                        <!-- Projects Grid -->
                        <div class="row g-3">
                            @foreach($recentProjects as $project)
                            <div class="col-md-6 col-lg-4">
                                <div class="card project-card h-100">
                                    <div class="card-body">
                                        <!-- Project Header -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="card-title mb-0 fw-bold text-truncate" style="max-width: 70%;">
                                                {{ $project->nombre }}
                                            </h6>
                                            <span class="status-badge status-{{ $project->estado }}">
                                                {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Project Info -->
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                {{ $project->fecha_inicio->format('d/m/Y') }}
                                            </small>
                                            <small class="text-muted d-block mb-1">
                                                <i class="fas fa-user me-2"></i>
                                                {{ $project->responsable }}
                                            </small>
                                            <small class="text-success fw-bold d-block">
                                                <i class="fas fa-dollar-sign me-2"></i>
                                                ${{ number_format($project->monto, 0, ',', '.') }} CLP
                                            </small>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('projects.show', $project) }}" 
                                               class="btn btn-sm btn-outline-primary flex-fill"
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('projects.edit', $project) }}" 
                                               class="btn btn-sm btn-outline-warning flex-fill"
                                               title="Editar proyecto">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('projects.destroy', $project) }}" 
                                                  method="POST" class="flex-fill" 
                                                  onsubmit="return confirm('¿Estás seguro de eliminar el proyecto \'{{ $project->nombre }}\'?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" title="Eliminar proyecto">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Show More Button -->
                        @if($recentProjects->count() >= 6)
                        <div class="text-center mt-4">
                            <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-right me-2"></i>Ver Más Proyectos
                            </a>
                        </div>
                        @endif

                    @else
                        <!-- Empty State -->
                        <div class="empty-state">
                            <i class="fas fa-folder-open fa-5x text-muted mb-4"></i>
                            <h4 class="text-muted mb-3">¡Aún no tienes proyectos!</h4>
                            <p class="text-muted mb-4">Crea tu primer proyecto para comenzar a gestionar tus ideas y darles seguimiento.</p>
                            <a href="{{ route('projects.create') }}" class="btn btn-gradient btn-lg">
                                <i class="fas fa-plus me-2"></i>Crear Mi Primer Proyecto
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions (Bottom) -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="dashboard-card p-3">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('projects.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>Nuevo Proyecto
                        </a>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>Todos los Proyectos
                        </a>
                        <button class="btn btn-outline-info" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dashboard Scripts -->
    <script>
        // Auto-refresh cada 5 minutos para actualizar UF
        setTimeout(() => {
            location.reload();
        }, 300000);

        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Success message auto-hide
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>