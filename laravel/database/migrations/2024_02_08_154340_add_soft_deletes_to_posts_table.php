<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();

            if (Schema::hasColumn('posts', 'file_id')) {
                $table->unsignedBigInteger('file_id')->nullable()->change();
            }

            if (Schema::hasColumn('posts', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->change();
            }
            if (Schema::hasColumn('posts', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}