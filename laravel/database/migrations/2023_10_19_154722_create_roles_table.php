<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crear la taula roles amb columna id (clau primària i autoincremental) i columna name (valor amb restricció d’unicitat)
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Afegir la columna role_id a la taula users (amb opció de valors null)
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
        });

        // Afegir la clau forana per relacionar role_id de la taula users amb id de la taula roles
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Artisan::call('db:seed', [
            '--class' => 'RoleSeeder',
            '--force' => true
        ]);         
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la clau forana de la taula users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        // Eliminar la columna role_id de la taula users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });

        // Eliminar la taula roles
        Schema::dropIfExists('roles');
    }
};
