<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedBackTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_back', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('feed_uid')->default(0)->comment('反馈用户id');
            $table->tinyInteger('feed_type')->default(0)->comment('反馈类型:1.收取费用，2.工资拖欠，3.放鸽子,4.虚假信息，5.刷单博彩，6.其他');
            $table->string('contact_method')->default('')->comment('联系方式');
            $table->text('content')->comment('举报情况说明');
            $table->text('img_json')->comment('图片证明');
            $table->tinyInteger('status')->comment('处理状态:0.待处理，1.已处理');
            $table->string('reason')->comment('处理结果');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feed_back');
    }
}
