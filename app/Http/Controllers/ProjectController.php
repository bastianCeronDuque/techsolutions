<?php 
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // 1. Index: Vista web y API para listar proyectos
    public function index(Request $request)
    {
        // Solo proyectos del usuario autenticado
        $projects = Project::where('created_by', Auth::id())
                          ->with('creator:id,name,email') // Eager loading optimizado
                          ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $projects,
                'message' => 'Proyectos obtenidos exitosamente'
            ], 200);
        }

        return view('projects.index', compact('projects'));
    }


    // 2. Store: Almacenar un nuevo proyecto en Vista Web y API
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'estado' => 'required|in:pendiente,en_progreso,completado',
            'responsable' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0|max:999999999.99',
        ]);

        $validatedData['created_by'] = Auth::id();
        $project = Project::create($validatedData);

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $project->load('creator:id,name,email'),
                'message' => 'Proyecto creado exitosamente'
            ], 201);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto creado exitosamente.');
    }
    
    // 3. Destroy: Eliminar un proyecto por ID
    public function destroy(Request $request, Project $project)
    {
        // ✅ Autorización
        if ($project->created_by !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'No tienes permisos para eliminar este proyecto'
                ], 403);
            }
            abort(403);
        }

        $project->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Proyecto eliminado exitosamente'
            ], 204);
        }

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }
}


    // 4. Update: Actualizar un proyecto por ID (tanto para web como para API)
    public function update(Request $request, Project $project)
    {
        // ✅ Autorización
        if ($project->created_by !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'No tienes permisos para modificar este proyecto'
                ], 403);
            }
            abort(403);
        }

        // ✅ Corregir nombres de campos (usas 'name' pero en DB es 'nombre')
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'fecha_inicio' => 'sometimes|required|date', 
            'estado' => 'sometimes|required|in:pendiente,en_progreso,completado',
            'responsable' => 'sometimes|required|string|max:255',
            'monto' => 'sometimes|required|numeric|min:0|max:999999999.99',
        ]);

        $project->update($validatedData);

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $project->load('creator:id,name,email'),
                'message' => 'Proyecto actualizado exitosamente'
            ], 200);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    // 5. Show:Vista web para mostrar un proyecto específico por ID
    public function show(Request $request, Project $project)
    {
        // ✅ Autorización: Solo el creador puede ver su proyecto
        if ($project->created_by !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'No tienes permisos para ver este proyecto'
                ], 403);
            }
            abort(403);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'data' => $project->load('creator:id,name,email'),
                'message' => 'Proyecto obtenido exitosamente'
            ], 200);
        }

        return view('projects.show', compact('project'));
    }

    // Métodos API RESTful (retorn JSON)

    // Controlador para crear un proyecto vía API
    public function apiStore(Request $request)
    {
        return $this->store($request); // Reutiliza el método store
    }

    // Controlador para obtener un proyecto específico vía API
    public function apiShow($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project, 200);
    }

    // Controlador para actualizar un proyecto vía API
    public function apiUpdate(Request $request, $id)
    {
        return $this->update($request, $id); // Reutiliza el método update
    }

    // Controlador para eliminar un proyecto vía API
    public function apiDestroy($id)
    {
        return $this->destroy($id); // Reutiliza el método destroy
    }

}