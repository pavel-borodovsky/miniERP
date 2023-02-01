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
        Schema::create('boards', function (Blueprint $table) {
            $table->string('idBoard')->primary();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('board_lists', function (Blueprint $table) {
            $table->string('idList')->primary();
            $table->string('name');
            $table->string('idBoard');
            $table->foreign('idBoard')->references('idBoard')->on('boards');
            $table->unsignedFloat('pos');
            $table->timestamps();
        });

        Schema::create('list_cards', function (Blueprint $table) {
            $table->string('idCard')->primary();
            $table->string('name');
            $table->unsignedFloat('pos');
            $table->dateTime('due');
            $table->string('idList');
            $table->foreign('idList')->references('idList')->on('board_lists');
            $table->string('urlSource');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_cards', function (Blueprint $table) {
            $table->dropForeign(['idList']);
        });
        Schema::dropIfExists('list_cards');
        Schema::table('board_lists', function (Blueprint $table) {
            $table->dropForeign(['idBoard']);
        });
        Schema::dropIfExists('board_lists');
        Schema::dropIfExists('boards');
    }
};
