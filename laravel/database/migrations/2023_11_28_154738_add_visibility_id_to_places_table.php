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
        Schema::table('places', function (Blueprint $table) {
            // Comprovar si la columna visibility_id ja existeix
            if (!Schema::hasColumn('places', 'visibility_id')) {
                // Afegir la columna visibility_id com a clau forana
                $table->foreignId('visibility_id')->constrained('visibilities');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            // Comprovar si la columna visibility_id existeix abans d'eliminar-la
            if (Schema::hasColumn('places', 'visibility_id')) {
                // Eliminar la columna en cas de revertir la migració
                $table->dropForeign(['visibility_id']);
                $table->dropColumn('visibility_id');
            }
        });
    }
};
