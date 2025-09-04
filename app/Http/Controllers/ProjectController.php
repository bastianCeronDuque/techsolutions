<?php 
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // 1. Index: Vista web y API para listar proyectos
    public function index(Request $request){
        
        $projects = Project::all();

        if ($request->expectsJson()) {
            return response()->json($projects, 200);
        }

        return view('projects.index', compact('projects'));
    }

    /* 2. Store: Vista web para crear un nuevo proyecto
    public function create()
    {
        return view('projects.create');
    }
*/
    // 2. Store: Almacenar un nuevo proyecto (tanto para web como para API)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'estado' => 'required|in:pendiente,en_progreso,completado',
            'responsable' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
        ]);

        $validatedData['created_by'] = auth()->id; // Asignar el usuario autenticado
        $project = Project::create($validatedData);

        // Si es petición AJAX, devolver JSON
        if ($request->expectsJson()) {
            return response()->json($project->load('createdBy'), 201);
        }

        // Si es formulario web, redirigir
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto creado exitosamente.');
    }    

    // 3. Show:Vista web para mostrar un proyecto específico por ID
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    // 4. Update: Actualizar un proyecto (tanto para web como para API)
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:pendiente,en_progreso,completado',
            'responsible' => 'sometimes|required|string|max:255',
            'monto' => 'sometimes|required|numeric|min:0',
        ]);

        $project->update($validatedData);

        // Si es petición AJAX, devolver JSON
        if ($request->expectsJson()) {
            return response()->json($project, 200);
        }

        // Si es formulario web, redirigir
        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    // 5. Destroy: Eliminar un proyecto (para WEB)
    public function destroy($id) 
    {
        $project = Project::findOrFail($id);
        $project->delete();

        // Si es formulario web, redirigir
        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
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