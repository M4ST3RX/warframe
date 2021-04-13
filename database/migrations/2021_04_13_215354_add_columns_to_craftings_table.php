<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCraftingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('craftings', function (Blueprint $table) {
            $table->integer('price')->default(0);
            $table->integer('time')->default(0);
            $table->integer('rush')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('craftings', function (Blueprint $table) {
            $table->dropColumn(['price', 'time', 'rush']);
        });
    }
}
