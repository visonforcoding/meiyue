<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="format-detection"content="telephone=no, email=no" />
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title><?= $pageTitle ?></title>
        <link rel="stylesheet" href="/mobile/css/basic.css">
        <link rel="stylesheet" href="/mobile/css/style.css">
        <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="/mobile/js/zepto.min.js"></script>
        <script src="/mobile/js/view.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="/mobile/js/util.js"></script>
        <script type="text/javascript" src="/mobile/js/jsapi.js"></script>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('static') ?>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <script>
            wx.config(<?= json_encode($wxConfig) ?>);
            wx.ready(function () {
                if (!$.util.getCookie('coord')) {
                    wx.getLocation({
                        type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                        success: function (res) {
                            var lat = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                            var lng = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                            var speed = res.speed; // 速度，以米/每秒计
                            var accuracy = res.accuracy; // 位置精度
                            $.util.setCookie('coord', lng + ',' + lat, 30);
                        }
                    })
                }
            });
        </script>
        <?= $this->fetch('script') ?>
    </body>
</html>
