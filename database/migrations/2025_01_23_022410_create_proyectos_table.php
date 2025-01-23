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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id('idproyecto');
            $table->string('nombre', 100);
            $table->foreignId('idtipo_proyecto')->constrained('tipo_proyectos', 'idtipo_proyecto');
            $table->datetime('fecha_inicio')->nullable();
            $table->datetime('fecha_fin')->nullable();
            $table->text('detalle')->nullable();
            $table->string('estado', 20)->default('ACTIVO');
            $table->unsignedBigInteger('idusuario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
