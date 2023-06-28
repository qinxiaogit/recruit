<template>
  <div class="amap-page-container">
    <el-amap-search-box
      class="search-box"
      :search-option="searchOption"
      :on-search-result="onSearchResult"
    ></el-amap-search-box>
    <div class="map-content">
      <el-amap
        ref="map"
        vid="amapDemo"
        :amap-manager="amapManager"
        :events="events"
        :center="center"
        expandZoomRange="true"
        :zoom="zoom"
        :plugin="plugins"
        :pitch="66"
      >
        <el-amap-marker :position="center" :icon="icon" :title="address">
        </el-amap-marker>
      </el-amap>
    </div>
    <div class="toolbar">
      position: [{
      { lng }}, {
      { lat }}] address: {
      { address }}
    </div>
  </div>
</template>
<script>
    import { AMapManager } from "vue-amap";
    let amapManager = new AMapManager();
    export default {
        props: {
            locationInfo: {
                type: Object,
                default: null,
            },
            changeCall: {
                type: Function,
                default: null,
            },
        },
        data() {
            let self = this;
            return {
                amapManager,
                zoom: 12,
                center: [117.121024, 36.654143],
                address: "",
                searchOption: {
                    city: "",
                    citylimit: true,
                },
                markers: [
                    // [121.59996, 31.197646],
                    // [121.40018, 31.197622],
                    // [121.69991, 31.207649]
                ],
                events: {
                    click(e) {
                        let { lng, lat } = e.lnglat;
                        self.lng = lng;
                        self.lat = lat;
                        // 这里通过高德 SDK 完成。
                        var geocoder = new AMap.Geocoder({
                            radius: 1000,
                            extensions: "all",
                        });
                        geocoder.getAddress([lng, lat], function (status, result) {
                            if (status === "complete" && result.info === "OK") {
                                if (result && result.regeocode) {
                                    self.center = [self.lng, self.lat];
                                    self.address = result.regeocode.formattedAddress;
                                    self.$nextTick();
                                    self.locationChange();
                                }
                            }
                        });
                    },
                },
                lng: 0,
                lat: 0,
                plugins: [
                    {
                        enableHighAccuracy: true, //是否使用高精度定位，默认:true
                        timeout: 100, //超过10秒后停止定位，默认：无穷大
                        maximumAge: 0, //定位结果缓存0毫秒，默认：0
                        convert: true, //自动偏移坐标，偏移后的坐标为高德坐标，默认：true
                        showButton: true, //显示定位按钮，默认：true
                        buttonPosition: "LB", //定位按钮停靠位置，默认：'LB'，左下角
                        showMarker: true, //定位成功后在定位到的位置显示点标记，默认：true
                        showCircle: true, //定位成功后用圆圈表示定位精度范围，默认：true
                        panToLocation: false, //定位成功后将定位到的位置作为地图中心点，默认：true
                        zoomToAccuracy: true, //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：f
                        extensions: "all",
                        //地图定位按钮
                        pName: "Geolocation",
                        init(o) {
                            // o 是高德地图定位插件实例
                            o.getCurrentPosition((status, result) => {
                                console.log(result);
                                debugger;
                                if (result && result.position) {
                                    self.lng = result.position.lng;
                                    self.lat = result.position.lat;
                                    self.center = [self.lng, self.lat];
                                    self.loaded = true;
                                    self.$nextTick();
                                }
                            });
                        },
                    },
                ],
                icon: null,
            };
        },
        created() {
            if (this.locationInfo) {
                this.iocn = this.locationInfo.iocn;
                this.name = this.locationInfo.name;
                this.address = this.locationInfo.address;
                this.lng = this.locationInfo.longitude;
                this.lat = this.locationInfo.latitude;
                this.center = [this.lng, this.lat];
            } else {
                var Geolocation = new AMap.Geolocation({
                    radius: 1000,
                    extensions: "all",
                });
            }
        },
        methods: {
            locationChange() {
                if (this.changeCall) {
                    this.changeCall(this.address, this.lng, this.lat);
                }
            },
            onSearchResult(pois) {
                let latSum = 0;
                let lngSum = 0;
                if (pois.length > 0) {
                    pois.forEach((poi) => {
                        let { lng, lat } = poi;
                        lngSum += lng;
                        latSum += lat;
                        this.markers.push([poi.lng, poi.lat]);
                    });
                    let center = {
                        lng: lngSum / pois.length,
                        lat: latSum / pois.length,
                    };
                    this.center = [center.lng, center.lat];
                }
            },
        },
    };
</script>
<style>
  .amap-page-container {
    width: 100%;
    height: 500px;
  }
  .search-box {
    position: absolute;
    top: 65px;
    left: 20px;
  }
  .map-content {
    height: 90%;
  }
</style>
