@extends('layouts.app')

@section('title', 'Editar: ' . $project->nombre . ' - TechSolutions')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/project-edit.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="project-edit-header">
        <div class="project-id">ID: #{{ $project->id }}</div>
        <h1>✏️ Editar Proyecto</h1>
        <p>Modifica la información del proyecto: <strong>{{ e($project->nombre) }}</strong></p>
    </div>

    <div class="project-edit-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>¡Error!</strong> Por favor corrige los siguientes problemas:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Información actual del proyecto --}}
        <div class="current-project-info">
            <h5 class="mb-3">📊 Información Actual del Proyecto</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <label>Nombre:</label>
                        <span>{{ e($project->nombre) }}</span>
                    </div>
                    <div class="info-item">
                        <label>Responsable:</label>
                        <span>{{ e($project->responsable) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <label>Monto:</label>
                        <span>${{ number_format($project->monto, 0, ',', '.') }} CLP</span>
                    </div>
                    <div class="info-item">
                        <label>Estado:</label>
                        <span class="badge bg-{{ $project->estado === 'completado' ? 'success' : ($project->estado === 'en_progreso' ? 'warning' : 'secondary') }}">
                            {{ ucfirst(str_replace('_', ' ', $project->estado)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulario de edición --}}
        <form method="POST" action="{{ route('projects.update', $project) }}" id="editProjectForm">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Proyecto <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $project->nombre) }}" 
                               required 
                               maxlength="255"
                               placeholder="Ingrese el nombre del proyecto">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('responsable') is-invalid @enderror" 
                               id="responsable" 
                               name="responsable" 
                               value="{{ old('responsable', $project->responsable) }}" 
                               required 
                               maxlength="255"
                               placeholder="Nombre del responsable del proyecto">
                        @error('responsable')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto (CLP) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   class="form-control @error('monto') is-invalid @enderror" 
                                   id="monto" 
                                   name="monto" 
                                   value="{{ old('monto', $project->monto) }}" 
                                   min="0" 
                                   max="999999999.99" 
                                   step="0.01" 
                                   required
                                   placeholder="0.00">
                            <span class="input-group-text">CLP</span>
                        </div>
                        <div class="form-text">Ingrese el presupuesto total del proyecto en pesos chilenos.</div>
                        @error('monto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                        <select class="form-select @error('estado') is-invalid @enderror" 
                                id="estado" 
                                name="estado" 
                                required>
                            <option value="pendiente" @selected(old('estado', $project->estado) === 'pendiente')>
                                ⏳ Pendiente
                            </option>
                            <option value="en_progreso" @selected(old('estado', $project->estado) === 'en_progreso')>
                                🔄 En Progreso
                            </option>
                            <option value="completado" @selected(old('estado', $project->estado) === 'completado')>
                                ✅ Completado
                            </option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('fecha_inicio') is-invalid @enderror" 
                               id="fecha_inicio" 
                               name="fecha_inicio" 
                               value="{{ old('fecha_inicio', optional($project->fecha_inicio)->format('Y-m-d')) }}" 
                               required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-warning me-2">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-info me-2">
                    <i class="fas fa-eye"></i> Ver Proyecto
                </a>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- Datos del proyecto para JavaScript --}}
<script id="project-data" type="application/json">
{!! json_encode([
    'nombre' => $project->nombre,
    'responsable' => $project->responsable,
    'monto' => floatval($project->monto),
    'estado' => $project->estado,
    'fecha_inicio' => $project->fecha_inicio ? $project->fecha_inicio->format('Y-m-d') : ''
]) !!}
</script>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editProjectForm');
    
    // Obtener datos del proyecto desde el script JSON
    const projectDataElement = document.getElementById('project-data');
    const originalValues = JSON.parse(projectDataElement.textContent);

    // Confirmar cambios antes de enviar
    form.addEventListener('submit', function(e) {
        const changes = [];
        
        Object.keys(originalValues).forEach(field => {
            const input = document.getElementById(field);
            if (input && input.value != originalValues[field]) {
                const label = document.querySelector(`label[for="${field}"]`)?.textContent?.replace(' *', '') || field;
                changes.push(`• ${label}: "${originalValues[field]}" → "${input.value}"`);
            }
        });

        if (changes.length > 0) {
            const confirmMessage = '¿Confirmas los siguientes cambios?\n\n' + changes.join('\n');
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
        }
    });

    // Resaltar campos modificados en tiempo real
    Object.keys(originalValues).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.addEventListener('input', function() {
                // Para el campo monto, convertir a float para comparar correctamente
                let currentValue = this.value;
                let originalValue = originalValues[field];
                
                if (field === 'monto') {
                    currentValue = parseFloat(currentValue) || 0;
                    originalValue = parseFloat(originalValue) || 0;
                }
                
                if (currentValue != originalValue) {
                    this.classList.add('changed-field');
                } else {
                    this.classList.remove('changed-field');
                }
            });
        }
    });
});
</script>
@endpush
