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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->unsignedDouble('rate');
            $table->timestamps();
        });

        Schema::create('members_cards', function (Blueprint $table) {
            $table->id();
            $table->string('list_card_id');
            $table->foreign('list_card_id')->references('idCard')->on('list_cards');
            $table->foreignId('member_id')->constrained();
            $table->unsignedDouble('est_hour');
        });

        Schema::create('members_cards_time', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('spent_time');
            $table->dateTime('date');
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
        /*Schema::table('members_cards', function (Blueprint $table) {
            $table->dropForeign(['list_card_id']);
            $table->dropForeign(['member_id']);
        });*/
        Schema::dropIfExists('members_cards');
        Schema::dropIfExists('members');
    }
};
