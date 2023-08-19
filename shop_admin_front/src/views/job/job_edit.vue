<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="220px">
      <el-form-item label="职位名称" style="width: 420px;">
        <el-input v-model="form.name"/>
      </el-form-item>
      <el-form-item label="职位分类">
        <el-cascader
          v-model="value"
          :options="options"
          @change="handleCascaderChange"></el-cascader>
      </el-form-item>
      <el-form-item label="工作方式">
        <el-radio-group v-model="form.method">
          <el-radio :label="1">线上</el-radio>
          <el-radio :label="2">线下</el-radio>
          <el-radio :label="0">不限</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="性别">
        <el-radio-group v-model="form.sex">
          <el-radio :label="1">男</el-radio>
          <el-radio :label="2">女</el-radio>
          <el-radio :label="0">不限</el-radio>
        </el-radio-group>
      </el-form-item>

      <el-form-item label="结算方式">
        <el-radio-group v-model="form.settlement">
          <el-radio :label="1">日结</el-radio>
          <el-radio :label="2">周结</el-radio>
          <el-radio :label="3">月结</el-radio>
          <el-radio :label="4">完工结</el-radio>
          <el-radio :label="5">其他</el-radio>
        </el-radio-group>
      </el-form-item>

      <el-form-item label="招募人数" style="width: 220px;">
        <el-input-number v-model="form.employ_count" :min="1" :max="10000" label="招募人数"></el-input-number>
      </el-form-item>

      <el-form-item label="工作时间">
        <div class="block">
          <el-date-picker
            v-model="form.work_start_time"
            type="daterange"
            range-separator="至"
            start-placeholder="开始日期"
            format="yyyy 年 MM 月 dd 日"
            end-placeholder="结束日期">
          </el-date-picker>
        </div>
      </el-form-item>

      <el-form-item label="工作内容">
        <el-input v-model="form.work_content" :autosize="{ minRows: 5, maxRows: 5}"
                  type="textarea"/>
      </el-form-item>

      <el-form-item label="工作要求">
        <el-input v-model="form.work_require" :autosize="{ minRows: 5, maxRows: 5}" type="textarea"/>
      </el-form-item>

      <el-form-item label="薪资说明">
        <el-input v-model="form.salary_desc" :autosize="{ minRows: 5, maxRows: 5}" type="textarea"/>
      </el-form-item>
      <el-form-item label="薪资">
        <el-input-number v-model="form.salary" :min="1" :max="10000" label="招募人数"
                         style="width: 160px;margin-right: 10px;"></el-input-number>
        <el-select v-model="form.unit" placeholder="单位">
          <el-option label="小时" value="小时"/>
          <el-option label="天" value="天"/>
        </el-select>
      </el-form-item>
      <el-form-item label="年龄限制">
        <el-input-number v-model="form.age_start" :min="0" :max="100" label="年龄限制"
                         style="width: 160px;margin-right: 10px;"></el-input-number>
        <span>至</span>
        <el-input-number v-model="form.age_end" :min="0" :max="100" label="招募人数"
                         style="width: 160px;margin-left: 10px;"></el-input-number>
      </el-form-item>

      <el-form-item label="联系方式-二维码">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :headers="fileToken"
        >
          <img v-if="form.contact_qrcode" :src="form.contact_qrcode" style="width: 160px;" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>

      <el-form-item label="联系方式-手机号" style="width: 420px;">
        <el-input v-model="form.contact_mobile"/>
      </el-form-item>
      <el-form-item label="联系方式-QQ" style="width: 420px;">
        <el-input v-model="form.contact_qq"/>
      </el-form-item>
      <el-form-item label="联系方式-微信" style="width: 420px;">
        <el-input v-model="form.contact_wx"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">确定</el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>

    import {getToken} from '@/utils/auth'
    import {SelectJobCat, JobCateTree} from '@/api/jobCat' ;
    import {showJob, createOrEditJob,EditJob} from '@/api/jobs' ;

    export default {
        data() {
            return {
                form: {
                    name: '',
                    type: "type",
                    method: 0,
                    sex: 0,
                    settlement: "0",
                    employ_count: 0,
                    work_start_time:"",
                    work_end_time:"",
                    work_require: "",
                    work_content: "",
                    salary_desc: "",
                    salary: "",
                    unit: "",
                    age_start: 0,
                    age_end: 0,
                    contact_qrcode:"",
                    contact_mobile:"",
                    contact_qq:"",
                    contact_wx:"",
                },
                options: [],
                value: [],
                fileToken: {},
                postUrl: ""
            }
        },
        created() {
            this.initOption()
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/public/upload"
        },
        methods: {
            handleAvatarSuccess(res, file) {
                this.form.contact_qrcode = res.data.domain + res.data.path;
            },
            handleCascaderChange() {

            },
            handleDate (date){
                let year = date.getFullYear();
                let month = date.getMonth()+1
                if(month<10){
                    month = "0"+month
                }
                let day = date.getDate()+1
                if(day<10){
                    day = "0"+day
                }
                return year+""+month+""+day
            },
            onSubmit() {
                // this.$message('submit!')
                let form = this.form
                let self = this

                form['one_cate_id'] = this.value[0];
                form['two_cate_id'] = this.value[1];

                let workDate = form.work_start_time
                form.work_start_time = this.handleDate(workDate[0])
                form.work_end_time = this.handleDate(workDate[1])
                if (this.$route.query.id) {
                    EditJob(this.$route.query.id,form).then(response=>{
                        self.$message({
                            message: '操作成功!',
                            type: 'warning'
                        })
                        self.$router.push({name: "jobManage"})
                    });
                }else {
                    createOrEditJob(form).then(response => {
                        self.$message({
                            message: '操作成功!',
                            type: 'warning'
                        })
                        self.$router.push({name: "jobManage"})
                    });
                }
            },
            onCancel() {
                this.$message({
                    message: '正在返回上一页!',
                    type: 'warning'
                })
                this.$router.push({name: "jobManage"})
            },
            initJob() {
                console.log(this.$route.query)
                if (!this.$route.query.id) {
                    return;
                }
                let self = this
                showJob(this.$route.query.id).then(response => {
                    self.form.name = response.data.name
                    self.form.method = parseInt(response.data.method)
                    self.form.sex = parseInt(response.data.sex)
                    self.form.settlement = response.data.settlement
                    // console.log(self.form.settlement)
                    self.form.employ_count = response.data.employ_count
                    let  startTime = response.data.work_start_time+""
                    let  endTime = response.data.work_end_time+""
                    self.form.work_start_time = [new Date(
                        startTime.substr(0,4),
                        startTime.substr(4,2),
                        startTime.substr(6,2)
                    ),new Date(
                        endTime.substr(0,4),
                        endTime.substr(4,2),
                        endTime.substr(6,2)
                    )]
                    // self.form.work_end_time = response.data.work_end_time
                    self.form.work_require = response.data.work_require
                    self.form.work_content = response.data.work_content
                    self.form.salary_desc = response.data.salary_desc
                    self.form.salary = response.data.salary
                    self.form.unit = response.data.unit
                    self.form.age_start = response.data.age_start
                    self.form.age_end = response.data.age_end

                    self.form.contact_qrcode = response.data.contact_qrcode
                    self.form.contact_qq = response.data.contact_qq
                    self.form.contact_wx = response.data.contact_wx
                    self.form.contact_mobile = response.data.contact_mobile



                    self.value = [response.data.one_cate_id, response.data.two_cate_id];
                    console.log(self.value)
                });
            },
            initOption() {
                let self = this
                JobCateTree({
                    parent_id: 0,
                }).then(response => {
                    let data = response.data;
                    self.options = data
                    self.initJob();
                });
            }
        }
    }
</script>

<style scoped>
  .line {
    text-align: center;
  }
</style>

