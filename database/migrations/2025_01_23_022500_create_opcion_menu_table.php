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
        Schema::create('opcion_menu', function (Blueprint $table) {
            $table->id('idopcion_menu');
            $table->string('nombre',50);
            $table->string('link',255)->nullable();
            $table->unsignedBigInteger('idopcion_menu_ref')->nullable();
            $table->string('estado',20)->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcion_menu');
    }
};
