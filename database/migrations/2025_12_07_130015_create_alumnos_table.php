<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->enum('sexo', ['M', 'F'])->default('M');
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->tinyInteger('semestre')->default(1);
            $table->string('tipo_sangre');
            $table->string('direccion');
            $table->string('telefono');
            $table->foreignId('tutor_id')->constrained('tutors');
            $table->string('nss')->unique();
            $table->date('fecha_inscripcion')->default(now());
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
