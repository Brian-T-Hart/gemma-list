<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharedGlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_glists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('glist_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('confirm_code');
            $table->unsignedInteger('confirmed')->nullable();
            $table->boolean('archived')->default(0);
            $table->timestamps();

            $table->foreign('glist_id')->references('id')->on('glists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_glists');
    }
}
