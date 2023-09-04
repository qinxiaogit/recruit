<template>
  <div class="app-container">

    <div class="demo-input-suffix">
      <template>
        <div class="block">
          <el-input
            placeholder="请输入职位名称"
            prefix-icon="el-icon-search"
            v-model="search_name" style="width: 160px; margin-right: 10px; margin-left: 16px;">
          </el-input>
          <span class="demonstration" style="margin-right: 20px;">日期</span>
          <el-date-picker
            v-model="value1"
            type="daterange"
            range-separator="至"
            start-placeholder="开始日期"
            end-placeholder="结束日期">
            value-format="yyyy-MM-dd"
          </el-date-picker>
          <el-button style="margin-left: 20px;" @click="fetchData" type="primary">搜索</el-button>
        </div>
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
      <el-table-column label="职位名称" width="160">
        <template slot-scope="scope">
          {{ scope.row.job_name }}
        </template>
      </el-table-column>

      <el-table-column label="页面" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.path=="home"?"首页":"职位详情" }}</span>
        </template>
      </el-table-column>

      <!--el-table-column label="报名量" width="80" align="center">
        <template slot-scope="scope">
          {{scope.row.report_count}}
        </template>
      </el-table-column-->
      <el-table-column align="center" prop="created_at" label="申请时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="店铺信息" width="160">
        <template slot-scope="scope">
          <el-card :body-style="{ padding: '0px' }">
            <img style="width: 100px; height: 100px;" :src=scope.row.logo  class="image">
            <div style="padding: 14px;">
              <span>{{ scope.row.store_name }}</span>
            </div>
          </el-card>
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
    import {detailJob} from '@/api/jobs'

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
                value1: '',
                shareMethod:1,
                shareSource:"job",
                shareText:"",
                disableGen:true,
                jobShareUrl:"",
                dialogJobName : "",
                currentJobId : "",
                dialogUserMobile: "",
                dialogInviteCode:false,
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
            handleCurrentChange(val) {
                this.fetchData()
            },
            fetchData() {
                console.log(this.value1)
                this.listLoading = true
                detailJob({
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
        }
    }
</script>
