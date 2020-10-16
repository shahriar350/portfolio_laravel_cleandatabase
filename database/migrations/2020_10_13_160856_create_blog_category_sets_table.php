<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategorySetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_category_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category');
            $table->foreign('category')->on('blog_categories')->references('id')->cascadeOnDelete();
            $table->unsignedBigInteger('blog');
            $table->foreign('blog')->on('blogs')->references('id')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::dropIfExists('blog_category_sets');
    }
}
