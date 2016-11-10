<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="place-list-tpl" type="text/html">
    {{#places}}
    <li>
        <div class="items flex flex_justify inner">
            <div class="con_left">
                <span class="place_img"><img src="/mobile/images/date_place.jpg"/></span>
                <h3 class="place_info">
                    <span class="place_name">{{name}}</span>
                    <span class="color_gray place_address">{{address}}</span>
                    <div class="con_mark">
                        <a href="#this" class="mark_name">安静</a>
                        <a href="#this" class="mark_name">美味</a>
                        <a href="#this" class="mark_name">高端</a>
                    </div>
                </h3>
            </div>
            <div class="con_right">
                <span class="button btn_dark con_detail"><a data-uid="{{uid}}" class="place_link" href="#placeDetail">查看详情</a></span>
                <span class="con_price color_y">￥ <i class="lagernum">{{detail_info.price}}</i> /人</span>
            </div>
        </div>
    </li>
    {{/places}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>选择约会地点</h1>
    </div>
</header>
<div class="wraper page" id="page-choosePlace" hidden>
    <div class="search_bar inner">
        <div class="search">
            <input type="text" placeholder="搜索" />
        </div>
    </div>
    <div class="place_filter_tab">
        <div class="filter_tab_header flex">
            <span class="filter_tab_left">全部 <i class="iconfont">&#xe649;</i></span>
            <span class="filter_tab_right">默认排序 <i class="iconfont">&#xe649;</i></span>
        </div>
        <div class="filter_tab_content">
            <ul class="outerblock filter_tab_con tab_hide">
                <li><a href="#this">龙华新区</a></li>
                <li><a href="#this">龙华新区2</a></li>
                <li><a href="#this">龙华新区3</a></li>
            </ul>
            <ul class="outerblock filter_tab_con" style="display: none;">
                <li><a href="#this">综合</a></li>
                <li><a href="#this">价格</a></li>
                <li><a href="#this">智能</a></li>
            </ul>
        </div>
    </div>
    <div class="find_place_list">
        <ul id="place-list" class="outerblock">

        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/date-order/find-place/', page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'});
setTimeout(function () {
    $(window).on("scroll", function () {
        $.util.listScroll('place-list', function () {
            $.util.asyLoadData({gurl: '/date-order/find-place/', page: curpage,
                tpl: '#place-list-tpl', id: '#place-list', more: true, key: 'places'});
        })
    });
}, 2000);
</script>
<?php $this->end('script'); ?>