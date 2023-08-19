<template>
  <div class="app-container">
    <div class="demo-input-suffix">
      <template>
        处理状态:
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
        性别:
        <el-select v-model="sex" placeholder="请选择">
          <el-option
            v-for="item in sexs"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>

      <template>
        职位:
        <el-select v-model="job" placeholder="请选择">
          <el-option
            v-for="item in jobs"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>
      <template>
        报名时间
        <el-date-picker
          v-model="report_time"
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          value-format="timestamp"
          :picker-options="pickerOptions">
        </el-date-picker>
      </template>
      <el-button style="margin-left: 10px;" @click="fetchData" type="primary">搜索</el-button>
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
      <el-table-column label="联系方式" width="180" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.report_user? scope.row.report_user.mobile :"" }}</span>
        </template>
      </el-table-column>
      <!--el-table-column align="center" prop="created_at" label="报名用户信息" width="160">
        <template slot-scope="scope">
          <el-card :body-style="{ padding: '0px' }">
            <img v-if="scope.row.report_user" style="width: 100px; height: 100px;" :src=scope.row.report_user.avatar class="image">
          </el-card>
        </template>
      </el-table-column-->
      <el-table-column align="center" label="用户名" width="95">
        <template slot-scope="scope">
          {{ scope.row.report_user ? scope.row.report_user.real_name:"" }}
        </template>
      </el-table-column>
      <el-table-column align="center" label="性别" width="95">
        <template slot-scope="scope">
          {{ scope.row.report_user ? (scope.row.report_user.sex == 1? "男":"女") :"" }}
        </template>
      </el-table-column>
      <el-table-column align="center" label="年龄" width="95">
        <template slot-scope="scope">
          {{ scope.row.report_user ? scope.row.report_user.age :"" }}
        </template>
      </el-table-column>

      <el-table-column align="center" label="职位" width="220">
        <template slot-scope="scope">
          {{ scope.row.report_job ? (scope.row.report_job.name) :"" }}
        </template>
      </el-table-column>

      <el-table-column align="center" label="报名时间" width="160">
        <template slot-scope="scope">
          {{ scope.row.created_at }}
        </template>
      </el-table-column>

      <el-table-column align="center" label="处理状态" width="160">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 0 "> 待录用 </span>
          <span v-else-if="scope.row.status == 1 "> 已录用(<span style="color: #4caf50;">通过</span>) </span>
          <span v-else>不录用(<span style="color: red;">驳回</span>)</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-popover
            placement="top"
            width="400"
            v-model="visible">
            <p>投诉处理结果？</p>
            <el-input placeholder="请输入内容" style="margin-bottom: 10px;" v-model="auditReason">
              <template slot="prepend">操作原因</template>
            </el-input>
            <div style="text-align: right; margin: 0">
              <el-button size="mini" type="text" @click="auditStore(scope.row, 1)">录用</el-button>
              <el-button type="primary" size="mini" @click="auditStore(scope.row, 2)">不录用</el-button>
            </div>
            <el-button type="primary" slot="reference" @click="employHandle(scope.row)"
                       v-if="parseInt(scope.row.status) ===0" icon="el-icon-position">
              待录用
            </el-button>
          </el-popover>
          <el-button type="primary" @click="downStore(scope.row)" disabled v-if="parseInt(scope.row.status) ===1"
                     icon="el-icon-bottom">已录用
          </el-button>
          <el-button type="primary" @click="upStore(scope.row)" disabled v-if="parseInt(scope.row.status) ===2"
                     icon="el-icon-top">已驳回
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
    import {reportJob, reportStatusJob,JobList} from '@/api/jobs'
    import {IcSlider, IcSliderItem} from 'vue-better-slider'

    export default {
        components: {
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
                visible: false,
                auditReason: "",
                total: 0,
                options: [{
                    value: '-1',
                    label: '全部'
                }, {
                    value: '0',
                    label: '待处理'
                }, {
                    value: '1',
                    label: '已处理'
                }],
                sexs: [
                    {
                        value: '-1',
                        label: '全部'
                    }, {
                        value: '0',
                        label: '未知'
                    }, {
                        value: '1',
                        label: '男'
                    },
                    {
                        value: '2',
                        label: '女'
                    }
                ],
                jobs: [{
                    value: "-1",
                    label: '全部',
                }],
                job: "-1",
                value: '-1',
                sex: "-1",
                value2: '0',
                search_name: "",
                currentPage: 1,
                currentPageSize: 10,
                report_time: '',
                pickerOptions: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
            }
        },
        created() {
            this.fetchData()
            this.initJobs();
        },
        methods: {
            employHandle(row) {
                this.visible = true;
                this.$prompt('请输入操作原因', '录用结果', {
                    confirmButtonText: '录用',
                    cancelButtonText: '不录用',
                    callback: function (action, instance) {
                        console.log(action)
                        console.log(instance)

                        reportStatusJob({
                            report_id: row.id,
                            status: action === "cancel" ? 2 : 1,
                            reason: instance.inputValue
                        }).then(response => {
                            console.log(response)
                        });
                    }
                })
                //     .then(({value}) => {
                //     reportStatusJob({
                //         id: row.id,
                //         status: 1,
                //         reason: value
                //     }).then(response => {
                //
                //     });
                //     this.$message({
                //         type: 'success',
                //         message: '你的邮箱是: ' + value
                //     });
                // }).catch(() => {
                //     this.$message({
                //         type: 'info',
                //         message: '取消输入'
                //     });
                // });

            },
            fetchData() {
                this.listLoading = true
                var jobId = this.job
                if(this.jobs.length === 1 &&  parseInt(this.$route.query.id)>0){
                    jobId =  parseInt(this.$route.query.id)
                }
                console.log(this.report_time)
                var report_start_time = ""
                var report_end_time = ""
                if(this.report_time){
                    report_start_time= this.report_time[0]/1000;
                    report_end_time= this.report_time[1]/1000;
                }
                reportJob({
                    status: this.value,
                    skip: (this.currentPage - 1) * this.currentPageSize,
                    limit: this.currentPageSize,
                    sex: this.sex,
                    job_id: jobId,
                    report_start_time:report_start_time,
                    report_end_time:report_end_time,
                }).then(response => {
                    this.list = response.data.items
                    this.total = response.data.total
                    this.listLoading = false
                })
            },
            switchChange(row) {
                UpdateJob(row.id, {is_top: row.is_top ? 1 : 0}).then(response => {
                    console.log(response)
                })
            },
            handleSortChange(row, va) {
                UpdateJob(row.id, {sort: row.sort}).then(response => {
                    console.log(response)
                })
            },
            upStore(row) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                UpdateJob(row.id, {status: 1}).then(response => {
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
                UpdateJob(row.id, {status: 2}).then(response => {
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

                AuditFeed({id: row.id, status: status, reason: this.auditReason}).then(response => {
                    this.visible = false
                    loading.close()
                    this.fetchData()
                })
            },
            updateStore(row) {
                this.$router.push({name: "updateStore", query: {id: row.id}})
            },
            handleCurrentChange(val) {
                this.fetchData()
            },
            initJobs(){
                JobList().then(response => {
                    for (let i=0;i<response.data.items.length;i++){
                        this.jobs.push({label:response.data.items[i].name,value:response.data.items[i].id})
                    }
                    this.job = parseInt(this.$route.query.id)

                })
            }
        }
    }
</script>
