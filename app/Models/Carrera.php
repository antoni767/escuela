<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ← CORRECTO
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory; // ← así sí funciona

    protected $fillable = ['nombre'];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
