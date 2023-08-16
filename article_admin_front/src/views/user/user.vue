<template>
  <div class="app-container">
    <el-form ref="form" :model="form">
      <el-form-item label="用户真实名称">
        <el-col :span="6">
          <el-input v-model="form.real_name"/>
        </el-col>
      </el-form-item>
      <el-form-item label="用户手机号">
        <el-col :span="6">
          <el-input v-model="form.mobile" placeholder="输入用户手机号"/>
        </el-col>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    import {getToken} from '@/utils/auth'

    import {SaveUser,UserShow} from '@/api/user'

    export default {
        components: {},
        data() {
            return {
                form: {
                    real_name: '',
                    mobile: ''
                },
                fileToken: {},
                postUrl: "",
            }
        },
        created() {
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/backend/upload"

            this.initShow()
        },
        methods: {
            onSubmit() {
                this.form.id = this.$route.query.id
                if (!this.form.real_name) {
                    this.$message('请输入用户真实名字')
                    return
                }
                if (!this.form.mobile) {
                    this.$message('请输入用户手机号')
                    return
                }
                SaveUser(this.form).then(response => {
                    this.$router.push({name: "userManage", query: {}})

                })
            },
            onCancel() {
                this.$message({
                    message: 'cancel!',
                    type: 'warning'
                })
                this.$router.push({name: "store", query: {}})
            },
            initShow(){
                const self = this
                if(this.$route.query.id){
                    UserShow({
                        id:this.$route.query.id
                    }).then(result=>{
                        console.log(result)
                        self.form.real_name = result.data.real_name
                        self.form.mobile = result.data.mobile
                    })
                }

            }
        }
    }
</script>

<style scoped>
  .line {
    text-align: center;
  }
</style>

