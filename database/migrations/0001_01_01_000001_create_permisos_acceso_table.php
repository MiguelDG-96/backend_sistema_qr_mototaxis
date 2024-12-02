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
        Schema::create('permisos_acceso', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nombre')->unique(); // Unique name of the permission
            $table->string('descripcion')->nullable(); // Optional description of the permission
            $table->timestamps(); // Automatic timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos_acceso');
    }
};
