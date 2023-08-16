<template>
  <div class="app-container">
    <el-form ref="form" :model="form">
      <el-form-item label="请填写首页banner配置">
        <el-button type="primary" @click="clickNewBanner"> 新增banner</el-button>
      </el-form-item>
      <div class="conf-block">
        <el-form-item v-for="(item,index) in form.banner_list">
          <el-col :span="2">banner图</el-col>
          <el-col :span="4">
            <img v-if="item.img" :src="item.img" style="width: 120px;" class="avatar">
          </el-col>
          <el-col :span="2">请选择跳转方式</el-col>
          <el-col :span="4">
            <el-radio-group v-model="item.jump_type">
              <el-radio label="url">跳转网页</el-radio>
              <el-radio label="page">页面跳转</el-radio>
            </el-radio-group>
          </el-col>
          <el-col :span="2">跳转地址</el-col>
          <el-col :span="4">
            <el-input v-model="item.url" placeholder="请输入跳转地址"/>
          </el-col>
          <el-button type="danger" class="btn-left" icon="el-icon-delete" @click="deleteLine('banner_list',index)"
                     circle></el-button>
        </el-form-item>
      </div>
      <el-form-item label="请填写首页入口配置">
        <el-button type="primary" @click="clickNewBlock"> 新增入口</el-button>
      </el-form-item>
      <div class="conf-block">
        <el-form-item v-for="(item,index) in form.block_list">
          <el-col :span="2">banner图</el-col>
          <el-col :span="4">
            <img v-if="item.img" :src="item.img" style="width: 100px;" class="avatar">
          </el-col>
          <el-col :span="2">请选择跳转方式</el-col>
          <el-col :span="4">
            <el-radio-group v-model="item.jump_type">
              <el-radio label="url">跳转网页</el-radio>
              <el-radio label="page">页面跳转</el-radio>
            </el-radio-group>
          </el-col>
          <el-col :span="2">跳转地址</el-col>
          <el-col :span="4">
            <el-input v-model="item.url" placeholder="请输入跳转地址"/>
          </el-col>
          <el-button type="danger" class="btn-left" icon="el-icon-delete" @click="deleteLine('block_list',index)"
                     circle></el-button>
        </el-form-item>
      </div>

      <el-form-item label="请填写课程banner配置">
        <el-button type="primary" @click="clickNewCourse"> 新增入口</el-button>
      </el-form-item>
      <div class="conf-block">
        <el-form-item v-for="(item,index) in form.course_list">
          <el-col :span="2">banner图</el-col>
          <el-col :span="4">
            <img v-if="item.img" :src="item.img" style="width: 100px;" class="avatar">
          </el-col>
          <el-col :span="2">请选择跳转方式</el-col>
          <el-col :span="4">
            <el-radio-group v-model="item.jump_type">
              <el-radio label="url">跳转网页</el-radio>
              <el-radio label="page">页面跳转</el-radio>
            </el-radio-group>
          </el-col>
          <el-col :span="2">跳转地址</el-col>
          <el-col :span="4">
            <el-input v-model="item.url" placeholder="请输入跳转地址"/>
          </el-col>
          <el-button type="danger" class="btn-left" icon="el-icon-delete" @click="deleteLine('course_list',index)"
                     circle></el-button>
        </el-form-item>
      </div>

      <el-form-item label="成长专区">
        <el-button type="primary" @click="clickNewDevelop"> 新增专区</el-button>
      </el-form-item>
      <div class="conf-block">
        <el-form-item v-for="(item,index) in form.develop_list">
          <el-col :span="1">标题</el-col>
          <el-col :span="2">
            <el-input v-model="item.label" disabled/>
          </el-col>
          <el-col :span="2" :offset="1">描述</el-col>
          <el-col :span="2">
            <el-input v-model="item.desc" disabled/>
          </el-col>
          <el-col :span="4" :offset="1">
            <el-radio-group v-model="item.jump_type" disabled>
              <el-radio label="url">跳转网页</el-radio>
              <el-radio label="page">页面跳转</el-radio>
            </el-radio-group>
          </el-col>
          <el-col :span="2">跳转地址</el-col>
          <el-col :span="4">
            <el-input v-model="item.url" disabled placeholder="请输入跳转地址"/>
          </el-col>
          <el-button type="danger" class="btn-left" icon="el-icon-delete" @click="deleteLine('develop_list',index)"
                     circle></el-button>
        </el-form-item>
      </div>
    </el-form>
  </div>
</template>

<script>
    import {getToken} from '@/utils/auth'
    import {BannerShow,BannerDelete} from '@/api/conf'

    export default {
        data() {
            return {
                form: {
                    banner_list: [],
                    block_list: [],
                    course_list: [],
                    develop_list: [],
                },
                fileToken: {},
                postUrl: "",
            }
        },
        created() {
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/backend/upload"

            this.initConf()
        },
        methods: {
            onSubmit() {
                this.$message('submit!')
            },
            onCancel() {
                this.$message({
                    message: 'cancel!',
                    type: 'warning'
                })
            },
            clickNewBanner() {
                this.$router.push({name: "updateBanner", query: {}})
            },
            clickNewCourse() {
                this.$router.push({name: "courseBanner", query: {}})
            },
            clickNewBlock() {
                this.$router.push({name: "blockBanner", query: {}})
            },
            clickNewDevelop() {
                this.$router.push({name: "developBanner", query: {}})
            },
            initConf() {
                const self = this
                BannerShow({}).then(response => {
                    self.form = response.data
                })
            },
            deleteLine(key, index) {
                console.log(key, index)
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                BannerDelete({key:key,index:index}).then(response=>{
                    console.log(response)
                    loading.close()
                }).catch(reason => {
                    console.log(reason)
                })
            },
        }
    }
</script>

<style scoped>
  .line {
    text-align: center;
  }

  .conf-block {
    min-height: 100px;
    margin-left: 20px;
  }

  .btn-left {
    margin-left: 10px;
  }
</style>

