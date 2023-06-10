<template>
  <div class="app-container">

    <div class="demo-input-suffix">
      <template>
        <el-button @click="fetchDataToDay" type="primary">今日活跃{{toDayActive>0?"（"+toDayActive+"）":""}}</el-button>
        <el-button @click="fetchDataToDayRegister" type="primary">今日新增用户{{toDayRegister>0?"（"+toDayRegister+"）":""}}</el-button>
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
      <el-table-column label="用户昵称" width="100">
        <template slot-scope="scope">
          {{ scope.row.nickname }}
        </template>
      </el-table-column>
      <el-table-column label="用户真实名称" width="160" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.real_name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="生日" width="120" align="center">
        <template slot-scope="scope">
          {{ scope.row.birthday }}
        </template>
      </el-table-column>
      <el-table-column label="用户头像" width="160" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 100px; height: 100px"
            :src="scope.row.avatar"
            fit="cover"></el-image>
        </template>
      </el-table-column>

      <el-table-column label="联系方式" width="120" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.mobile }}</span>
        </template>
      </el-table-column>
      <el-table-column label="邀请码" width="120">
        <template slot-scope="scope">
          {{ scope.row.invite_code }}
        </template>
      </el-table-column>

      <el-table-column class-name="status-col" label="性别" width="120" align="center">
        <template slot-scope="scope">
          {{ scope.row.sex === 1? "男":"女" }}
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="注册时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="邀请人" width="200">
        <template slot-scope="scope">
          <el-card v-if="scope.row.invite_user" :body-style="{ padding: '0px' }">
            <img style="width: 100px; height: 100px;" :src=scope.row.invite_user.avatar  class="image">
            <div style="padding: 14px;">
              <span>{{ scope.row.invite_user.nickname }}</span>
            </div>
          </el-card>
          <span v-else> 无邀请人</span>
        </template>
      </el-table-column>


      <!--el-table-column align="center" style="display: none;" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="updateStore(scope.row)" style="display: none;" icon="el-icon-edit">编辑
          </el-button>
          <el-popover
            placement="top"
            width="350"
            v-model="visible">
            <p>企业入驻审核结果？</p>
            <el-input placeholder="请输入内容" style="margin-bottom: 10px;" v-model="auditReason">
              <template slot="prepend">审核操作原因</template>
            </el-input>
            <div style="text-align: right; margin: 0">
              <el-button size="mini" type="text" @click="auditStore(scope.row, 0)">审核通过</el-button>
              <el-button type="primary" size="mini" @click="auditStore(scope.row, 1)">审核驳回</el-button>
            </div>
            <el-button type="primary" slot="reference" v-if="parseInt(scope.row.status) ===0" icon="el-icon-position">
              审核
            </el-button>
          </el-popover>
          <el-button type="primary" @click="downStore(scope.row)" v-if="parseInt(scope.row.status) ===1"
                     icon="el-icon-bottom">下架
          </el-button>
          <el-button type="primary" @click="upStore(scope.row)" v-if="parseInt(scope.row.status) ===2"
                     icon="el-icon-top">上架
          </el-button>
        </template>
      </el-table-column -->
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
    import {UserList} from '@/api/user'

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
                toDayRegister:0,
                toDayActive:0,

            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.listLoading = true
                UserList({
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
            handleCurrentChange(val) {
                this.fetchData()
            },
            fetchDataToDayRegister(){
                this.listLoading = true
                UserList({
                    name: this.search_name,
                    source_type: "today_register",
                    skip: (this.currentPage - 1) * this.currentPageSize,
                    limit: this.currentPageSize,
                }).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                    this.toDayRegister = this.total
                })
            },
            fetchDataToDay(){
                this.listLoading = true
                UserList({
                    name: this.search_name,
                    source_type: "today_create",
                    skip: (this.currentPage - 1) * this.currentPageSize,
                    limit: this.currentPageSize,
                }).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.toDayActive = this.total
                    this.listLoading = false
                })
            }
        }
    }
</script>
