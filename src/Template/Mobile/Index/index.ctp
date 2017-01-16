<?php $this->start('css'); ?>
<style>
    #map_canvas {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
    .wraper {
        overflow: hidden;
        position: absolute;
        top: 1rem;
        bottom: 67px;
        width:100%;
        max-width:750px;
    }
    .user-marker{
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #F3AD3D;
    }
    .user-marker img{
        width: 100%;
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
    <div id="getPos" class='fixed-position'>
        <div class='fixed-pic'>
            <img src="/mobile/images/position.png" alt="">
        </div>
    </div>
</div>
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=e6a00ec81910abdb86c3c124211575cf"></script>
<script>
    var map = new AMap.Map("map_canvas", {

    });
    wx.ready(function () {
        getPos();
    });
    $('#getPos').on('click', function () {
        getPos();
    });
    function getPos() {
        wx.getLocation({
            type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
            success: function (res) {
                var lat = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                var lng = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                var speed = res.speed; // 速度，以米/每秒计
                var accuracy = res.accuracy; // 位置精度
                map.setZoomAndCenter(14, [lng, lat]);
                // 在新中心点添加 marker 
                var marker = new AMap.Marker({
                    map: map,
                    position: [lng, lat]
                });
                addUsersMk(lng, lat);
            }
        })
    }
    //地图中添加地图操作ToolBar插件
    map.plugin(['AMap.ToolBar'], function () {
        //设置地位标记为自定义标记
        var toolBar = new AMap.ToolBar();
        map.addControl(toolBar);
    });

    function addUsersMk(lng, lat) {
        //添加用户标注
        $.util.ajax({
            url: '/index/getMapUsers',
            data: {lng: lng, lat: lat},
            func: function (res) {
                console.log(res.users);
                $.each(res.users, function (i, n) {
                    alert(n.id);
                    var marker = new AMap.Marker({//添加自定义点标记
                        map: map,
                        position: [n.login_coord_lng, n.login_coord_lat], //基点位置
                        offset: new AMap.Pixel(-17, -42), //相对于基点的偏移位置
                        draggable: false, //是否可拖动
                        content: '<div class="user-marker"><img src="' + n.avatar + '"/></div>'   //自定义点标记覆盖物内容
                    });
                });
            }
        });
    }
</script>
<?php $this->end('script'); ?>