<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar: {{ $project->nombre }} - TechSolutions</title>
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
            background: #f39c12;
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

        .project-id {
            position: absolute;
            top: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .content {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 35px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #f39c12;
            background: white;
            box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1);
        }

        .form-group select {
            cursor: pointer;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #ecf0f1;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        .error-list {
            list-style: none;
            margin-top: 10px;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        .error-list li:before {
            content: "❌ ";
        }

        .input-icon {
            position: relative;
        }

        .input-icon::before {
            content: attr(data-icon);
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            pointer-events: none;
            font-size: 1.2rem;
        }

        .input-icon input,
        .input-icon select {
            padding-left: 45px;
        }

        .form-help {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .required {
            color: #e74c3c;
        }

        .current-value {
            background: #e8f6f3;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            color: #27ae60;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
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

        .form-comparison {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #f39c12;
        }

        .comparison-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .comparison-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .comparison-label {
            color: #7f8c8d;
        }

        .comparison-value {
            color: #2c3e50;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .header {
                text-align: center;
            }

            .project-id {
                position: static;
                margin-top: 15px;
                display: inline-block;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="project-id">ID: #{{ $project->id }}</div>
            <h1>✏️ Editar Proyecto</h1>
            <p>Modifica la información del proyecto: {{ $project->nombre }}</p>
        </div>

        <div class="content">
            @if ($errors->any())
                <div class="alert alert-error">
                    <strong>❌ Error en el formulario:</strong>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="form-comparison">
                <div class="comparison-title">📊 Información Actual del Proyecto</div>
                <div class="comparison-row">
                    <span class="comparison-label">Estado:</span>
                    <span class="status-badge status-{{ $project->estado }}">
                        {{ ucwords(str_replace('_', ' ', $project->estado)) }}
                    </span>
                </div>
                <div class="comparison-row">
                    <span class="comparison-label">Presupuesto:</span>
                    <span class="comparison-value">${{ number_format($project->monto, 0, ',', '.') }} CLP</span>
                </div>
                <div class="comparison-row">
                    <span class="comparison-label">Creado:</span>
                    <span class="comparison-value">{{ $project->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="comparison-row">
                    <span class="comparison-label">Última actualización:</span>
                    <span class="comparison-value">{{ $project->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('projects.update', $project) }}">
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="section-title">
                        📋 Información Básica
                    </div>

                    <div class="form-group">
                        <label for="nombre">
                            📋 Nombre del Proyecto <span class="required">*</span>
                        </label>
                        <div class="current-value">
                            💾 Valor actual: {{ $project->nombre }}
                        </div>
                        <div class="input-icon" data-icon="📋">
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $project->nombre) }}"
                                   placeholder="Ingresa el nuevo nombre del proyecto"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        🗓️ Planificación y Estado
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fecha_inicio">
                                📅 Fecha de Inicio <span class="required">*</span>
                            </label>
                            <div class="current-value">
                                💾 Valor actual: {{ $project->fecha_inicio->format('d/m/Y') }}
                            </div>
                            <div class="input-icon" data-icon="📅">
                                <input type="date" 
                                       id="fecha_inicio" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', $project->fecha_inicio->format('Y-m-d')) }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estado">
                                🔄 Estado <span class="required">*</span>
                            </label>
                            <div class="current-value">
                                💾 Estado actual: 
                                <span class="status-badge status-{{ $project->estado }}">
                                    {{ ucwords(str_replace('_', ' ', $project->estado)) }}
                                </span>
                            </div>
                            <div class="input-icon" data-icon="🔄">
                                <select id="estado" name="estado" required>
                                    <option value="pendiente" {{ old('estado', $project->estado) == 'pendiente' ? 'selected' : '' }}>
                                        ⏳ Pendiente
                                    </option>
                                    <option value="en_progreso" {{ old('estado', $project->estado) == 'en_progreso' ? 'selected' : '' }}>
                                        🔄 En Progreso
                                    </option>
                                    <option value="completado" {{ old('estado', $project->estado) == 'completado' ? 'selected' : '' }}>
                                        ✅ Completado
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title">
                        👥 Responsabilidad y Presupuesto
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="responsable">
                                👤 Responsable <span class="required">*</span>
                            </label>
                            <div class="current-value">
                                💾 Valor actual: {{ $project->responsable }}
                            </div>
                            <div class="input-icon" data-icon="👤">
                                <input type="text" 
                                       id="responsable" 
                                       name="responsable" 
                                       value="{{ old('responsable', $project->responsable) }}"
                                       placeholder="Nombre del responsable"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="monto">
                                💰 Monto (CLP) <span class="required">*</span>
                            </label>
                            <div class="current-value">
                                💾 Valor actual: ${{ number_format($project->monto, 0, ',', '.') }} CLP
                            </div>
                            <div class="input-icon" data-icon="💰">
                                <input type="number" 
                                       id="monto" 
                                       name="monto" 
                                       value="{{ old('monto', $project->monto) }}"
                                       placeholder="0"
                                       min="0"
                                       max="999999999.99"
                                       step="0.01"
                                       required>
                            </div>
                            <div class="form-help">Presupuesto total del proyecto en pesos chilenos</div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-warning">
                        💾 Guardar Cambios
                    </button>
                    
                    <a href="{{ route('projects.show', $project) }}" class="btn btn-primary">
                        👁️ Ver Proyecto
                    </a>
                    
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Mostrar confirmación de cambios
        document.querySelector('form').addEventListener('submit', function(e) {
            const originalName = "{{ $project->nombre }}";
            const newName = document.getElementById('nombre').value;
            
            const originalMonto = {{ $project->monto }};
            const newMonto = parseFloat(document.getElementById('monto').value);
            
            let changes = [];
            
            if (originalName !== newName) {
                changes.push('• Nombre: "' + originalName + '" → "' + newName + '"');
            }
            
            if (originalMonto !== newMonto) {
                changes.push('• Monto: $' + originalMonto.toLocaleString() + ' → $' + newMonto.toLocaleString());
            }
            
            if (changes.length > 0) {
                const confirmMessage = '¿Confirmas los siguientes cambios?\n\n' + changes.join('\n');
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            }
        });

        // Formatear el campo de monto mientras se escribe
        document.getElementById('monto').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value && !isNaN(value)) {
                let formatted = new Intl.NumberFormat('es-CL').format(value);
                console.log('Nuevo monto: $' + formatted);
            }
        });

        // Resaltar cambios en tiempo real
        const originalValues = {
            nombre: "{{ $project->nombre }}",
            responsable: "{{ $project->responsable }}",
            monto: {{ $project->monto }},
            estado: "{{ $project->estado }}",
            fecha_inicio: "{{ $project->fecha_inicio->format('Y-m-d') }}"
        };

        Object.keys(originalValues).forEach(function(field) {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', function() {
                    if (this.value != originalValues[field]) {
                        this.style.borderColor = '#f39c12';
                        this.style.backgroundColor = '#fef9e7';
                    } else {
                        this.style.borderColor = '#ecf0f1';
                        this.style.backgroundColor = '#f8f9fa';
                    }
                });
            }
        });
    </script>
</body>
</html>
