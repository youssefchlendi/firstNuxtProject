<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieMateriel extends Model
{
    use HasFactory;
    protected $fillable = ['name',  'created_by'];
    public function materiels()
    {
        return $this->belongsToMany(Materiel::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
