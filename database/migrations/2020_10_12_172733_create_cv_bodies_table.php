<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_bodies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('header_id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->foreign('header_id')->on('cv_headers')->references('id')->cascadeOnDelete();
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
        Schema::dropIfExists('cv_bodies');
    }
}
