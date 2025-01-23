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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id('idtarea');
            $table->string('nombre',100);
            $table->text('comentario')->nullable();
            $table->foreignId('idproyecto')->constrained('proyectos','idproyecto');
            $table->foreignId('idetapa')->constrained('etapas','idetapa');
            $table->foreignId('idarea')->constrained('areas','idarea');
            $table->foreignId('idmiembro')->constrained('miembros','idmiembro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
