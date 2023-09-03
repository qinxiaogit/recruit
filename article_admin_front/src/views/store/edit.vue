<template>
  <div class="app-container">
    <el-form ref="form" :model="form">
      <el-form-item label="店铺名称">
        <el-col :span="6">
          <el-input v-model="form.label"/>
        </el-col>
      </el-form-item>
      <el-form-item label="店铺logo">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :headers="fileToken"
        >
          <img v-if="form.avatar" :src="form.avatar" style="width: 160px;" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="请输入门店地址">
        <el-col :span="6">
          <el-input v-model="form.lang" placeholder="输入门店精度"/>
        </el-col>
        <el-col class="line" :span="2">-</el-col>
        <el-col :span="6">
          <el-input v-model="form.lat" placeholder="输入门店维度"/>
        </el-col>
      </el-form-item>
      <el-form-item label="门店地址详细">
        <el-col :span="12">
          <el-input v-model="form.address"/>
        </el-col>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onDoc">经纬度参考</el-button>
        <el-button type="primary" @click="onSubmit">保存</el-button>
        <el-button @click="onCancel">取消</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    import {getToken} from '@/utils/auth'

    import {StoreSave,StoreShow} from '@/api/store/list'

    export default {
        components: {},
        data() {
            return {
                form: {
                    label: '',
                    avatar: '',
                    lat: '',
                    lang: '',
                    address: '',
                    id: 0,
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
            onDoc() {
                window.open("http://jingweidu.757dy.com");
            },
            handleAvatarSuccess(res, file) {
                this.form.avatar = res.data.domain + res.data.path;
            },
            onSubmit() {
                this.form.id = this.$route.query.id
                if (!this.form.avatar) {
                    this.$message('请选择店铺logo')
                    return
                }
                if (!this.form.label) {
                    this.$message('请选择店铺名称')
                    return
                }
                if (!this.form.address) {
                    this.$message('请选择地址')
                    return
                }
                if (!this.form.lang) {
                    this.$message('请输入店铺经度')
                    return
                }
                if (!this.form.lat) {
                    this.$message('请输入店铺精度')
                    return
                }
                StoreSave(this.form).then(response => {
                    this.$router.push({name: "storeMange", query: {}})

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
                    StoreShow({
                        id:this.$route.query.id
                    }).then(result=>{
                        console.log(result)
                        self.form.avatar = result.data.avatar
                        self.form.label = result.data.label
                        self.form.address = result.data.address
                        self.form.lang = result.data.lang
                        self.form.lat = result.data.lat

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

