<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default("")->comment("商户名称");
            $table->integer('balance')->default(0)->comment('商户余额');
            $table->integer('today_report_count')->default(0)->comment('今日报名数');
            $table->integer('online_count')->default(0)->comment('当前在线职位数');
            $table->integer('status')->default(0)->comment('店铺状态:0.待审核，1.审核通过');
            $table->string('logo')->default('')->comment('logo');
            $table->string('business_license')->default('')->comment('营业执照');
            $table->string('contact')->default('')->comment('联系方式');
            $table->timestamps();
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
        Schema::drop('stores');
    }
}
