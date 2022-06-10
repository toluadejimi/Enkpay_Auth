<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToPosTable extends Migration
{
    public function up()
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->string('location')
                ->nullable()
                ->after('status');
        });
    }

    public function down()
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
}
