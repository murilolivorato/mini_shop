<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubCategoryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sub_category_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->bigInteger('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('product_sub_categories')->onDelete('cascade');

            $table->string('image', 60);
            $table->string('title', 255)->nullable();

            /* user create  information */
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

        Schema::table('product_sub_category_images', function(Blueprint $table){
            $table->dropForeign('product_sub_category_images_sub_category_id_foreign');
            $table->dropForeign('product_sub_category_images_user_id_foreign');

        });


        Schema::dropIfExists('product_sub_category_images');
    }
}
