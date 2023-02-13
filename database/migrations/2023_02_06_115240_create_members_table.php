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
        Schema::create('members', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_name');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedDouble('rate')->nullable();
            $table->timestamps();
        });

        Schema::create('members_cards', function (Blueprint $table) {
            $table->id();
            $table->string('list_card_idCard');
            $table->foreign('list_card_idCard')->references('idCard')->on('list_cards');
            $table->string('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unique(['list_card_idCard', 'member_id']);
            $table->unsignedDouble('est_hour')->nullable();
        });

        Schema::create('members_cards_time', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('spent_time');
            $table->dateTime('date');
            $table->string('note')->nullable();
            $table->foreignId('members_cards_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members_cards_time', function (Blueprint $table) {
            $table->dropForeign(['members_cards_id']);
        });
        Schema::dropIfExists('members_cards_time');
        Schema::dropIfExists('members_cards');
        Schema::dropIfExists('members');
    }
};
