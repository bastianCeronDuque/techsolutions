<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proyecto - TechSolutions</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: #27ae60;
            color: white;
            padding: 30px;
            text-align: center;
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

        .content {
            padding: 40px;
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
            border-color: #27ae60;
            background: white;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }

        .form-group select {
            cursor: pointer;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
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

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
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

        @media (max-width: 768px) {
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
            <h1>➕ Crear Nuevo Proyecto</h1>
            <p>Completa la información para crear un nuevo proyecto</p>
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

            <form method="POST" action="{{ route('projects.store') }}">
                @csrf

                <div class="form-group">
                    <label for="nombre">
                        📋 Nombre del Proyecto <span class="required">*</span>
                    </label>
                    <div class="input-icon" data-icon="📋">
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}"
                               placeholder="Ingresa el nombre del proyecto"
                               required>
                    </div>
                    <div class="form-help">Ejemplo: Sistema de Gestión de Inventario</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">
                            📅 Fecha de Inicio <span class="required">*</span>
                        </label>
                        <div class="input-icon" data-icon="📅">
                            <input type="date" 
                                   id="fecha_inicio" 
                                   name="fecha_inicio" 
                                   value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="estado">
                            🔄 Estado <span class="required">*</span>
                        </label>
                        <div class="input-icon" data-icon="🔄">
                            <select id="estado" name="estado" required>
                                <option value="">Selecciona un estado</option>
                                <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>
                                    ⏳ Pendiente
                                </option>
                                <option value="en_progreso" {{ old('estado') == 'en_progreso' ? 'selected' : '' }}>
                                    🔄 En Progreso
                                </option>
                                <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>
                                    ✅ Completado
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="responsable">
                            👤 Responsable <span class="required">*</span>
                        </label>
                        <div class="input-icon" data-icon="👤">
                            <input type="text" 
                                   id="responsable" 
                                   name="responsable" 
                                   value="{{ old('responsable') }}"
                                   placeholder="Nombre del responsable"
                                   required>
                        </div>
                        <div class="form-help">Persona encargada de liderar el proyecto</div>
                    </div>

                    <div class="form-group">
                        <label for="monto">
                            💰 Monto (CLP) <span class="required">*</span>
                        </label>
                        <div class="input-icon" data-icon="💰">
                            <input type="number" 
                                   id="monto" 
                                   name="monto" 
                                   value="{{ old('monto') }}"
                                   placeholder="0"
                                   min="0"
                                   max="999999999.99"
                                   step="0.01"
                                   required>
                        </div>
                        <div class="form-help">Presupuesto total del proyecto en pesos chilenos</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        ✅ Crear Proyecto
                    </button>
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Formatear el campo de monto mientras se escribe
        document.getElementById('monto').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value && !isNaN(value)) {
                // Solo mostrar formato en el placeholder o ayuda visual
                let formatted = new Intl.NumberFormat('es-CL').format(value);
                console.log('Monto: $' + formatted);
            }
        });

        // Validación del formulario antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const responsable = document.getElementById('responsable').value.trim();
            const monto = document.getElementById('monto').value;

            if (nombre.length < 3) {
                alert('❌ El nombre del proyecto debe tener al menos 3 caracteres');
                e.preventDefault();
                return;
            }

            if (responsable.length < 2) {
                alert('❌ El nombre del responsable debe tener al menos 2 caracteres');
                e.preventDefault();
                return;
            }

            if (monto <= 0) {
                alert('❌ El monto debe ser mayor a cero');
                e.preventDefault();
                return;
            }

            // Confirmación antes de crear
            if (!confirm(`¿Confirmas crear el proyecto "${nombre}"?`)) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
