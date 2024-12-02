<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolPermisosTable extends Migration
{
    public function up()
    {
        Schema::create('rol_permisos', function (Blueprint $table) {
            $table->id(); // Genera un bigint unsigned por defecto
            $table->unsignedBigInteger('rol_id'); // Asegúrate de que coincida con el tipo
            $table->unsignedBigInteger('permiso_acceso_id'); // También debe coincidir

            // Claves foráneas
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade');
            $table->foreign('permiso_acceso_id')->references('id')->on('permisos_acceso')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol_permisos');
    }
}
