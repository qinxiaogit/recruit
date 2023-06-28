<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("name")->default('')->comment('职位名称');
            $table->integer('sort')->default(99999)->comment('职位排序');
            $table->tinyInteger("one_cate_id")->default(0)->comment('一级分类id');
            $table->tinyInteger("two_cate_id")->default(0)->comment('二级分类id');
            $table->tinyInteger('method')->default(1)->comment('1.线上，2.线下');
            $table->tinyInteger('sex')->default(1)->comment('1.男，2.女');
            $table->tinyInteger('settlement')->default(0)->comment("结算方式:1.日结，2.周结，3.月结，4.完工结，5.其他");
            $table->tinyInteger('is_top')->default(0)->comment("是否置顶:0.不置顶，1.置顶");
            $table->integer('employ_count')->default(0)->comment("招募人数");
            $table->integer('work_start_time')->default(0)->comment("工作开始时间");
            $table->integer('work_end_time')->default(0)->comment("工作结束时间");
            $table->text('work_content')->comment("工作内容");
            $table->text('work_require')->comment("工作要求");
            $table->decimal('salary')->comment("薪资");
            $table->string('unit')->comment("薪资单位");
            $table->text('salary_desc')->comment("薪资说明");
            $table->bigInteger('report_count')->default(0)->comment('报名统计');
            $table->bigInteger('view_count')->default(0)->comment('浏览量');
            $table->integer('store_id')->default(0)->comment('商家id');
            $table->tinyInteger('status')->default(0)->comment('职位状态：0:待审核，1.上架，2.下架');

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
        Schema::drop('jobs');
    }
}
