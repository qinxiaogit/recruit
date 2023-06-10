<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="分类名称">
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item label="选择父级分类">
        <el-select v-model="form.parent_id" placeholder="选择父级分类">
          <el-option  v-for="item in options" :key="item.id"  :label="item.name"  :value="item.id" >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="分类排序">
        <el-input-number :min="1" :max="100"  v-model="form.sort" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">提交</el-button>
        <el-button @click="onCancel">返回</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  import {JobCateALL,CreateJobCate} from '@/api/jobCat'
    export default {
        data() {
            return {
                form: {
                    name: '',
                    parent_id: '',
                    sort: 1
                },
                listLoading:false,
                options:[],
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.listLoading = true
                JobCateALL({}).then(response => {
                    console.log(response)
                    this.options = response.data
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            onSubmit() {
                CreateJobCate(this.form).then(response=>{

                    console.log(response)

                    this.$router.push({name: "catList"})

                })

                console.log(this.form)
                this.$message('submit!')
            },
            onCancel() {
                this.$message({
                    message: 'cancel!',
                    type: 'warning'
                })

                this.$router.push({name: "catList"})

            }
        }
    }
</script>

<style scoped>
  .line{
    text-align: center;
  }
</style>

