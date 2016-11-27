<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuDbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hobord_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('machine_name')->unique();
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->string('lang')->nullable();

            $table->timestamps();
        });

        Schema::create('hobord_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('unique_name')->nullable();
            $table->integer('weight')->nullable();
            $table->string('menu_text')->nullable();
            $table->json('parameters');

//            $table->boolean('divide')->default(false);
            $table->json('meta_data')->nullable();

            $table->timestamps();
        });

        Schema::table('hobord_menu_items', function ($table) {
            $table->index('parent_id', 'parent_id');
            $table->index(['unique_name','menu_id'], 'unique_name');
            $table->foreign('menu_id')
                ->references('id')->on('hobord_menus')
                ->onDelete('cascade');
            $table->foreign('parent_id')
                ->references('id')->on('hobord_menu_items')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobord_menu_items');
        Schema::dropIfExists('hobord_menus');
    }
}
