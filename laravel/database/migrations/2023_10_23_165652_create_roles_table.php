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
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Afegint la columna 'id' com a clau primària i autoincremental
            $table->string('name')->unique(); // Afegint la restricció d'unicitat a la columna 'name'
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable(); // Afegint la columna 'role_id' amb valors nuls
            $table->foreign('role_id')->references('id')->on('roles'); // Afegint una clau forana per enllaçar 'role_id' amb 'id' a la taula 'roles'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // Eliminant la restricció de clau forana
            $table->dropColumn('role_id'); // Eliminant la columna 'role_id'
        });

        Schema::dropIfExists('roles'); // Eliminant la taula 'roles'
    }
};
