<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdminPassResets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_admin_pass_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->index()->unique();
            $table->foreign('user_id')->references('id')->on('user_admins')->onDelete('cascade');

            $table->string('token')->unique();

            $table->bigInteger('user_ip');

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
        Schema::table('user_admin_pass_resets', function(Blueprint $table){
            $table->dropForeign('user_admin_pass_resets_user_id_foreign');
        });

        Schema::dropIfExists('user_admin_pass_resets');
    }
}
