<?php $this->start('css'); ?>
<style>
    #map_canvas {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
    .wraper {
        overflow: hidden;
        position: absolute;
        top: 1rem;
        bottom: 1rem;
        left: 0;
        right: 0;
    }
</style>
<?php $this->end('css'); ?>
<header>
    <div class="header">
        <a href='/index/find-list'>
        <span class="l_btn">切换列表</span>
        </a>
        <h1>美约</h1>
    </div>
</header>
<div class="wraper">
    <div id="map_canvas">

    </div>
</div>
<div style="height:1.4rem"></div>
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script id="bmapjs" src="/mobile/js/bmap.js"></script>
<script>
    function initBmap() {
        var map = new BMap.Map("map_canvas");            // 创建Map实例
        map.centerAndZoom(new BMap.Point(114.043566, 22.646635), 15);
        //创建小狐狸
        var pt = new BMap.Point(114.043566, 22.646635);
        var myIcon = new BMap.Icon("/imgs/user/avatar/avatar2.jpg?w=60&border=3,white,overlay", new BMap.Size(60, 60));
        var marker2 = new BMap.Marker(pt, {icon: myIcon});  // 创建标注
        map.addOverlay(marker2);              // 将标注添加到地图中

        wx.getLocation({
            type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                $.bmap.convertor(longitude, latitude, function (lng, lat) {
                    $.bmap.geocoder(lng, lat, function (res) {
//                        alert(res.address);
                        var point = new BMap.Point(lng, lat);
                        map.centerAndZoom(point, 15);
                        map.enableScrollWheelZoom();
                        var marker = new BMap.Marker(point);  // 创建标注
                        map.addOverlay(marker);               // 将标注添加到地图中
                        //marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                        //var avatarOverlay = new avatarOverlay(new BMap.Point(114.043566, 22.646635), {src: '/img/user/avatar/avatar.jpg'});
                        //map.addOverlay(avatarOverlay);
                    });
                });
            }
        })
    }

</script>
<?php $this->end('script'); ?>