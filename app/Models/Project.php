<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Project extends Model
{
    protected $fillable = [
        'nombre', 'fecha_inicio', 'estado', 'responsable', 'monto', 'created_by'
    ];

    // Cifrado a nivel de Eloquent (AES-256-CBC usando APP_KEY)
    protected $casts = [
        'responsable' => 'encrypted',  // <- se almacena cifrado en BD
        'fecha_inicio' => 'date',
        'monto' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
