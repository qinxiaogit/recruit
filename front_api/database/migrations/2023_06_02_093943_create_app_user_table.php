<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
            $table->string('avatar')->default('')->comment('头像');
            $table->string('nickname')->default('')->comment('nickname');
            $table->string('real_name')->default('')->comment('真实姓名');
            $table->string('sex')->default(0)->comment('性别：1.男，2.女');
            $table->string('mobile')->default('')->comment('手机号');
            $table->char('invite_code',16)->default('')->comment('邀请码');
            $table->integer('invite_uid')->default(0)->comment('邀请人');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_user');
    }
}
