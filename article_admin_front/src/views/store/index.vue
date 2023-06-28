<template>
  <div class="app-container">

    <div class="demo-input-suffix">


      <template>
        <el-input
          placeholder="请输入商家名称"
          prefix-icon="el-icon-search"
          v-model="search_name" style="width: 160px; margin-right: 10px; margin-left: 16px;">
        </el-input>
        <el-button @click="fetchData" type="primary">搜索</el-button>
        <el-button @click="newStore" type="primary">新增店铺</el-button>
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
      <el-table-column label="店铺名称" width="100">
        <template slot-scope="scope">
          {{ scope.row.name }}
        </template>
      </el-table-column>
      <el-table-column label="商户余额" width="100" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.balance }}</span>
        </template>
      </el-table-column>
      <el-table-column label="今日报名数" width="100" align="center">
        <template slot-scope="scope">
          {{ scope.row.today_report_count }}
        </template>
      </el-table-column>
      <el-table-column label="营业执照" width="80" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 100px; height: 100px"
            :src="scope.row.business_license"
            fit="cover"></el-image>
        </template>
      </el-table-column>

      <el-table-column label="联系方式" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.contact }}</span>
        </template>
      </el-table-column>

      <el-table-column label="logo" width="80" align="center">
        <template slot-scope="scope">
          <el-image
            style="width: 100px; height: 100px"
            :src="scope.row.logo"
            fit="cover"></el-image>
        </template>
      </el-table-column>

      <el-table-column class-name="status-col" label="在线职位数" width="100" align="center">
        <template slot-scope="scope">
          {{ scope.row.online_count }}
        </template>
      </el-table-column>
      <el-table-column align="center" prop="created_at" label="申请时间" width="160">
        <template slot-scope="scope">
          <span>{{ scope.row.created_at }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="商户状态" width="90">
        <template slot-scope="scope">
          <span v-if="scope.row.status == 0 "> 待审核 </span>
          <span v-else-if="scope.row.status == 1 "> 上架 </span>
          <span v-else>下架</span>
        </template>
      </el-table-column>

      <el-table-column align="center" prop="created_at" label="操作">
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


          <el-dialog
            title="商户余额变更"
            :visible.sync="visibleBalance"
            width="30%"
            :before-close="handleClose">
            <el-input placeholder="请输入变更原因" style="margin-bottom: 10px;" v-model="balanceReason">
              <template slot="prepend">变更原因</template>
            </el-input>
            <el-switch
              style="margin-right: 10px;"
              v-model="changeBalanceMethod"
              active-text="增加"
              inactive-text="扣除">
            </el-switch>
            <el-input-number v-model="changeBalance" :min="1" :max="10000" label="变更余额"></el-input-number>
            <span slot="footer" class="dialog-footer">
              <el-button @click="visibleBalance = false">取 消</el-button>
              <el-button type="primary" @click="changeBalanceClick(scope.$index, scope.row)">确 定</el-button>
            </span>
          </el-dialog>

          <!--el-popover
            placement="top"
            width="350"
            v-model="visibleBalance">
            <p>企业入驻审核结果？</p>
            <el-input placeholder="请输入内容" style="margin-bottom: 10px;" v-model="balanceReason">
              <template slot="prepend">变更原因</template>
            </el-input>
            <el-switch
              v-model="changeBalanceMethod"
              active-text="按月付费"
              inactive-text="按年付费">
            </el-switch>
            <el-input-number v-model="changeBalance" :min="1" :max="1000" label="变更余额"></el-input-number>
            <div style="text-align: right; margin: 0">
              <el-button size="mini" type="text" @click="auditStore(scope.row, 0)">确定</el-button>
              <el-button type="primary" size="mini" @click="auditStore(scope.row, 1)">取消</el-button>
            </div>
          </el-popover-->

          <el-button style="margin-left: 10px;" type="primary" @click="changeBalanceClickShow(scope.row)"
                     icon="el-icon-top">余额变更
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
    import {StoreList, StoreAudit, StoreStatus, StoreBalance} from '@/api/store/list'

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
                visibleBalance: false,
                balanceReason: "",
                changeBalance: 0,
                changeBalanceMethod: true,
                balanceId: 0,
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            changeBalanceClickShow(row) {
                this.visibleBalance = true;
                this.balanceId = row.id

            },
            handleClose() {
                this.visibleBalance = false;

            },
            changeBalanceClick(id, row) {
                StoreBalance({
                    store_id: this.balanceId,
                    amount: this.changeBalance,
                    direction: this.changeBalanceMethod ? 1 : 2,
                    reason: this.balanceReason
                }).then(response => {
                    this.visibleBalance = false;
                    this.fetchData();
                })
            },
            fetchData() {
                this.listLoading = true
                StoreList({
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
            upStore(row) {
                const loading = this.$loading({
                    lock: true,
                    text: '数据提交中',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                StoreStatus({id: row.id, option: "up"}).then(response => {
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
                StoreStatus({id: row.id, option: "down"}).then(response => {
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
                StoreAudit({id: row.id, status: status, reason: this.auditReason}).then(response => {
                    this.visible = false
                    loading.close()
                    this.fetchData()
                })
            },
            newStore(){
                this.$router.push({name: "updateStore"})
            },
            updateStore(row) {
                this.$router.push({name: "updateStore", query: {id: row.id}})
            },
            handleCurrentChange(val) {
                this.fetchData()
            }
        }
    }
</script>
