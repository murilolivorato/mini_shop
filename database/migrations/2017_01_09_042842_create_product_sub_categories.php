<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSubCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sub_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('product_categories');

            /* google key word */
            $table->text('meta_tag_description');
            $table->text('meta_key_words');


            $table->string('title', 255)->unique();
            $table->string('url_title', 255)->unique();


            $table->bigInteger('user_ip');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user_admins');

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
        Schema::table('product_sub_categories', function(Blueprint $table){
            $table->dropForeign('product_sub_category_id_foreign');
            $table->dropForeign('product_sub_user_id_foreign');
        });

        Schema::dropIfExists('product_sub_categories');
    }
}
