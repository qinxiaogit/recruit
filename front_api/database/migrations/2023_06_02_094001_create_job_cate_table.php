<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCateTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_cate', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name')->default('')->comment('分类名称');
            $table->integer('sort')->default(0)->comment('分类排序');
            $table->integer('level')->default(0)->comment('分类等级');

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
        Schema::drop('job_cate');
    }
}
