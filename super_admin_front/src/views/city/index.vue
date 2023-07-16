<template>
  <div class="app-container">
    <div class="demo-input-suffix">
      <template>
        处理状态:
        <el-input v-model="keyword" placeholder="请输入城市名称" style="width: 160px;margin-right: 20px;"></el-input>
      </template>
      <el-button @click="fetchData" type="primary">搜索</el-button>
      <el-button @click="dialogVisible=true" type="primary">新增城市</el-button>
    </div>
    <el-dialog
      title="新增城市"
      :visible.sync="dialogVisible"
      width="50%"
      :before-close="handleClose">
      <el-form ref="form" :model="city" label-width="100px">
        <el-form-item label="城市名称">
          <el-input v-model="city.name"></el-input>
        </el-form-item>
        <el-form-item label="城市首字母">
          <el-input v-model="city.index" placeholder="A-Z"></el-input>
        </el-form-item>
        <el-form-item label="城市唯一码">
          <el-input v-model="city.key"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="clickSaveCity">确 定</el-button>
  </span>
    </el-dialog>

    <el-table
      v-loading="listLoading"
      :data="list"
      element-loading-text="Loading"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="ID" width="95">
        <template slot-scope="scope">
          {{ scope.row.id }}
        </template>
      </el-table-column>
      <el-table-column label="城市名称" width="180" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="首字母" width="120" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>
      <el-table-column label="唯一码" width="120" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.key }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="操作">
          <template  slot-scope="scope">
            <el-button type="primary" @click="deleteCity(scope.row)" icon="el-icon-delete">删除</el-button>
          </template>
      </el-table-column>
    </el-table>
    <el-pagination style="float: right;margin-top:20px;"
                   background
                   layout="prev, pager, next"
                   :total="total"
                   :page-size="currentPageSize"
                   @current-change="handleCurrentChange"
                   :current-page.sync="currentPage"
    >
    </el-pagination>
  </div>
</template>
<style>
  .demo-input-suffix {

    margin-bottom: 8px;
  }

</style>

<script>
    import {cityList,storeCity,deleteCity} from '@/api/city'
    import {IcSlider,IcSliderItem} from 'vue-better-slider'
    export default {
        components:{
            IcSlider,
            IcSliderItem
        },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    published: 'success',
                    draft: 'gray',
                    deleted: 'danger'
                }
                return statusMap[status]
            }
        },
        data() {
            return {
                list: null,
                listLoading: true,
                dialogVisible: false,
                keyword: "",
                total: 0,
                currentPage: 1,
                currentPageSize: 10,
                currentSelectId:  0,
                city:{
                    name:'',
                    key:'',
                    index:'',
                }
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.listLoading = true
                cityList({
                    keyword: this.keyword,
                    skip: (this.currentPage - 1) * this.currentPageSize,
                    limit: this.currentPageSize,
                }).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            deleteCity(id) {
                var self = this
                deleteCity({id:id}).then(response=>{
                    self.fetchData()
                })
            },
            handleClose(e) {
                this.city.name = ''
                this.city.key = ''
                this.city.index = ''
                this.dialogVisible = false
            },
            clickSaveCity() {
                var self = this
                if(this.city.name === ''||this.city.key===''||this.city.index === ''){
                    this.$message('信息不全');
                    return
                }
                storeCity(this.city).then(response=>{
                    self.dialogVisible=false
                    self.fetchData()
                    self.city.name = ''
                    self.city.key = ''
                    self.city.index = ''
                })
            },
            switchChange(row){
                UpdateJob(row.id,{is_top:row.is_top?1:0}).then(response => {
                    console.log(response)
                })
            },
            handleSortChange(row,va){
                UpdateJob(row.id,{sort:row.sort}).then(response => {
                    console.log(response)
                })            },
            upStore(row) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                UpdateJob(row.id,{status:1}).then(response => {
                    this.visible = false
                    loading.close()
                    this.fetchData()
                })
            },

            handleCurrentChange(val) {
                this.fetchData()
            }
        }
    }
</script>
