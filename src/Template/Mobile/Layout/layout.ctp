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
        <script src="/mobile/js/loopScroll.js" type="text/javascript" charset="utf-8"></script>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('static') ?>
        <script id="hideHeaderTpl" type="text/html">
            <style>
                header{
                    display: none;  
                }
                .footer{
                    display: none;
                }
            </style>
        </script>
        <script>
            function addParem(param, url) {
                if (!param)
                    return '';
                if (!url)
                    url = location.href;
                return url + (url.indexOf('?') > 0 ? '&' : '?') + param;
            }

            (function () {  //对ajax url加随机数
                var _ajaxO = $.ajax;
                $.ajax = function (obj) {
                    if (typeof obj.url == 'string') {
                        obj.url = addParem('t=' + Math.random(), obj.url);
                    }
                    _ajaxO(obj);
                }
            })();
            if (navigator.userAgent.toLowerCase().indexOf('smartlemon') != -1) {
                document.write($('#hideHeaderTpl').text());
            }
        </script>
    </head>
    <body>
        <?= $this->fetch('content') ?>
        <script>
            wx.config(<?= json_encode($wxConfig) ?>);
            //$.util.setCookie('coord', '114.044555,22.6453', 30); //测试时候的初始坐标
            //$.util.setCookie('coord_time',<?//=  time()?>);
            if ($.util.isAPP) {
                //app定位
                if (!$.util.getCookie('coord')) {
                    LEMON.event.getLocation(function (res) {
                        var data = JSON.parse(res);
                        if (data.success === 'ok') {
                            $.util.setCookie('coord', data.lng + ',' + data.lng, 30);
                            $.util.setCookie('coord_time',<?= time() ?>, 30);
                        }
                    });
                }
            }
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
                            $.util.setCookie('coord_time',<?= time() ?>, 30);
                        }
                    })
                }
            });
            window.onerror = $.util.windowError;
            (function () {  //cookie和jsapi直接互相设置token_uin
                if (!$.util.isAPP)
                    return;
                var apptk = LEMON.db.get('token_uin'), cookietk = $.util.getCookie('token_uin');
                if (apptk && cookietk) {
                    if ((new Date()).getDay() != LEMON.db.get('tokenset')) {  //每天一次  检查一下
                        LEMON.db.set('tokenset', (new Date()).getDay());
                        LEMON.db.set('token_uin', cookietk);
                    }

                    return;
                } else if (apptk) {
                    $.util.setCookie('token_uin', apptk, 99999999);
                } else if (cookietk) {
                    LEMON.db.set('token_uin', cookietk);
                }
            })();
        </script>
        <?= $this->fetch('script') ?>
    </body>
</html>
