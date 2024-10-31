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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vehiculo');
            $table->unsignedBigInteger('id_conductor');
            $table->string('codigo_qr')->nullable(); // URL del QR
            $table->date('fecha_emision');
            $table->date('fecha_expiracion');
            $table->enum('estado', ['Vigente', 'Expirado', 'Suspendido']);
            $table->timestamps();

            // Claves foráneas
            $table->foreign('id_vehiculo')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('id_conductor')->references('id')->on('conductores')->onDelete('cascade');

            // Índice único para evitar duplicados
            $table->unique(['id_vehiculo', 'id_conductor', 'fecha_emision', 'fecha_expiracion'], 'unique_permiso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
