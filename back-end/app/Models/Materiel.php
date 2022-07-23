<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'quantity', 'responsable_id'];

    public function responsable()
    {
        return $this->belongsTo('App\Models\User', 'responsable_id');
    }

    public function categorieMateriel()
    {
        return $this->belongsToMany('App\Models\CategorieMateriel', 'categorie_materiel_materiel');
    }


}
