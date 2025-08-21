<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BancoCentralApiService;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Verifica explícitamente la autenticación
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $bancoCentralApi = new BancoCentralApiService();
        $ufValue = $bancoCentralApi->getUfValue();

        return view('dashboard', [
            'user' => Auth::user(),
            'ufValue' => $ufValue
        ]);
    }
}