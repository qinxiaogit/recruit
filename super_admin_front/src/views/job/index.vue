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
      <el-table-column label="职位名称" width="160">
        <template slot-scope="scope">
          {{ scope.row.name }}

          <el-tooltip class="item" effect="dark" v-if="scope.row.audit_log" :content='scope.row.audit_log.extra.work_content' placement="top-start">
          <span style="color: red;display: block;">{{scope.row.audit_log ? scope.row.audit_log.extra.name:""}}</span>
          </el-tooltip>
        </template>
      </el-table-column>
      <el-table-column label="是否置顶" width="100" align="center">
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
      </el-table-column>
      <el-table-column label="排名" width="150" align="center">
        <template slot-scope="scope">
          <el-input-number style="width: 120px" v-model="scope.row.sort" controls-position="right"
                           @change="handleSortChange(scope.row)" :min="1" :max="100"></el-input-number>
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


      <el-table-column align="center" label="商户状态" width="90">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 0 "> 待审核 </span>
          <span v-else-if="scope.row.status == 1 "> 上架 </span>
          <span v-else>下架</span>
          <span style="color: red;">{{scope.row.audit_log ? "(修改系统审核)":""}}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-button type="primary" @click="updateStore(scope.row)" style="display: none;" icon="el-icon-edit">编辑
          </el-button>
            <el-button type="primary" style="margin-right: 5px;" @click="clickShowAudit(scope.row)" slot="reference" v-if="parseInt(scope.row.status) ===0 || scope.row.audit_log " icon="el-icon-position">
              审核
            </el-button>
          <el-button type="primary" @click="downStore(scope.row)" v-if="parseInt(scope.row.status) ===1 "
                     icon="el-icon-bottom">下架
          </el-button>
          <el-button type="primary" @click="upStore(scope.row)" v-if="parseInt(scope.row.status) ===2"
                     icon="el-icon-top">上架
          </el-button>

          <el-button type="primary" @click="shareJob(scope.row)" v-if="parseInt(scope.row.status) ===1"
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
      placement="top"
      width="400"
      :visible.sync="visible"
      title="职位审核结果？"
    >
      <span style="display: block">职位名称：{{jobName}} <span style="color: red;">{{audit_log_name}}</span></span>
      <span style="display: block">职位介绍：{{job_work_content}} <span style="color: red">{{audit_log_work_content}}</span></span>
      <span style="display: block">职位要求：{{work_require}}</span>
      <span style="display: block">薪资说明：{{salary}}/{{unit}}</span>

      <el-input placeholder="请输入内容" style="margin-bottom: 10px;" v-model="auditReason">
        <template slot="prepend">审核操作原因</template>
      </el-input>
      <div style="text-align: right; margin: 0">
        <el-button size="mini" type="text" @click="auditStore( 1)">审核通过</el-button>
        <el-button type="primary" size="mini" @click="auditStore( 2)">审核驳回</el-button>
      </div>
    </el-dialog>
    <el-dialog
      title="生成邀请码"
      :visible.sync="dialogInviteCode"
      width="30%"
      :before-close="dialogInviteCodeClose">
      <span>职位名称{{dialogJobName}}</span>
      <el-input v-model="dialogUserMobile" @input="changeUserMobile" placeholder="请输入分享用户手机号" style="margin-top: 12px;"></el-input>
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
                jobName:"",
                job_work_content:'',
                audit_log_name:"",
                audit_log_work_content:"",
                work_require:"",
                salary:"",
                unit:"",
                workRow:{}
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
            auditStore(status) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                UpdateJob(this.workRow.id,{status:status}).then(response => {
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
            clickShowAudit(row){
                this.visible= true
                this.jobName = row.name
                this.job_work_content = row.work_content
                this.audit_log_name = row.audit_log?row.audit_log.extra.name:""
                this.audit_log_work_content = row.audit_log?row.audit_log.extra.work_content:""

                this.salary = row.salary
                this.unit = row.unit
                this.work_require= row.work_require

                this.workRow = row
            },
            shareJob(row){
                this.dialogInviteCode = true
                this.dialogJobName = row.name
                this.currentJobId = row.id
                console.log(row)
            },
            shareJobClick(){
                shareJob({job_id:this.currentJobId,mobile:this.dialogUserMobile,source:'job'}).then(response=>{
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
