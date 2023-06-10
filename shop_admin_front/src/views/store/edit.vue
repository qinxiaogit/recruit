<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="店铺名称">
        <el-input v-model="form.name" />
      </el-form-item>

      <el-form-item label="店铺余额">
        <el-input v-model="form.balance" />
      </el-form-item>

      <el-form-item label="今日报名数">
        <el-input v-model="form.today_report_count" disabled />
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''
                }
            }
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
            }
        }
    }
</script>

<style scoped>
  .line{
    text-align: center;
  }
</style>

