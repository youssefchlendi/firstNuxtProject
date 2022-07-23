<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DemandeMaterielMateriel extends Pivot
{
    use HasFactory;
    protected $table = 'demande_materiel_materiel';
    protected $fillable = [
        'demande_materiel_id',
        'materiel_id',
        'quantity',
        'status',
    ];
}
