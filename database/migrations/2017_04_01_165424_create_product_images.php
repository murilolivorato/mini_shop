<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->bigInteger('gallery_id')->unsigned();
            $table->foreign('gallery_id')->references('id')->on('product_gallery_images')->onDelete('cascade');

            $table->string('image', 60);
            $table->string('title', 255)->nullable();

            $table->smallInteger('order');

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
        Schema::table('product_images', function(Blueprint $table){
            $table->dropForeign('product_images_gallery_id_foreign');
            $table->dropForeign('product_images_user_id_foreign');

        });

        Schema::dropIfExists('product_images');
    }
}
