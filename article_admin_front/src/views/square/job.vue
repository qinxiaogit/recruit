<template>
  <div class="app-container">

    <div class="demo-input-suffix">
      <template>
        <el-input
          placeholder="请输入职位名称"
          prefix-icon="el-icon-search"
          v-model="search_name" style="width: 160px; margin-right: 10px; margin-left: 16px;">
        </el-input>
        <el-button @click="fetchData" type="primary">搜索</el-button>
        <el-button @click="shareJob({},'home')" type="primary">分享首页</el-button>
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
          {{ scope.row.name }}
        </template>
      </el-table-column>

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
      <el-table-column align="center" prop="created_at" label="申请时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="店铺信息" width="160">
        <template slot-scope="scope">
          <el-card :body-style="{ padding: '0px' }">
            <img style="width: 100px; height: 100px;" :src=scope.row.store.logo  class="image">
            <div style="padding: 14px;">
              <span>{{ scope.row.store.name }}</span>
            </div>
          </el-card>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="shareJob(scope.row,'job')"
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
      <span>职位名称{{dialogJobName}}</span>
      <div style="margin-top: 30px;">
        <el-radio v-model="shareMethod" label="1" border>分享二维码</el-radio>
        <el-radio v-model="shareMethod" label="2" border>分享链接</el-radio>
      </div>
      <el-image
        v-if="jobShareUrl"
        style="width: 100px; height: 100px;margin-top: 12px;"
        :src="jobShareUrl"></el-image>
      <span v-if="shareText" style="margin-top: 20px;font-size: 26px;display: block">{{shareText}}<!--el-button type="primary"  round>复制</el-button-->
</span>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogInviteCode = false">取 消</el-button>
    <el-button type="primary" @click="shareJobClick">生成分享码</el-button>
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
    import {JobList,UpdateJob,shareJob} from '@/api/jobs'

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
                this.$router.push({name: "updateStore", query: {id: row.id}})
            },
            handleCurrentChange(val) {
                this.fetchData()
            },
            shareJob(row,page){
                this.dialogInviteCode = true
                this.shareSource = page
                if (row) {
                    this.dialogJobName = row.name
                    this.currentJobId = row.id
                }else
                {
                    this.dialogJobName = "分享首页"
                    this.currentJobId=100
                }
            },
            shareJobClick(){
                shareJob({job_id:this.currentJobId,mobile:this.dialogUserMobile,source:this.shareSource,shareMethod:this.shareMethod}).then(response=>{
                    console.log(response)
                    if(this.shareMethod == 1){
                        this.jobShareUrl=  response.data.domain+response.data.path
                        this.shareText= ''

                    }else{
                        this.jobShareUrl=''
                        this.shareText= response.data.path
                    }
                })
            },
            dialogInviteCodeClose(){
                this.dialogInviteCode = false
            }
        }
    }
</script>
