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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 10)->unique();
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->integer('anio');
            $table->unsignedBigInteger('id_conductor');
            $table->tinyInteger('estado')->default(1); // 1 Activo, 0 Inactivo
            $table->timestamps();
        
            // Clave foránea con la tabla conductores
            $table->foreign('id_conductor')->references('id')->on('conductores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
