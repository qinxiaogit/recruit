<template>
  <div class="app-container">
<el-row>
  <el-col :span="6" v-for="(o, index) in reportData" :key="o.id" :offset="index > 0 ? 2 : 0">
    <el-card :body-style="{ padding: '0px' }">
      <img :src="o.logo?o.logo:'https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png'" class="image">
      <div style="padding: 14px;">
        <span>{{o.view=="home"?"系统首页":"职位列表（"+o.store_name+")("+o.job_name+"）"}}</span>
        <div class="bottom clearfix">
          <time class="time">浏览量({{o.view_count}})</time>
          <time class="time">点击量({{o.report_count}})</time>
        </div>
      </div>
    </el-card>
  </el-col>
</el-row>
  </div>
</template>
<style>
.time {
    font-size: 13px;
    color: #999;
  }

  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }

  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }

  .clearfix:after {
      clear: both
  }
</style>

<script>
    import {DashboashAgent} from '@/api/user'

export default {
  data() {
    return {
      currentDate: new Date(),
      reportData: [
      ]
    };
  },
  created() {
        this.fetchData()
          },
  methods: {
          fetchData:function(){
          var self = this
              DashboashAgent({
                    'uid':this.$route.query.id,

                }).then(response=>{
                    console.log(response.data)
                   self.reportData = response.data

                   console.log(self.reportData)

                })
          }
  }
}
</script>
