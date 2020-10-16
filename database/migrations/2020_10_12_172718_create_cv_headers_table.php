<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('title_id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->foreign('title_id')->on('cv_titles')->references('id')->cascadeOnDelete();

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
        Schema::dropIfExists('cv_headers');
    }
}
