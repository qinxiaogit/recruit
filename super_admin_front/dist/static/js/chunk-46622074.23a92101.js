(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-46622074"],{"4e82":function(t,e,a){"use strict";var o=a("23e7"),n=a("1c0b"),i=a("7b0b"),r=a("d039"),l=a("a640"),s=[],c=s.sort,u=r((function(){s.sort(void 0)})),d=r((function(){s.sort(null)})),p=l("sort"),b=u||!d||!p;o({target:"Array",proto:!0,forced:b},{sort:function(t){return void 0===t?c.call(i(this)):c.call(i(this),n(t))}})},"505c":function(t,e,a){"use strict";a("ba8b")},ba8b:function(t,e,a){},e53f:function(t,e,a){"use strict";a.d(e,"a",(function(){return n})),a.d(e,"b",(function(){return i})),a.d(e,"c",(function(){return r}));var o=a("b775");function n(t){return Object(o["a"])({url:"/v1/jobs",method:"get",params:t})}function i(t,e){return Object(o["a"])({url:"/v1/jobs/"+t,method:"put",params:e})}function r(t){return Object(o["a"])({url:"/v1/jobs/share",method:"post",data:t})}},fac5:function(t,e,a){"use strict";a.r(e);var o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"app-container"},[a("div",{staticClass:"demo-input-suffix"},[[t._v(" 职位状态: "),a("el-select",{attrs:{placeholder:"请选择"},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.options,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],[a("el-input",{staticStyle:{width:"160px","margin-right":"10px","margin-left":"16px"},attrs:{placeholder:"请输入职位名称","prefix-icon":"el-icon-search"},model:{value:t.search_name,callback:function(e){t.search_name=e},expression:"search_name"}}),a("el-button",{attrs:{type:"primary"},on:{click:t.fetchData}},[t._v("搜索")])]],2),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.list,"element-loading-text":"Loading",border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{align:"center",label:"ID",width:"95"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.id)+" ")]}}])}),a("el-table-column",{attrs:{label:"职位名称",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.name)+" "),e.row.audit_log?a("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:e.row.audit_log.extra.work_content,placement:"top-start"}},[a("span",{staticStyle:{color:"red",display:"block"}},[t._v(t._s(e.row.audit_log?e.row.audit_log.extra.name:""))])]):t._e()]}}])}),a("el-table-column",{attrs:{label:"是否置顶",width:"100",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-switch",{attrs:{"active-color":"#13ce66","inactive-color":"#ff4949","active-text":"是","inactive-text":"否"},on:{change:function(a){return t.switchChange(e.row)}},model:{value:e.row.is_top,callback:function(a){t.$set(e.row,"is_top",a)},expression:"scope.row.is_top"}})]}}])}),a("el-table-column",{attrs:{label:"排名",width:"150",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-input-number",{staticStyle:{width:"120px"},attrs:{"controls-position":"right",min:1,max:100},on:{change:function(a){return t.handleSortChange(e.row)}},model:{value:e.row.sort,callback:function(a){t.$set(e.row,"sort",a)},expression:"scope.row.sort"}})]}}])}),a("el-table-column",{attrs:{label:"浏览量",width:"110",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.view_count))])]}}])}),a("el-table-column",{attrs:{label:"报名量",width:"80",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.report_count)+" ")]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"申请时间",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.created_at))])]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"店铺信息",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-card",{attrs:{"body-style":{padding:"0px"}}},[a("img",{staticClass:"image",staticStyle:{width:"100px",height:"100px"},attrs:{src:e.row.store.logo}}),a("div",{staticStyle:{padding:"14px"}},[a("span",[t._v(t._s(e.row.store.name))])])])]}}])}),a("el-table-column",{attrs:{align:"center",label:"商户状态",width:"90"},scopedSlots:t._u([{key:"default",fn:function(e){return[0==e.row.status?a("span",[t._v(" 待审核 ")]):1==e.row.status?a("span",[t._v(" 上架 ")]):a("span",[t._v("下架")]),a("span",{staticStyle:{color:"red"}},[t._v(t._s(e.row.audit_log?"(修改系统审核)":""))])]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{staticStyle:{display:"none"},attrs:{type:"primary",icon:"el-icon-edit"},on:{click:function(a){return t.updateStore(e.row)}}},[t._v("编辑 ")]),a("el-popover",{attrs:{placement:"top",width:"400"},model:{value:t.visible,callback:function(e){t.visible=e},expression:"visible"}},[a("p",[t._v("职位审核结果？")]),a("span",{staticStyle:{display:"block"}},[t._v("职位名称："+t._s(e.row.name)+" "),a("span",{staticStyle:{color:"red"}},[t._v(t._s(e.row.audit_log?e.row.audit_log.extra.name:""))])]),a("span",{staticStyle:{display:"block"}},[t._v("职位介绍："+t._s(e.row.work_content)+" "),a("span",{staticStyle:{color:"red"}},[t._v(t._s(e.row.audit_log?e.row.audit_log.extra.work_content:""))])]),a("span",{staticStyle:{display:"block"}},[t._v("职位要求："+t._s(e.row.work_require))]),a("span",{staticStyle:{display:"block"}},[t._v("薪资说明："+t._s(e.row.salary)+"/"+t._s(e.row.unit))]),a("el-input",{staticStyle:{"margin-bottom":"10px"},attrs:{placeholder:"请输入内容"},model:{value:t.auditReason,callback:function(e){t.auditReason=e},expression:"auditReason"}},[a("template",{slot:"prepend"},[t._v("审核操作原因")])],2),a("div",{staticStyle:{"text-align":"right",margin:"0"}},[a("el-button",{attrs:{size:"mini",type:"text"},on:{click:function(a){return t.auditStore(e.row,1)}}},[t._v("审核通过")]),a("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(a){return t.auditStore(e.row,2)}}},[t._v("审核驳回")])],1),0===parseInt(e.row.status)||e.row.audit_log?a("el-button",{staticStyle:{"margin-right":"5px"},attrs:{slot:"reference",type:"primary",icon:"el-icon-position"},slot:"reference"},[t._v(" 审核 ")]):t._e()],1),1===parseInt(e.row.status)?a("el-button",{attrs:{type:"primary",icon:"el-icon-bottom"},on:{click:function(a){return t.downStore(e.row)}}},[t._v("下架 ")]):t._e(),2===parseInt(e.row.status)?a("el-button",{attrs:{type:"primary",icon:"el-icon-top"},on:{click:function(a){return t.upStore(e.row)}}},[t._v("上架 ")]):t._e(),1===parseInt(e.row.status)?a("el-button",{attrs:{type:"primary",icon:"el-icon-share"},on:{click:function(a){return t.shareJob(e.row)}}},[t._v("分享 ")]):t._e()]}}])})],1),a("el-pagination",{staticStyle:{float:"right","margin-top":"20px"},attrs:{background:"",layout:"prev, pager, next",total:t.total,"page-size":t.currentPageSize,"current-page":t.currentPage},on:{"current-change":t.handleCurrentChange,"update:currentPage":function(e){t.currentPage=e},"update:current-page":function(e){t.currentPage=e}}}),a("el-dialog",{attrs:{title:"生成邀请码",visible:t.dialogInviteCode,width:"30%","before-close":t.dialogInviteCodeClose},on:{"update:visible":function(e){t.dialogInviteCode=e}}},[a("span",[t._v("职位名称"+t._s(t.dialogJobName))]),a("el-input",{staticStyle:{"margin-top":"12px"},attrs:{placeholder:"请输入分享用户手机号"},on:{input:t.changeUserMobile},model:{value:t.dialogUserMobile,callback:function(e){t.dialogUserMobile=e},expression:"dialogUserMobile"}}),t.jobShareUrl?a("el-image",{staticStyle:{width:"100px",height:"100px","margin-top":"12px"},attrs:{src:t.jobShareUrl}}):t._e(),a("span",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.dialogInviteCode=!1}}},[t._v("取 消")]),a("el-button",{attrs:{type:"primary",disabled:t.disableGen},on:{click:t.shareJobClick}},[t._v("生成分享码")])],1)],1)],1)},n=[],i=(a("4e82"),a("b0c0"),a("e53f")),r={filters:{statusFilter:function(t){var e={published:"success",draft:"gray",deleted:"danger"};return e[t]}},data:function(){return{disableGen:!0,jobShareUrl:"",dialogJobName:"",currentJobId:"",dialogUserMobile:"",dialogInviteCode:!1,list:null,listLoading:!0,visible:!1,auditReason:"",total:0,options:[{value:"-1",label:"全部"},{value:"0",label:"待审核"},{value:"1",label:"上架"},{value:"2",label:"下架"}],value:"-1",search_name:"",currentPage:1,currentPageSize:10}},created:function(){this.fetchData()},methods:{fetchData:function(){var t=this;this.listLoading=!0,Object(i["a"])({name:this.search_name,status:this.value,skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.listLoading=!1}))},switchChange:function(t){Object(i["b"])(t.id,{is_top:t.is_top?1:0}).then((function(t){console.log(t)}))},handleSortChange:function(t,e){Object(i["b"])(t.id,{sort:t.sort}).then((function(t){console.log(t)}))},upStore:function(t){var e=this,a=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});Object(i["b"])(t.id,{status:1}).then((function(t){e.visible=!1,a.close(),e.fetchData()}))},downStore:function(t){var e=this,a=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});Object(i["b"])(t.id,{status:2}).then((function(t){e.visible=!1,a.close(),e.fetchData()}))},auditStore:function(t,e){var a=this,o=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});Object(i["b"])(t.id,{status:e}).then((function(t){a.visible=!1,o.close(),a.fetchData()}))},updateStore:function(t){this.$router.push({name:"updateStore",query:{id:t.id}})},handleCurrentChange:function(t){this.fetchData()},shareJob:function(t){this.dialogInviteCode=!0,this.dialogJobName=t.name,this.currentJobId=t.id,console.log(t)},shareJobClick:function(){var t=this;Object(i["c"])({job_id:this.currentJobId,mobile:this.dialogUserMobile,source:"job"}).then((function(e){console.log(e),t.jobShareUrl=e.data.domain+e.data.path}))},dialogInviteCodeClose:function(){this.dialogInviteCode=!1},changeUserMobile:function(){this.disableGen=!1}}},l=r,s=(a("505c"),a("2877")),c=Object(s["a"])(l,o,n,!1,null,null,null);e["default"]=c.exports}}]);