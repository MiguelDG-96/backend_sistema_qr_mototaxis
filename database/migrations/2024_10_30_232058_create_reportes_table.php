<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->enum('tipo_reporte', ['Permisos por vencer', 'Permisos vencidos', 'Asociaciones inscritas']);
            $table->timestamps(); // Agrega created_at y updated_at automáticamente
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null'); // Relación con usuarios
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
