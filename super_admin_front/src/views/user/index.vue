<template>
  <div class="app-container">

    <div class="demo-input-suffix">
      <template>
        <el-input
          placeholder="请输入用户昵称"
          prefix-icon="el-icon-search"
          v-model="search_name" style="width: 160px; margin-right: 10px; margin-left: 16px;">
        </el-input>
        <el-button @click="fetchData" type="primary">搜索</el-button>
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
      <el-table-column label="年龄" width="120" align="center">
        <template slot-scope="scope">
          {{ scope.row.age }}
        </template>
      </el-table-column>
      <!--el-table-column label="用户头像" width="160" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 100px; height: 100px"
            :src="scope.row.avatar"
            fit="cover"></el-image>
        </template>
      </el-table-column-->
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
            <!--img style="width: 100px; height: 100px;" :src=scope.row.invite_user.mobile  class="image"-->
            <div style="padding: 14px;">
              <span>{{ scope.row.invite_user.mobile }}</span>
            </div>
            <div style="padding: 14px;">
              <span>{{ scope.row.invite_user.real_name }}</span>
            </div>
          </el-card>
          <span v-else> 无邀请人</span>
        </template>
      </el-table-column>


      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="shareJob(scope.row)"
                     icon="el-icon-share">分享
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
    <el-dialog
      title="生成邀请码"
      :visible.sync="dialogInviteCode"
      width="30%"
      :before-close="dialogInviteCodeClose">
      <!--span>职位名称{{dialogJobName}}</span>
      <el-input v-model="dialogUserMobile" @input="changeUserMobile" placeholder="请输入分享用户手机号" style="margin-top: 12px;"></el-input-->
      <el-image
        v-if="jobShareUrl"
        style="width: 100px; height: 100px;margin-top: 12px;"
        :src="jobShareUrl"></el-image>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogInviteCode = false">取 消</el-button>
    <el-button type="primary" :disabled="disableGen" @click="shareJobClick">生成分享码</el-button>
  </span>
    </el-dialog>
  </div>
</template>
<style>
  .demo-input-suffix {

    margin-bottom: 8px;
  }

</style>

<script>
    import {UserList} from '@/api/user'
    import {shareJob} from '@/api/jobs'


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
                disableGen:false,
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
            fetchData() {
                this.listLoading = true
                UserList({
                    nickname: this.search_name,
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
            shareJob(row){
                this.dialogInviteCode = true
                this.dialogJobName = row.name
                this.currentJobId = row.id
                this.dialogUserMobile = row.mobile
                this.jobShareUrl = ''
                console.log(row)
            },
            shareJobClick(){
                shareJob({job_id:this.currentJobId,mobile:this.dialogUserMobile,source:'home'}).then(response=>{
                    console.log(response)

                    this.jobShareUrl=  response.data.domain+response.data.path
                })
            },
            dialogInviteCodeClose(){
                this.dialogInviteCode = false
            },
            changeUserMobile(){
                this.disableGen = false
            }
        }
    }
</script>
