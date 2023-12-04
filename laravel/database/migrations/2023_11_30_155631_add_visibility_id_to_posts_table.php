<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Comprobar si la columna visibility_id ya existe
            if (!Schema::hasColumn('posts', 'visibility_id')) {
                // Agregar la columna visibility_id como clave foránea
                $table->foreignId('visibility_id')->default(1)->constrained('visibilities');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Comprobar si la columna visibility_id existe antes de eliminarla
            if (Schema::hasColumn('posts', 'visibility_id')) {
                // Eliminar la columna en caso de revertir la migración
                $table->dropForeign(['visibility_id']);
                $table->dropColumn('visibility_id');
            }
        });
    }
};