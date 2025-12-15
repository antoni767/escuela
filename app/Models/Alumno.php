<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre_completo',
        'sexo',
        'carrera_id',
        'semestre',
        'tipo_sangre',
        'direccion',
        'telefono',
        'tutor_id',
        'nss',
        'fecha_inscripcion',
    ];

    /* =======================================
     * RELACIONES
     * ======================================= */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    /* =======================================
     * CÁLCULO AUTOMÁTICO DEL SEMESTRE
     * ======================================= */
    public static function boot()
    {
        parent::boot();

        // Antes de crear
        static::creating(function ($alumno) {
            if (!$alumno->semestre) {
                $alumno->semestre = self::calcularSemestre($alumno->fecha_inscripcion);
            }
        });

        // Antes de actualizar
        static::updating(function ($alumno) {
            if (!$alumno->semestre) {
                $alumno->semestre = self::calcularSemestre($alumno->fecha_inscripcion);
            }
        });
    }

    public static function calcularSemestre($fecha)
    {
        $fecha = Carbon::parse($fecha);
        $meses = $fecha->diffInMonths(now());
        return floor($meses / 6) + 1;
    }
}

