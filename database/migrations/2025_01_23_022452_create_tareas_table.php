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
            $table->string('nombre',100); // nombre varchar(100) NOT NULL,
            $table->text('comentario')->nullable(); // comentario text NULL,
            $table->foreignId('idproyecto')->constrained('proyectos','idproyecto'); // idproyecto int(10) unsigned NOT NULL,
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
