<template>
  <div class="app-container">

    <div class="demo-input-suffix">
      <template>
        <el-input
          placeholder="请输入用户手机号"
          prefix-icon="el-icon-search"
          v-model="keyword" style="width: 160px; margin-right: 10px; margin-left: 16px;">
        </el-input>
        <el-button @click="fetchData" type="primary">搜索</el-button>
        <el-button @click="newUser" type="primary">新增用户</el-button>
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
          {{ scope.row.nickname}}
        </template>
      </el-table-column>
      <el-table-column label="用户真实名称" width="160" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.real_name }}</span>
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
      <el-table-column align="center" prop="created_at" label="添加时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="最后活跃时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.active_time }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="updateUser(scope.row)" icon="el-icon-edit">编辑
          </el-button>
          <el-button style="margin-left: 10px;" type="primary" @click="deleteUser(scope.row)"
                     icon="el-icon-delete">删除
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
    import {UserList,UserDelete} from '@/api/user'

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
                value: '-1',
                keyword: "",
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
                UserList({
                    keyword: this.keyword,
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
            newUser() {
                this.$router.push({name: "updateUser"})
            },
            deleteUser(row) {
                const self = this
                UserDelete({id: row.id}).then(response => {
                    self.fetchData()
                })
            },
            updateUser(row) {
                this.$router.push({name: "updateUser", query: {id: row.id}})
            },
        }
    }
</script>
