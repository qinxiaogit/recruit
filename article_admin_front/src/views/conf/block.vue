<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="banner图">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :headers="fileToken"
        >
          <img v-if="form.img" :src="form.img" style="width: 160px;" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="跳转方式">
        <el-radio-group v-model="form.jump_type">
          <el-radio label="url">网页</el-radio>
          <el-radio label="page">页面</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="跳转地址">
        <el-col :span="5">
          <el-input v-model="form.url"/>
        </el-col>
      </el-form-item>
      <el-form-item label="展示方式">
        <el-radio-group v-model="form.display">
          <el-radio label="one">一行一个</el-radio>
          <el-radio label="two">一行两个</el-radio>
          <el-radio label="three">一行三个</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button @click="onCancel">返回</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    import {getToken} from '@/utils/auth'

    import {BannerSave} from '@/api/conf'

    export default {
        data() {
            return {
                form: {
                    img: '',
                    jump_type: '',
                    url: '',
                    display: ''
                },
                fileToken: {},
                postUrl: "",
            }
        },
        created() {
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/backend/upload"
        },
        methods: {
            onSubmit() {
                const self = this
                BannerSave({value: self.form, key: 'block_list'}).then(response => {
                    self.$router.push({name: "confManage", query: {}})
                    console.log(response)
                });
                this.$message('提交成功!')
            },
            onCancel() {
                this.$message({
                    message: '取消!',
                    type: 'warning'
                })
                this.$router.push({name: "confManage", query: {}})
            },
            handleAvatarSuccess(res, file) {
                this.form.img = res.data.domain + res.data.path;
            },
        }
    }
</script>

<style scoped>
  .line {
    text-align: center;
  }
</style>

