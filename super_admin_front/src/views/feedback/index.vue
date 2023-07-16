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
        反馈类型:
        <el-select v-model="value2" placeholder="请选择">
          <el-option
            v-for="item in options2"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
      </template>
      <el-button @click="fetchData" type="primary">搜索</el-button>
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
      <el-table-column label="反馈类型" width="120">
        <template slot-scope="scope">
          <span v-if=" parseInt(scope.row.feed_type) ===1"> 收取费用</span>
          <span v-else-if="parseInt(scope.row.feed_type) ===2">  工资拖欠</span>
          <span v-else-if=" parseInt(scope.row.feed_type) ===3"> 放鸽子</span>
          <span v-else-if=" parseInt(scope.row.feed_type) ===4"> 虚假信息</span>
          <span v-else-if=" parseInt(scope.row.feed_type) ===5"> 刷单博彩</span>
          <span v-else-if=" parseInt(scope.row.feed_type) ===6"> 其他</span>
        </template>
      </el-table-column>
      <el-table-column label="联系方式" width="180" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.contact_method }}</span>
        </template>
      </el-table-column>

      <el-table-column label="反馈内容" width="300" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.content }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="截图证据" width="200">
        <template slot-scope="scope">

          <ic-slider :autoplay="1000" style="width: 120px;text-align: center">
            <ic-slider-item v-for="(items,index) in scope.row.img_json_arr">
              <img :src="items"/>
            </ic-slider-item>
          </ic-slider>
        </template>
      </el-table-column>


      <el-table-column align="center" label="处理状态" width="160">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 0 "> 待处理 </span>
          <span v-else-if="scope.row.status == 1 "> 已处理(<span style="color: #4caf50;">通过</span>) </span>
          <span v-else>已处理(<span style="color: red;">驳回</span>)</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="操作">
        <template slot-scope="scope">
          <el-dialog
            placement="top"
            width="400"
            :visible.sync="visible"
            title="投诉处理结果?"
          >
            <el-input placeholder="请输入内容" style="margin-bottom: 10px;" v-model="auditReason">
              <template slot="prepend">审核操作原因</template>
            </el-input>
            <div style="text-align: right; margin: 0">
              <el-button size="mini" type="text" @click="auditStore(scope.row, 1)">通过</el-button>
              <el-button type="primary" size="mini" @click="auditStore(scope.row, 2)">驳回</el-button>
            </div>
          </el-dialog>
          <el-button type="primary" slot="reference" @click="clickAudit(scope.row)" v-if="parseInt(scope.row.status) ===0" icon="el-icon-position">
            待处理
          </el-button>
          <el-button type="primary" @click="downStore(scope.row)" disabled v-if="parseInt(scope.row.status) ===1"
                     icon="el-icon-bottom">已通过
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
    import {FeedList,AuditFeed} from '@/api/feedback'
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
                options2:[
                    {
                        value:"0",
                        label: '全部'
                    },
                    {
                        value:"1",
                        label: '收取费用'
                    },
                    {
                        value:"2",
                        label: '工资拖欠'
                    },
                    {
                        value:"3",
                        label: '放鸽子'
                    },
                    {
                        value:"4",
                        label: '信息虚假'
                    },
                    {
                        value:"5",
                        label: '刷单博彩'
                    },
                    {
                        value:"6",
                        label: '其他'
                    },
                ],
                value: '-1',
                value2: '0',
                search_name: "",
                currentPage: 1,
                currentPageSize: 10,
                currentSelectId:  0
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            fetchData() {
                this.listLoading = true
                FeedList({
                    status: this.value,
                    feed_type:this.value2,
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
                // console.log(row.id,this.currentSelectId,status)
                // return
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });

                AuditFeed({id: this.currentSelectId, status: status, reason: this.auditReason}).then(response => {
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
            clickAudit(row) {
                this.currentSelectId = row.id
                this.visible = true
            }
        }
    }
</script>
