<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ProjectController - Controlador para gestión de proyectos
 * 
 * Maneja las 5 operaciones CRUD principales:
 * 1. index() - Listar todos los proyectos del usuario
 * 2. store() - Crear un nuevo proyecto
 * 3. show() - Obtener un proyecto específico por ID
 * 4. update() - Actualizar un proyecto por ID
 * 5. destroy() - Eliminar un proyecto por ID
 * 
 * Cada método soporta tanto respuestas web (HTML) como API (JSON)
 */
class ProjectController extends Controller
{
    /**
     * 1. Controlador para obtener todos los proyectos
     * GET /projects (web) | GET /api/projects (API)
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Solo proyectos del usuario autenticado con información del creador
        $projects = Project::where('created_by', Auth::id())
                          ->with('creator:id,name,email')
                          ->orderBy('created_at', 'desc')
                          ->get();

        // API: Respuesta JSON (para rutas /api/ siempre JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $projects,
                'message' => 'Proyectos obtenidos exitosamente',
                'total' => $projects->count()
            ], 200);
        }

        // Web: Respuesta HTML
        return view('projects.index', compact('projects'));
    }

    /**
     * 1.1. Mostrar formulario para crear nuevo proyecto
     * GET /projects/create (web)
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * 2. Controlador para crear un proyecto
     * POST /projects (web) | POST /api/projects (API)
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validación de datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'estado' => 'required|in:pendiente,en_progreso,completado',
            'responsable' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0|max:999999999.99',
        ]);

        // Asignar el usuario autenticado como creador
        $validatedData['created_by'] = Auth::id();

        // Crear el proyecto
        $project = Project::create($validatedData);

        // API: Respuesta JSON (para rutas /api/ siempre JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $project->load('creator:id,name,email'),
                'message' => 'Proyecto creado exitosamente'
            ], 201);
        }

        // Web: Redirección con mensaje de éxito
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * 3. Controlador para obtener un proyecto por ID
     * GET /projects/{id} (web) | GET /api/projects/{id} (API)
     * 
     * @param Request $request
     * @param Project $project - Route Model Binding automático
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request, Project $project)
    {
        // Verificar autorización: solo el creador puede ver su proyecto
        $this->authorizeProjectAccess($project, $request);

        // API: Respuesta JSON (para rutas /api/ siempre JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $project->load('creator:id,name,email'),
                'message' => 'Proyecto obtenido exitosamente'
            ], 200);
        }

        // Web: Respuesta HTML
        return view('projects.show', compact('project'));
    }

    /**
     * 3.1. Mostrar formulario para editar proyecto
     * GET /projects/{id}/edit (web)
     * 
     * @param Project $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        // Verificar autorización: solo el creador puede editar su proyecto
        $this->authorizeProjectAccess($project, request());

        return view('projects.edit', compact('project'));
    }

    /**
     * 4. Controlador para actualizar un proyecto por ID
     * PUT/PATCH /projects/{id} (web) | PUT/PATCH /api/projects/{id} (API)
     * 
     * @param Request $request
     * @param Project $project - Route Model Binding automático
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        // Verificar autorización: solo el creador puede modificar su proyecto
        $this->authorizeProjectAccess($project, $request);

        // Validación de datos (con 'sometimes' para updates parciales)
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'fecha_inicio' => 'sometimes|required|date|after_or_equal:today',
            'estado' => 'sometimes|required|in:pendiente,en_progreso,completado',
            'responsable' => 'sometimes|required|string|max:255',
            'monto' => 'sometimes|required|numeric|min:0|max:999999999.99',
        ]);

        // Actualizar el proyecto
        $project->update($validatedData);

        // API: Respuesta JSON (para rutas /api/ siempre JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $project->fresh()->load('creator:id,name,email'),
                'message' => 'Proyecto actualizado exitosamente'
            ], 200);
        }

        // Web: Redirección con mensaje de éxito
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * 5. Controlador para eliminar un proyecto por ID
     * DELETE /projects/{id} (web) | DELETE /api/projects/{id} (API)
     * 
     * @param Request $request
     * @param Project $project - Route Model Binding automático
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Project $project)
    {
        // Verificar autorización: solo el creador puede eliminar su proyecto
        $this->authorizeProjectAccess($project, $request);

        // Guardar información antes de eliminar
        $projectName = $project->nombre;
        
        // Eliminar el proyecto
        $project->delete();

        // API: Respuesta JSON (para rutas /api/ siempre JSON)
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => "Proyecto '{$projectName}' eliminado exitosamente"
            ], 200);
        }

        // Web: Redirección con mensaje de éxito
        return redirect()->route('projects.index')
            ->with('success', "Proyecto '{$projectName}' eliminado exitosamente.");
    }

    /**
     * Método auxiliar para verificar autorización de acceso al proyecto
     * 
     * @param Project $project
     * @param Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function authorizeProjectAccess(Project $project, Request $request)
    {
        if ($project->created_by !== Auth::id()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para acceder a este proyecto'
                ], 403));
            }
            abort(403, 'No tienes permisos para acceder a este proyecto');
        }
    }
}