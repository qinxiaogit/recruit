(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-bc706794"],{"22b2":function(t,a,e){},9406:function(t,a,e){"use strict";e.r(a);var s=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",{staticClass:"app-container"},[e("el-form",{ref:"form",attrs:{model:t.form,"label-width":"120px"}},[e("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"店铺名称"}},[e("el-input",{model:{value:t.form.name,callback:function(a){t.$set(t.form,"name",a)},expression:"form.name"}})],1),e("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"店铺余额"}},[e("el-input",{attrs:{disabled:""},model:{value:t.form.balance,callback:function(a){t.$set(t.form,"balance",a)},expression:"form.balance"}})],1),e("el-form-item",{attrs:{label:"店铺logo"}},[e("el-upload",{staticClass:"avatar-uploader",attrs:{action:t.postUrl,"show-file-list":!1,"on-success":t.handleAvatarSuccess,headers:t.fileToken}},[t.form.logo?e("img",{staticClass:"avatar",staticStyle:{width:"160px"},attrs:{src:t.form.logo}}):e("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1),e("el-form-item",{attrs:{label:"营业执照"}},[e("el-upload",{staticClass:"avatar-uploader",attrs:{action:t.postUrl,"show-file-list":!1,headers:t.fileToken,"on-success":t.handleBusinessSuccess}},[t.form.business_license?e("img",{staticClass:"avatar",staticStyle:{width:"160px"},attrs:{src:t.form.business_license}}):e("i",{staticClass:"el-icon-plus avatar-uploader-icon"})])],1),e("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"联系方式"}},[e("el-input",{model:{value:t.form.contact,callback:function(a){t.$set(t.form,"contact",a)},expression:"form.contact"}})],1),e("el-form-item",{staticStyle:{width:"300px"},attrs:{label:"管理员密码"}},[e("el-input",{model:{value:t.form.password,callback:function(a){t.$set(t.form,"password",a)},expression:"form.password"}})],1),e("el-form-item",[e("el-button",{attrs:{type:"primary"},on:{click:t.onSubmit}},[t._v("确认修改")])],1)],1)],1)},o=[],n=(e("b0c0"),e("5f87")),i=e("b775");e("3fd3");function l(t){return Object(i["a"])({url:"/v1/store/show",method:"get",data:t})}var c={data:function(){return{form:{name:"",logo:"",business_license:"",contact:"",password:""},fileToken:{},postUrl:""}},created:function(){this.fileToken["Authorization"]=Object(n["a"])(),this.postUrl="http://shoper.jubaohuizhong.com/api/v1/public/upload",this.init()},methods:{onSubmit:function(){this.$message("submit!")},onCancel:function(){this.$message({message:"cancel!",type:"warning"})},handleAvatarSuccess:function(t,a){this.form.logo=t.data.domain+t.data.path},handleBusinessSuccess:function(t,a){this.form.business_license=t.data.domain+t.data.path},init:function(){var t=this;l().then((function(a){t.form.name=a.data.name,t.form.balance=a.data.balance,t.form.logo=a.data.logo,t.form.business_license=a.data.business_license,t.form.contact=a.data.contact}))}}},r=c,m=(e("ed69"),e("2877")),u=Object(m["a"])(r,s,o,!1,null,"476a0376",null);a["default"]=u.exports},ed69:function(t,a,e){"use strict";e("22b2")}}]);