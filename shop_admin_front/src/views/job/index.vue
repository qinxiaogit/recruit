<template>
  <div class="app-container">

    <div class="demo-input-suffix">

      <template>
        职位状态:
        <el-select v-model="value" placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>

      <template>
        <el-input
          placeholder="请输入职位名称"
          prefix-icon="el-icon-search"
          v-model="search_name" style="width: 160px; margin-right: 10px; margin-left: 16px;">
        </el-input>
        <el-button @click="fetchData" type="primary">搜索</el-button>
        <el-button @click="createJob" type="primary">新增职位</el-button>
      </template>
    </div>

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
      <el-table-column label="职位名称" width="100">
        <template slot-scope="scope">
          {{ scope.row.name }}
        </template>
      </el-table-column>
      <!--el-table-column label="是否置顶" width="100" align="center">
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.is_top"
            active-color="#13ce66"
            inactive-color="#ff4949"
            active-text="是"
            inactive-text="否"
            @change="switchChange(scope.row)"
          >
          </el-switch>
        </template>
      </el-table-column-->
      <!--el-table-column label="排名" width="150" align="center">
        <template slot-scope="scope">
          <el-input-number style="width: 120px" v-model="scope.row.sort" controls-position="right"
                           @change="handleSortChange(scope.row)" :min="1" :max="100"></el-input-number>
        </template>
      </el-table-column-->

      <el-table-column label="浏览量" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.view_count }}</span>
        </template>
      </el-table-column>

      <el-table-column label="报名量" width="80" align="center">
        <template slot-scope="scope">
          {{scope.row.report_count}}
        </template>
      </el-table-column>
      <el-table-column label="招募人数" width="80" align="center">
        <template slot-scope="scope">
          {{scope.row.employ_count}}
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="申请时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <!--el-table-column align="center" prop="created_at" label="店铺信息" width="160">
        <template slot-scope="scope">
          <el-card :body-style="{ padding: '0px' }">
            <img style="width: 100px; height: 100px;" :src=scope.row.store.logo  class="image">
            <div style="padding: 14px;">
              <span>{{ scope.row.store.name }}</span>
            </div>
          </el-card>
        </template>
      </el-table-column-->
      <el-table-column align="center" label="商户状态" width="90">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 0 "> 待审核 </span>
          <span v-else-if="scope.row.status == 1 "> 上架 </span>
          <span v-else>下架</span>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="updateStore(scope.row)" icon="el-icon-edit">编辑
          </el-button>
          <el-button type="primary" @click="downStore(scope.row)" v-if="parseInt(scope.row.status) ===1"
                     icon="el-icon-bottom">下架
          </el-button>
          <el-button type="primary" @click="upStore(scope.row)" v-if="parseInt(scope.row.status) ===2"
                     icon="el-icon-top">上架
          </el-button>
          <el-button type="primary" @click="showReport(scope.row)"
                     icon="el-icon-top">查看报名信息
          </el-button>
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
    import {JobList,UpdateJob} from '@/api/jobs'

    export default {
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
                visible: false,
                auditReason: "",
                total: 0,
                options: [{
                    value: '-1',
                    label: '全部'
                }, {
                    value: '0',
                    label: '待审核'
                }, {
                    value: '1',
                    label: '上架'
                }, {
                    value: '2',
                    label: '下架'
                }],
                value: '-1',
                search_name: "",
                currentPage: 1,
                currentPageSize: 10,

            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.listLoading = true
                JobList({
                    name: this.search_name,
                    status: this.value,
                    skip: (this.currentPage - 1) * this.currentPageSize,
                    limit: this.currentPageSize,
                }).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            createJob(){
                this.$router.push({name: "editJob"})
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
            downStore(row) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                UpdateJob(row.id,{status:2} ).then(response => {
                    this.visible = false
                    loading.close()
                    this.fetchData()
                })
            },
            auditStore(row, status) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                UpdateJob(row.id,{status:status}).then(response => {
                    this.visible = false
                    loading.close()
                    this.fetchData()
                })
                // StoreAudit({id: row.id, status: status, reason: this.auditReason}).then(response => {
                //     this.visible = false
                //     loading.close()
                //     this.fetchData()
                // })
            },
            updateStore(row) {
                this.$router.push({name: "editJob", query: {id: row.id}})
            },
            handleCurrentChange(val) {
                this.fetchData()
            },
            showReport(row){
                this.$router.push({name: "reportList", query: {id: row.id}})
            }
        }
    }
</script>
