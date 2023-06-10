<template>
  <div class="app-container">
    <div style="margin-bottom: 10px;">
      <el-button @click="jumpAddCate" type="primary">新增职位分类</el-button>
      <el-button @click="DeleteCate" type="primary">删除职位分类</el-button>
    </div>
    <el-tree
      ref="tree2"
      :data="data2"
      class="filter-tree"
      default-expand-all
      show-checkbox
      node-key="id"

    />

  </div>
</template>

<script>
    import {DeleteJobCate, JobCateTree} from '@/api/jobCat'

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
                data2: [],
                listLoading: false
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            jumpAddCate(id) {
                if (id !== undefined) {
                    this.$router.push({name: "catEdit", query: {id: id}})
                } else {
                    this.$router.push({name: "catEdit"})

                }
            },
            fetchData() {
                this.listLoading = true
                JobCateTree({}).then(response => {
                    this.data2 = response.data
                    // this.total = response.data.total
                    this.listLoading = false
                })
            },
            DeleteCate() {
                let self =  this
                DeleteJobCate({id_arr: this.$refs.tree2.getCheckedKeys()}).then(response => {
                    self.fetchData()
                })

            }
        }
    }
</script>
