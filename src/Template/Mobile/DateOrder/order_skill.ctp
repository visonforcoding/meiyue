<?php $this->start('css') ?>
<style>
    .page{
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
    }
</style>
<?php $this->end('css') ?>
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
                <span class="button btn_dark con_detail">
                <a data-name="{{name}}" data-coordlng="{{location.lng}}" data-coordlat="{{location.lat}}" data-uid="{{uid}}" class="place_link" >查看详情</a>
                </span>
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
        <h1>约会详情</h1>
        <!--<span class="r_btn">编辑</span>-->
    </div>
</header>
<div class="wraper page-current" id="page-orderSkill">
    <div class="find_date_detail">
        <div class="date_top_con flex inner">
            <span class="place"><img src="<?= createImg($data->user->avatar) . '?w=88' ?>"/></span>
            <h3 class="date_top_con_right">
                <span class="date_ability">[<?= $data->skill->name ?>]</span>
                <span class="date_guest"><?= $data->user->nick ?> <i class="iconfont color_y">&#xe61d;</i><i class="age color_y"><?= getAge($data->user->birthday) ?></i></span>
                <span class="date_much"><i><?= $data->cost->money ?></i> 美币/小时</span>
            </h3>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">约会说明</h3>
            <div class="con date_keyword">
                <p><?= $data->description ?></p>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">我的标签</h3>
            <div class="con con_mark">
                <?php foreach ($data->tags as $tag): ?>
                    <a href="#this"><?= $tag->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">邀约时间与地点</h3>
            <div class="con com_choose_time">
                <ul class="outerblock">
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>时间</span>
                            <div id="datetime">
<!--                                <span>09-28 21:00~22:00</span>
                                <i class="iconfont r_con">&#xe605;</i>-->
                                <input id="time" type="text" readonly="true"  value="" placeholder="请选择约会时间" />
                                <input id="start-time" name="start_time" type="text" readonly="true" hidden value=""/>
                                <input id="end-time" name="end_time" type="text" readonly="true" hidden value=""/>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>地点</span>
                            <div>
                                <a href="#choosePlace">
                                    <span class="color_gray">请选择</span>
                                    <i class="iconfont r_con">&#xe605;</i>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="date_des">
                <h3 class="commontitle inner">总费用</h3>
                <div class="con">
                    <ul class="outerblock">
                        <li>
                            <div class="date_time flex flex_justify">
                                <span>共<i id="lasth" class="color_y">0</i>小时</span>
                                <div>
                                    <span>合计：<i id="total_money" class="lagernum color_y">0</i><i class="color_y">美币</i></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="date_time  flex flex_justify">
                                <span>预约金</span>
                                <div>
                                    <span id="order_money_str">0美币</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="commontips mt10 inner">* 预约金是您对对方的许诺,占总费用的20%;若对方同意后，您爽单，则预约金归对方所有；若对方不同意，则预约金全数退还。</p>
            </div>
            <div class="date_des mt20">
                <h3 class="commontitle inner">支付方式</h3>
                <div class="con">
                    <div class="date_time  flex flex_justify">
                        <span>我的钱包</span>
                        <div class="color_y"><?= $user->money ?> 美币</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height:1.4rem;"></div>
    <div class="bottomblock">
        <div class="flex flex_end">
            <span class="total">预约金：<i class="color_y">￥</i> <span class="color_y"><i id="order_money" class="color_y lagernum">0</i>美币</span></span>
            <a href="javascript:void(0);" class="nowpay">立即支付</a>
        </div>
        <!--日期时间选择器-->
        <?= $this->element('checkdate'); ?>
    </div>
</div>
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
<div class="wraper fullscreen page" id="page-placeDetail" hidden>
    <iframe src="" width="100%" height="100%"></iframe>
    <div style="height:63px;"></div>
    <a id="go-here" href="#this" class="identify_footer_potion">就去这</a>
</div>
<?php $this->start('script'); ?>
<script>
//日期选择回调函数
function choosedateCallBack(start_datetime, end_datetime) {
    var lasth = new Date(end_datetime).getHours() - new Date(start_datetime).getHours();
    $('#lasth').html(lasth);
    var price = <?= $data->cost->money ?>;
    $('#total_money').html(lasth * price);
    $('#order_money_str').html(lasth * price + 'x20%=' + lasth * price * 0.2 + '美币');
    $('#order_money').html(lasth * price * 0.2);
    var time_tmpstart = (start_datetime).split(" ");
    var time_tmpend = (end_datetime).split(" ");
    var year_month_date = time_tmpstart[0];
    var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
    var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
    $("#time").val(year_month_date + " " + start_hour_second + "~" + end_hour_second);
    $("#start-time").val(start_datetime);
    $("#end-time").val(end_datetime);

}
var place_name,coord_lng,coord_lat;
$(document).on('click','.place_link',function(){
    //点击查看详情页
   $.util.showPreloader('加载中...');
   var uid = $(this).data('uid');
   $('#go-here').data('name',$(this).data('name'));
   $('#go-here').data('coordlng',$(this).data('coordlng'));
   $('#go-here').data('coordlat',$(this).data('coordlat'));
   setTimeout(function(){
       location.hash = '#placeDetail';
       $.util.hidePreloader();
   },300);
   
   $('#page-placeDetail').find('iframe').remove();
   $('#page-placeDetail').prepend('<iframe width="100%" height="100%"></iframe>');
   $('#page-placeDetail').find('iframe').attr('src','http://map.baidu.com/mobile/webapp/search/search/qt=inf&uid='+uid+'/?third_party=uri_api');
});
$("#datetime").on('click', function () {
    new mydateTimePicker().show(choosedateCallBack);
});

var curpage = 1;
$(window).on('hashchange', function () {
    //页面切换
    if (location.hash == '#choosePlace') {
        curpage = 1;
        loadHashPage();
        $.util.asyLoadData({gurl: '/date-order/find-place/', page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'});
        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('place-list', function () {
                    //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                    $.util.asyLoadData({gurl: '/date-order/find-place/', page: curpage,
                        tpl: '#place-list-tpl', id: '#place-list', more: true, key: 'places'});
                })
            });
        }, 2000)
    } else {
        if(location.hash == '#placeDetail'){
            setTimeout(function(){
                 loadHashPage();
            },1000);
        }else{
             loadHashPage();
        }
    }
});
function loadHashPage() {
    var hash = location.hash;
    var page = '#page-' + hash.substr(1);
    if ($(page).length) {
        $('div[id^="page-"]').hide();
        $(page).show();
    } else {
        $('div[id^="page-"]').hide();
        $('.page-current').show();
    }
}
$('#go-here').on('tap',function(){
    place_name = $(this).data('name');
    coord_lng = $(this).data('coordlng');
    coord_lat = $(this).data('coordlat');
});
</script>
<?php $this->end('script'); ?>