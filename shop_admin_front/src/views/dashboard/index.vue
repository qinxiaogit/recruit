<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="店铺名称" style="width: 300px;">
        <el-input v-model="form.name"/>
      </el-form-item>
      <el-form-item label="店铺余额" style="width: 300px;">
        <el-input v-model="form.balance" disabled/>
      </el-form-item>
      <el-form-item label="店铺logo">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :headers="fileToken"
        >
          <img v-if="form.logo" :src="form.logo" style="width: 160px;" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="营业执照">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :headers="fileToken"
          :on-success="handleBusinessSuccess"
        >
          <img v-if="form.business_license" :src="form.business_license" class="avatar" style="width: 160px;">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="联系方式" style="width: 300px;">
        <el-input v-model="form.contact"/>
      </el-form-item>
      <el-form-item label="管理员密码" style="width: 300px;">
        <el-input v-model="form.password"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">确认修改</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>

    import {getToken} from '@/utils/auth'
    import {StoreShow} from '@/api/store/list'

    export default {
        data() {
            return {
                form: {
                    name: '',
                    // region: '',
                    // balance: 0,
                    // date1: '',
                    // date2: '',
                    // delivery: false,
                    // type: [],
                    // resource: '',
                    // desc: '',
                    logo: "",
                    business_license: "",
                    contact: "",
                    password:""
                },
                fileToken: {},
                postUrl: ""
            }
        },
        created() {
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/public/upload"
            this.init()
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
            handleAvatarSuccess(res, file) {
                this.form.logo = res.data.domain + res.data.path;
            },
            handleBusinessSuccess(res, file) {
                this.form.business_license = res.data.domain + res.data.path;
            },
            init() {
                let self = this
                StoreShow().then(response => {
                    self.form.name = response.data.name;
                    self.form.balance = response.data.balance;
                    self.form.logo = response.data.logo;
                    self.form.business_license = response.data.business_license;
                    self.form.contact = response.data.contact;
                });
            },
        }
    }
</script>

<style scoped>
  .line {
    text-align: center;
  }
</style>

