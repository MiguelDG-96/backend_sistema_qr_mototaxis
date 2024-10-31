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
        
        Schema::create('conductores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('dni', 8)->unique();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->unsignedBigInteger('id_asociacion');
            $table->tinyInteger('estado')->default(1); // 1 Activo, 0 Inactivo
            $table->timestamps();
        
            // Clave foránea con la tabla asociaciones
            $table->foreign('id_asociacion')->references('id')->on('asociaciones')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores');
    }
};
