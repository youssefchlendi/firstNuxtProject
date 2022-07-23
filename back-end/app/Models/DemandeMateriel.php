<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeMateriel extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'date_demande',
        'date_fin_demande',
        'user_id',
        'responsable_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materiels()
    {
        return $this->belongsToMany(Materiel::class, 'demande_materiel_materiel')->withPivot('id','quantity','status')->with("responsable");
    }


}
