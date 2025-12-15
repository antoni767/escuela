<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← CORRECTO

class Tutor extends Model
{
   use HasFactory;

    protected $fillable = ['nombre', 'telefono'];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
