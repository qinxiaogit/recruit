(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-00d754b7"],{1087:function(t,e,a){},6429:function(t,e,a){"use strict";a("1087")},"856d":function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"app-container"},[a("div",{staticClass:"demo-input-suffix"},[[a("el-button",{attrs:{type:"primary"},on:{click:t.fetchDataToDay}},[t._v("今日活跃"+t._s(t.toDayActive>0?"（"+t.toDayActive+"）":""))]),a("el-button",{attrs:{type:"primary"},on:{click:t.fetchDataToDayRegister}},[t._v("今日新增用户"+t._s(t.toDayRegister>0?"（"+t.toDayRegister+"）":""))])]],2),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.list,"element-loading-text":"Loading",border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{align:"center",label:"ID",width:"95"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.id)+" ")]}}])}),a("el-table-column",{attrs:{label:"用户昵称",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.nickname)+" ")]}}])}),a("el-table-column",{attrs:{label:"用户真实名称",width:"160",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.real_name))])]}}])}),a("el-table-column",{attrs:{label:"生日",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.birthday)+" ")]}}])}),a("el-table-column",{attrs:{label:"用户头像",width:"160",align:"center"},scopedSlots:t._u([{key:"default",fn:function(t){return[a("el-image",{staticStyle:{width:"100px",height:"100px"},attrs:{src:t.row.avatar,fit:"cover"}})]}}])}),a("el-table-column",{attrs:{label:"联系方式",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.mobile))])]}}])}),a("el-table-column",{attrs:{label:"邀请码",width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.invite_code)+" ")]}}])}),a("el-table-column",{attrs:{"class-name":"status-col",label:"性别",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(1===e.row.sex?"男":"女")+" ")]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"注册时间",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.created_at))])]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"邀请人",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[e.row.invite_user?a("el-card",{attrs:{"body-style":{padding:"0px"}}},[a("img",{staticClass:"image",staticStyle:{width:"100px",height:"100px"},attrs:{src:e.row.invite_user.avatar}}),a("div",{staticStyle:{padding:"14px"}},[a("span",[t._v(t._s(e.row.invite_user.nickname))])])]):a("span",[t._v(" 无邀请人")])]}}])})],1),a("el-pagination",{staticStyle:{float:"right","margin-top":"20px"},attrs:{background:"",layout:"prev, pager, next",total:t.total,"page-size":t.currentPageSize,"current-page":t.currentPage},on:{"current-change":t.handleCurrentChange,"update:currentPage":function(e){t.currentPage=e},"update:current-page":function(e){t.currentPage=e}}})],1)},i=[],r=a("c24f"),l={filters:{statusFilter:function(t){var e={published:"success",draft:"gray",deleted:"danger"};return e[t]}},data:function(){return{list:null,listLoading:!0,visible:!1,auditReason:"",total:0,options:[{value:"-1",label:"全部"},{value:"0",label:"待审核"},{value:"1",label:"上架"},{value:"2",label:"下架"}],value:"-1",search_name:"",currentPage:1,currentPageSize:10,toDayRegister:0,toDayActive:0}},created:function(){this.fetchData()},methods:{fetchData:function(){var t=this;this.listLoading=!0,Object(r["a"])({name:this.search_name,status:this.value,skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.listLoading=!1}))},handleCurrentChange:function(t){this.fetchData()},fetchDataToDayRegister:function(){var t=this;this.listLoading=!0,Object(r["a"])({name:this.search_name,source_type:"today_register",skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.listLoading=!1,t.toDayRegister=t.total}))},fetchDataToDay:function(){var t=this;this.listLoading=!0,Object(r["a"])({name:this.search_name,source_type:"today_create",skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.toDayActive=t.total,t.listLoading=!1}))}}},s=l,o=(a("6429"),a("2877")),c=Object(o["a"])(s,n,i,!1,null,null,null);e["default"]=c.exports}}]);