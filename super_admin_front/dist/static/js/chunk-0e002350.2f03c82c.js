(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0e002350"],{5712:function(t,e,n){"use strict";n("e3f8")},e382:function(t,e,n){"use strict";n.r(e);var a=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"app-container"},[n("div",{staticClass:"demo-input-suffix"},[[n("el-input",{staticStyle:{width:"160px","margin-right":"10px","margin-left":"16px"},attrs:{placeholder:"请输入用户手机号","prefix-icon":"el-icon-search"},model:{value:t.search_name,callback:function(e){t.search_name=e},expression:"search_name"}}),n("el-button",{attrs:{type:"primary"},on:{click:t.fetchData}},[t._v("搜索")])]],2),n("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.list,"element-loading-text":"Loading",border:"",fit:"","highlight-current-row":""}},[n("el-table-column",{attrs:{label:"用户真实名称",width:"100",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.real_name))])]}}])}),n("el-table-column",{attrs:{label:"年龄",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.age)+" ")]}}])}),n("el-table-column",{attrs:{label:"联系方式",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.mobile))])]}}])}),n("el-table-column",{attrs:{label:"邀请码",width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.invite_code)+" ")]}}])}),n("el-table-column",{attrs:{"class-name":"status-col",label:"性别",width:"120",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(1===e.row.sex?"男":"女")+" ")]}}])}),n("el-table-column",{attrs:{align:"center",prop:"created_at",label:"注册时间",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("span",[t._v(t._s(e.row.created_at))])]}}])}),n("el-table-column",{attrs:{align:"center",prop:"created_at",label:"邀请人",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[e.row.invite_user?n("el-card",{attrs:{"body-style":{padding:"0px"}}},[n("div",{staticStyle:{padding:"1px"}},[n("span",[t._v(t._s(e.row.invite_user.mobile))])]),n("div",{staticStyle:{padding:"1px"}},[n("span",[t._v(t._s(e.row.invite_user.real_name))])])]):n("span",[t._v(" 无邀请人")])]}}])}),n("el-table-column",{attrs:{align:"center",prop:"created_at",label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[n("el-button",{attrs:{type:"primary",icon:"el-icon-share"},on:{click:function(n){return t.shareJob(e.row)}}},[t._v("分享 ")]),n("el-button",{attrs:{type:"primary",icon:"el-icon-open"},on:{click:function(n){return t.optionAgent(e.row)}}},[t._v(t._s(e.row.is_open_agent?"取消":"开通")+"代理推广 ")]),e.row.is_open_agent?n("el-button",{attrs:{type:"primary",icon:"el-icon-open"},on:{click:function(n){return t.viewPromotionPage(e.row)}}},[t._v("推广数据 ")]):t._e()]}}])})],1),n("el-pagination",{staticStyle:{float:"right","margin-top":"20px"},attrs:{background:"",layout:"prev, pager, next",total:t.total,"page-size":t.currentPageSize,"current-page":t.currentPage},on:{"current-change":t.handleCurrentChange,"update:currentPage":function(e){t.currentPage=e},"update:current-page":function(e){t.currentPage=e}}}),n("el-dialog",{attrs:{title:"生成邀请码",visible:t.dialogInviteCode,width:"30%","before-close":t.dialogInviteCodeClose},on:{"update:visible":function(e){t.dialogInviteCode=e}}},[t.jobShareUrl?n("el-image",{staticStyle:{width:"100px",height:"100px","margin-top":"12px"},attrs:{src:t.jobShareUrl}}):t._e(),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){t.dialogInviteCode=!1}}},[t._v("取 消")]),n("el-button",{attrs:{type:"primary",disabled:t.disableGen},on:{click:t.shareJobClick}},[t._v("生成分享码")])],1)],1),n("el-dialog",{attrs:{title:t.dialogAgent,visible:t.dialogAgentFlag,width:"30%","before-close":t.dialogInviteCodeClose},on:{"update:visible":function(e){t.dialogAgentFlag=e}}},[n("el-input",{directives:[{name:"show",rawName:"v-show",value:!t.currentAgentStatus,expression:"!currentAgentStatus"}],attrs:{placeholder:"请输入密码","show-password":""},model:{value:t.dialogAgentPassword,callback:function(e){t.dialogAgentPassword=e},expression:"dialogAgentPassword"}}),n("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[n("el-button",{on:{click:function(e){t.dialogAgentFlag=!1}}},[t._v("取 消")]),n("el-button",{attrs:{type:"primary"},on:{click:t.optionAgentClick}},[t._v("确定")])],1)],1)],1)},o=[],i=(n("b0c0"),n("c24f")),r=n("e53f"),l={filters:{statusFilter:function(t){var e={published:"success",draft:"gray",deleted:"danger"};return e[t]}},data:function(){return{dialogAgent:"开通代理商",dialogAgentFlag:!1,dialogAgentPassword:"",disableGen:!1,jobShareUrl:"",dialogJobName:"",currentJobId:"",currentAgentStatus:0,dialogUserMobile:"",dialogInviteCode:!1,list:null,listLoading:!0,visible:!1,auditReason:"",total:0,options:[{value:"-1",label:"全部"},{value:"0",label:"待审核"},{value:"1",label:"上架"},{value:"2",label:"下架"}],value:"-1",search_name:"",currentPage:1,currentPageSize:10}},created:function(){this.fetchData()},methods:{fetchData:function(){var t=this;this.listLoading=!0,Object(i["c"])({nickname:this.search_name,skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.listLoading=!1}))},handleCurrentChange:function(t){this.fetchData()},shareJob:function(t){this.dialogInviteCode=!0,this.dialogJobName=t.name,this.currentJobId=t.id,this.dialogUserMobile=t.mobile,this.jobShareUrl="",console.log(t)},shareJobClick:function(){var t=this;Object(r["c"])({job_id:this.currentJobId,mobile:this.dialogUserMobile,source:"home"}).then((function(e){console.log(e),t.jobShareUrl=e.data.domain+e.data.path}))},viewPromotionPage:function(t){this.$router.push({name:"promotionPage",query:{id:t.id}})},dialogInviteCodeClose:function(){this.dialogInviteCode=!1,this.dialogAgentFlag=!1},changeUserMobile:function(){this.disableGen=!1},optionAgent:function(t){this.currentJobId=t.id,this.dialogAgentFlag=!0,this.currentAgentStatus=t.is_open_agent,1==this.currentAgentStatus&&(this.dialogAgent="取消代理商")},optionAgentClick:function(){var t=this;this.currentAgentStatus||this.dialogAgentPassword||this.$message("开通代理商密码不可为空"),Object(i["b"])({uid:this.currentJobId,status:this.currentAgentStatus?0:1,password:this.dialogAgentPassword}).then((function(e){t.$message("操作成功"),t.dialogAgentFlag=!1,t.fetchData()}))}}},s=l,c=(n("5712"),n("2877")),u=Object(c["a"])(s,a,o,!1,null,null,null);e["default"]=u.exports},e3f8:function(t,e,n){},e53f:function(t,e,n){"use strict";n.d(e,"a",(function(){return o})),n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return r}));var a=n("b775");function o(t){return Object(a["a"])({url:"/v1/jobs",method:"get",params:t})}function i(t,e){return Object(a["a"])({url:"/v1/jobs/"+t,method:"put",params:e})}function r(t){return Object(a["a"])({url:"/v1/jobs/share",method:"post",data:t})}}}]);