(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-fd621bba"],{"21e8":function(t,e,a){},"29e9":function(t,e,a){"use strict";a("21e8")},"4e82":function(t,e,a){"use strict";var n=a("23e7"),l=a("1c0b"),i=a("7b0b"),r=a("d039"),o=a("a640"),s=[],u=s.sort,c=r((function(){s.sort(void 0)})),d=r((function(){s.sort(null)})),p=o("sort"),f=c||!d||!p;n({target:"Array",proto:!0,forced:f},{sort:function(t){return void 0===t?u.call(i(this)):u.call(i(this),l(t))}})},a7e0:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"app-container"},[a("div",{staticClass:"demo-input-suffix"},[[t._v(" 处理状态: "),a("el-select",{attrs:{placeholder:"请选择"},model:{value:t.value,callback:function(e){t.value=e},expression:"value"}},t._l(t.options,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],[t._v(" 反馈类型: "),a("el-select",{attrs:{placeholder:"请选择"},model:{value:t.value2,callback:function(e){t.value2=e},expression:"value2"}},t._l(t.options2,(function(t){return a("el-option",{key:t.value,attrs:{label:t.label,value:t.value}})})),1)],a("el-button",{attrs:{type:"primary"},on:{click:t.fetchData}},[t._v("搜索")])],2),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.list,"element-loading-text":"Loading",border:"",fit:"","highlight-current-row":""}},[a("el-table-column",{attrs:{align:"center",label:"ID",width:"95"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v(" "+t._s(e.row.id)+" ")]}}])}),a("el-table-column",{attrs:{label:"反馈类型",width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[1===parseInt(e.row.feed_type)?a("span",[t._v(" 收取费用")]):2===parseInt(e.row.feed_type)?a("span",[t._v(" 工资拖欠")]):3===parseInt(e.row.feed_type)?a("span",[t._v(" 放鸽子")]):4===parseInt(e.row.feed_type)?a("span",[t._v(" 虚假信息")]):5===parseInt(e.row.feed_type)?a("span",[t._v(" 刷单博彩")]):6===parseInt(e.row.feed_type)?a("span",[t._v(" 其他")]):t._e()]}}])}),a("el-table-column",{attrs:{label:"联系方式",width:"180",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.contact_method))])]}}])}),a("el-table-column",{attrs:{label:"反馈内容",width:"300",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.content))])]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"截图证据",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("ic-slider",{staticStyle:{width:"120px","text-align":"center"},attrs:{autoplay:1e3}},t._l(e.row.img_json_arr,(function(t,e){return a("ic-slider-item",[a("img",{attrs:{src:t}})])})),1)]}}])}),a("el-table-column",{attrs:{align:"center",label:"处理状态",width:"160"},scopedSlots:t._u([{key:"default",fn:function(e){return[0==e.row.status?a("span",[t._v(" 待处理 ")]):1==e.row.status?a("span",[t._v(" 已处理("),a("span",{staticStyle:{color:"#4caf50"}},[t._v("通过")]),t._v(") ")]):a("span",[t._v("已处理("),a("span",{staticStyle:{color:"red"}},[t._v("驳回")]),t._v(")")])]}}])}),a("el-table-column",{attrs:{align:"center",prop:"created_at",label:"操作"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-dialog",{attrs:{placement:"top",width:"400",visible:t.visible,title:"投诉处理结果?"},on:{"update:visible":function(e){t.visible=e}}},[a("el-input",{staticStyle:{"margin-bottom":"10px"},attrs:{placeholder:"请输入内容"},model:{value:t.auditReason,callback:function(e){t.auditReason=e},expression:"auditReason"}},[a("template",{slot:"prepend"},[t._v("审核操作原因")])],2),a("div",{staticStyle:{"text-align":"right",margin:"0"}},[a("el-button",{attrs:{size:"mini",type:"text"},on:{click:function(a){return t.auditStore(e.row,1)}}},[t._v("通过")]),a("el-button",{attrs:{type:"primary",size:"mini"},on:{click:function(a){return t.auditStore(e.row,2)}}},[t._v("驳回")])],1)],1),0===parseInt(e.row.status)?a("el-button",{attrs:{slot:"reference",type:"primary",icon:"el-icon-position"},on:{click:function(a){return t.clickAudit(e.row)}},slot:"reference"},[t._v(" 待处理 ")]):t._e(),1===parseInt(e.row.status)?a("el-button",{attrs:{type:"primary",disabled:"",icon:"el-icon-bottom"},on:{click:function(a){return t.downStore(e.row)}}},[t._v("已通过 ")]):t._e(),2===parseInt(e.row.status)?a("el-button",{attrs:{type:"primary",disabled:"",icon:"el-icon-top"},on:{click:function(a){return t.upStore(e.row)}}},[t._v("已驳回 ")]):t._e()]}}])})],1),a("el-pagination",{staticStyle:{float:"right","margin-top":"20px"},attrs:{background:"",layout:"prev, pager, next",total:t.total,"page-size":t.currentPageSize,"current-page":t.currentPage},on:{"current-change":t.handleCurrentChange,"update:currentPage":function(e){t.currentPage=e},"update:current-page":function(e){t.currentPage=e}}})],1)},l=[],i=(a("4e82"),a("b775"));function r(t){return Object(i["a"])({url:"/v1/feed_back",method:"get",params:t})}function o(t){return Object(i["a"])({url:"/v1/feed_back/audit",method:"POST",data:t})}var s=a("f9a4"),u={components:{IcSlider:s["IcSlider"],IcSliderItem:s["IcSliderItem"]},filters:{statusFilter:function(t){var e={published:"success",draft:"gray",deleted:"danger"};return e[t]}},data:function(){return{list:null,listLoading:!0,visible:!1,auditReason:"",total:0,options:[{value:"-1",label:"全部"},{value:"0",label:"待处理"},{value:"1",label:"已处理"}],options2:[{value:"0",label:"全部"},{value:"1",label:"收取费用"},{value:"2",label:"工资拖欠"},{value:"3",label:"放鸽子"},{value:"4",label:"信息虚假"},{value:"5",label:"刷单博彩"},{value:"6",label:"其他"}],value:"-1",value2:"0",search_name:"",currentPage:1,currentPageSize:10,currentSelectId:0}},created:function(){this.fetchData()},methods:{fetchData:function(){var t=this;this.listLoading=!0,r({status:this.value,feed_type:this.value2,skip:(this.currentPage-1)*this.currentPageSize,limit:this.currentPageSize}).then((function(e){t.list=e.data.items,t.total=e.data.total,t.listLoading=!1}))},switchChange:function(t){UpdateJob(t.id,{is_top:t.is_top?1:0}).then((function(t){console.log(t)}))},handleSortChange:function(t,e){UpdateJob(t.id,{sort:t.sort}).then((function(t){console.log(t)}))},upStore:function(t){var e=this,a=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});UpdateJob(t.id,{status:1}).then((function(t){e.visible=!1,a.close(),e.fetchData()}))},downStore:function(t){var e=this,a=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});UpdateJob(t.id,{status:2}).then((function(t){e.visible=!1,a.close(),e.fetchData()}))},auditStore:function(t,e){var a=this,n=this.$loading({lock:!0,text:"数据提交中",spinner:"el-icon-loading",background:"rgba(0, 0, 0, 0.7)"});o({id:this.currentSelectId,status:e,reason:this.auditReason}).then((function(t){a.visible=!1,n.close(),a.fetchData()}))},updateStore:function(t){this.$router.push({name:"updateStore",query:{id:t.id}})},handleCurrentChange:function(t){this.fetchData()},clickAudit:function(t){this.currentSelectId=t.id,this.visible=!0}}},c=u,d=(a("29e9"),a("2877")),p=Object(d["a"])(c,n,l,!1,null,null,null);e["default"]=p.exports}}]);