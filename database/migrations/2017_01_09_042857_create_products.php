<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->enum('status', ['active', 'no_active'])->default('active');

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('product_categories');

            $table->bigInteger('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('product_sub_categories');

            /* description */
            $table->string('title', 255)->unique();
            $table->string('url_title', 255)->unique();

            $table->string('folder', 60)->unique();

            $table->text('description');

            /* google key word */
            $table->text('meta_tag_title');
            $table->text('meta_tag_description');
            $table->text('meta_key_words');


            /* quantity */
            $table->integer('number_qty_unity');
            $table->integer('min_quantity')->nullable();
            $table->integer('max_quantity')->nullable();

            /* ship information */
            $table->boolean('ship_by_company')->default(false);
            $table->float('ship_price', 8, 2)->nullable();


            /* dimension and size of box */
            $table->integer('dimension_length')->nullable();
            $table->integer('dimension_width')->nullable();
            $table->integer('dimension_height')->nullable();

            $table->integer('weight');
            $table->integer('weight_unity');


            /* Stock information */
            $table->string('sku', 20)->nullable();
            $table->string('code', 20);
            $table->string('upc')->nullable();


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
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign('products_category_id_foreign');
            $table->dropForeign('products_sub_category_id_foreign');
            $table->dropForeign('products_manufacture_id_foreign');
            $table->dropForeign('products_user_id_foreign');
        });

        Schema::dropIfExists('products');
    }
}
