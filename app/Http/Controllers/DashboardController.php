<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BancoCentralApiService;
use App\Models\Project;

class DashboardController extends Controller
{
    public function __invoke(Request $request, BancoCentralApiService $bancoCentralApi)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // ✅ Obtener proyectos recientes del usuario
        $recentProjects = Project::where('created_by', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(6)
                                ->get();

        // ✅ Calcular estadísticas
        $userProjects = Project::where('created_by', $user->id);
        
        $stats = [
            'total' => $userProjects->count(),
            'completados' => $userProjects->where('estado', 'completado')->count(),
            'en_progreso' => $userProjects->where('estado', 'en_progreso')->count(),
            'pendientes' => $userProjects->where('estado', 'pendiente')->count(),
            'inversion_total' => $userProjects->sum('monto')
        ];

        // ✅ UN SOLO RETURN con todas las variables necesarias
        return view('dashboard', [
            'user' => $user,
            'recentProjects' => $recentProjects, 
            'stats' => $stats
            // Nota: ufValue no es necesario porque usas el componente <x-uf-value />
        ]);
    }
}