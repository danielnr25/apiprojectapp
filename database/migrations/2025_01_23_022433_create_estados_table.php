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
        Schema::create('estados', function (Blueprint $table) {
            $table->id('idestado');
            $table->string('nombre', 100);
            $table->text('comentario')->nullable();
            $table->integer('maximo_tareas')->nullable();
            $table->foreignId('idproyecto')->constrained('proyectos','idproyecto');
            $table->string('estado',20)->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
