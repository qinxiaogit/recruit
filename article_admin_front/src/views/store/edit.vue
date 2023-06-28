<template>
  <div class="app-container">
    <el-form ref="form" :model="form" >
      <el-form-item label="店铺名称" style="width: 160px">
        <el-input v-model="form.name" />
      </el-form-item>

      <el-form-item label="店铺logo">
        <el-upload
          class="avatar-uploader"
          :action="postUrl"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :headers="fileToken"
        >
          <img v-if="form.logo" :src="form.logo" style="width: 160px;" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>
      <el-form-item label="选择门店地址">
        <gdMap :changeCall="changeAddressCall" :locationInfo="locationInfo"></gdMap>
      </el-form-item>
      <el-form-item label="今日报名数">
        <el-input v-model="form.today_report_count" disabled />
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    import {getToken} from '@/utils/auth'

    let amapManager = new AMapManager();

    import { AMapManager } from "vue-amap";

    import gdMap from '@/views/common/gd-map'


    export default {
        components: {gdMap},
        data() {
            return {
                form: {
                    name: '',
                    logo: '',
                },
                fileToken: {},
                postUrl: "",
                // 默认初始化显示的坐标
                locationInfo:{
                    iocn:"",
                    name:"",
                    longitude:"", // 经度
                    latitude:"", // 纬度
                    address:"" // 地址
                }

                // zoom: 12,
                // center: [116.191031, 39.988585],
                // amapManager,
                // events: {
                //     init(o) {
                //         let marker = new AMap.Marker({
                //             position: [121.59996, 31.197646],
                //         });
                //         o.setMapStyle('amap://styles/darkblue');
                //         marker.setMap(o);
                //     }
                // }
            }
        },
        created(){
            this.fileToken['Authorization'] = getToken();
            this.postUrl = process.env.VUE_APP_BASE_API + "v1/public/upload"

            // setTimeout(()=>{
            //     this.initMap()
            // },1000)
        },
        methods: {
            handleAvatarSuccess(res, file) {
                this.form.contact_qrcode = res.data.domain + res.data.path;
            },
            onSubmit() {
                this.$message('submit!')
            },
            onCancel() {
                this.$message({
                    message: 'cancel!',
                    type: 'warning'
                })
            },
            // 获取经纬度，地址信息回调方法
            changeAddressCall(address,lng,lat){

                console.log(address,lng,lat)
                this.form.address=address;
                this.form.longitude=lng;
                this.form.latitude=lat;
            },
            initMap() {
                let map = amapManager.getMap();
                let heatmap;
                let heatmapData=[];
                heatmapdata.forEach(item=>{
                    let obj={
                        lng:item.lng,
                        lat:item.lat,
                        count:item.count,
                    }
                    heatmapData.push(obj);
                })
                map.plugin(["AMap.Heatmap"], function() {
                    //初始化heatmap对象
                    heatmap = new AMap.Heatmap(map, {
                        radius: 25, //给定半径
                        opacity: [0, 0.8],
                        gradient:{
                            0.5: 'blue',
                            0.65: 'rgb(117,211,248)',
                            0.7: 'rgb(0, 255, 0)',
                            0.9: '#ffea00',
                            1.0: 'red'
                        }
                    });
                    //设置数据集
                    heatmap.setDataSet({
                        data: heatmapData,
                        max: 5
                    });
                });

            }
        }
    }
</script>

<style scoped>
  .line{
    text-align: center;
  }
</style>

