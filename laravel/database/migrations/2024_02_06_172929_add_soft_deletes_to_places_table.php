<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToPlacesTable extends Migration
{
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->softDeletes();

            if (Schema::hasColumn('places', 'file_id')) {
                $table->unsignedBigInteger('file_id')->nullable()->change();
            }

            if (Schema::hasColumn('places', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->change();
            }
            if (Schema::hasColumn('places', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
