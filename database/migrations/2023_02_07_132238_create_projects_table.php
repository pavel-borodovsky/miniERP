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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->dateTime('date');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('invoice_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained();
            $table->string('desc');
            $table->unsignedDouble('fix_price')->nullable();
            $table->string('tag')->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('income_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_task_id')->constrained();
            $table->string('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->unsignedDouble('rate');
            $table->unsignedDouble('hours');
            $table->timestamps();
        });

        Schema::table('list_cards', function (Blueprint $table) {
            $table->string('invoice_task_tag')->nullable()->after('urlSource');
            $table->foreign('invoice_task_tag')->references('tag')->on('invoice_tasks');
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
            $table->dropForeign(['invoice_task_tag']);
            $table->dropColumn('invoice_task_tag');
        });
        Schema::dropIfExists('income_rates');
        Schema::dropIfExists('invoice_tasks');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('projects');
    }
};
