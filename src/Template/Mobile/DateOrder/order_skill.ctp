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
        <div class="items-block flex flex_justify">
            <div class="l_left flex  maxwid68" data-type='0'>
                <span class="radio-btn iconfont">&#xe635;</span>
                <h3 class="place-choose-text">
                    <div class="place_name">{{name}}</div>
                    <div class="color_gray place_address">{{address}}</div>
                    <div class="commend">
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i class="color_gray iconfont">&#xe62a;</i>
                    </div>
                </h3>
            </div>
            <div class="l_right aligncenter">
                <span class="con_price color_y">￥ <i class="lagernum">{{detail_info.price}}</i> /人</span>
                <a data-name="{{name}}" data-coordlng="{{location.lng}}" data-coordlat="{{location.lat}}" data-uid="{{uid}}" class="button btn_dark con_detail place_link">查看详情</a>
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
        <div class="date_des change-date-detail mt20">
            <ul class="outerblock bgff">
                <li>
                    <h3 class="commontitle pt10">约会说明</h3>
                    <div class="con date_keyword">
                        <p><?= $data->description ?></p>
                    </div>
                </li>
                <li class="flex">
                    <h3 class="commontitle">我的标签</h3>
                    <div class="con con_mark flex maxwid80">
                        <?php foreach ($data->tags as $tag): ?>
                            <a href="#this"><?= $tag->name ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
            </ul>
        </div>
        <div class="date_des mt20">
            <div class="con com_choose_time">
                <ul class="outerblock">
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>时间</span>
                            <div id="datetime">
<!--                                <span>09-28 21:00~22:00</span>
                                <i class="iconfont r_con">&#xe605;</i>-->
                                <input id="time" type="text" readonly="true"  value="" placeholder="请选择约会时间" class='alignright' />
                                <input id="start-time" name="start_time" type="text" readonly="true" hidden value=""/>
                                <input id="end-time" name="end_time" type="text" readonly="true" hidden value=""/>
                                 <i class="iconfont r_con">&#xe605;</i>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>地点</span>
                            <div>
                                <a id="showChoosePlace">
                                    <input id="thePlace" class="color_gray alignright" placeholder='请选择' />
                                    <i class="iconfont r_con">&#xe605;</i>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="date_des mt20">
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
            </div>
            <div class="date_des mt20">
                <div class="con inner">
                    <div class="date_time  flex flex_justify">
                        <span>我的钱包</span>
                        <div class="color_y"><?= $user->money ?> 美币</div>
                    </div>
                </div>
            </div>
            <p class="commontips mt10 inner">* 预约金是您对对方的许诺,占总费用的20%;若对方同意后，您爽单，则预约金归对方所有；若对方不同意，则预约金全数退还。</p>
        </div>
    </div>
    <div style="height:1.4rem;"></div>
    <div class="bottomblock">
        <div class="flex flex_end">
            <span class="total">预约金：<i class="color_y">￥</i> <span class="color_y"><i id="order_money" class="color_y lagernum">0</i>美币</span></span>
            <a id="order_create" class="nowpay">立即支付</a>
        </div>
        <!--日期时间选择器-->
        <?= $this->element('checkdate'); ?>
    </div>
    <div id="choosePlaceBox" class="raper" hidden>
        <div class="choose-date-place">
            <ul>
                <li><a href="#choosePlace">选择地点</a></li>
                <li><a href="#this">自定义地点</a></li>
            </ul>
            <ul class="mt20">
                <li class="cancel"><a href="#this">取消</a></li>
            </ul>
        </div>
    </div>
    <div class="pay-shadow" style="display: none;">
        <div class="pay-containner flex flex_center fullwraper">
            <div class="pay-containner-con">
                <div class="title">
                    <i class="iconfont closed">&#xe653;</i>
                    <h3>请设置与输入支付密码</h3>
                </div>
                <div class="con"><i>5000</i>美币</div>
                <div class="pay-footer">
                    <div class="pay-content">
                        <input type="tel" maxlength="6" class="pwd-input" id="pwd-input" unselectable="on" />
                        <div class="pwd-box flex flex_justify">
                            <input type="password" readonly="readonly"/>
                            <input type="password" readonly="readonly"/>
                            <input type="password" readonly="readonly"/>
                            <input type="password" readonly="readonly"/>
                            <input type="password" readonly="readonly"/>
                            <input type="password" readonly="readonly"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="wraper page" id="page-choosePlace" hidden>
    <div class="search_place_header inner">
        <form action="">
            <div class="search-box flex flex_justify">
                <div class="search-btn">
                    <i class="iconfont ico">&#xe689;</i><input type="search" placeholder="请输入约会地点" results="5" />
                </div>
                <span class="cancel-btn color_y">搜索</span>
            </div>
        </form>
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
    <div class="find_place_list" id="choosePlace">
        <ul id="place-list" class="outerblock">

        </ul>
    </div>
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
var skill_id = <?= $data->skill_id ?>;
var lasth, start_time, end_time;
function choosedateCallBack(start_datetime, end_datetime) {
    start_time = start_datetime;
    end_time = end_datetime;
    lasth = new Date(end_datetime).getHours() - new Date(start_datetime).getHours();
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
$('#showChoosePlace').on('tap', function () {
    //弹出选择地址层
    $('#choosePlaceBox').show();
})
var place_name, coord_lng, coord_lat;
$(document).on('tap', '.place_link', function () {
    //点击查看详情页
    $.util.showPreloader('加载中...');
    var uid = $(this).data('uid');
    $('#go-here').data('name', $(this).data('name'));
    $('#go-here').data('coordlng', $(this).data('coordlng'));
    $('#go-here').data('coordlat', $(this).data('coordlat'));
    setTimeout(function () {
        location.hash = '#placeDetail';
        $.util.hidePreloader();
    }, 300);

    $('#page-placeDetail').find('iframe').remove();
    $('#page-placeDetail').prepend('<iframe width="100%" height="100%"></iframe>');
    $('#page-placeDetail').find('iframe').attr('src', 'http://map.baidu.com/mobile/webapp/search/search/qt=inf&uid=' + uid + '/?third_party=uri_api');
});

var dPicker = new mydateTimePicker();
dPicker.init(choosedateCallBack);
$("#time").on('tap', function () {
    dPicker.show();
});

var curpage = 1;
var gurl = '/date-order/find-place/' + skill_id + '/';
$(window).on('hashchange', function () {
    //页面切换
    if (location.hash == '#choosePlace') {
        curpage = 1;
        $('#choosePlaceBox').hide();
        loadHashPage();
        $.util.asyLoadData({gurl: gurl, page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'});
        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('place-list', function () {
                    //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                    $.util.asyLoadData({gurl: gurl, page: curpage,
                        tpl: '#place-list-tpl', id: '#place-list', more: true, key: 'places'});
                })
            });
        }, 2000)
    } else {
        if (location.hash == '#placeDetail') {
            setTimeout(function () {
                loadHashPage();
            }, 1000);
        } else {
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
$('#go-here').on('tap', function () {
    //选择好地址
    place_name = $(this).data('name');
    coord_lng = $(this).data('coordlng');
    coord_lat = $(this).data('coordlat');
    $('#thePlace').html(place_name);
});
$('#order_create').on('tap', function () {
    //生成订单
    if ((!place_name)) {
        $.util.alert('请选择地点')
        return;
    }
    if ((!start_time)) {
        $.util.alert('请选择时间')
        return;
    }
    //预约支付
    var dom = $(this);
    if (dom.hasClass('disabled')) {
        return false;
    }
    dom.addClass('disabled');
    var user_skill_id = <?= $data->id ?>;
    var start_datetime = start_time.replace(/\//g, '-');
    var end_datetime = end_time.replace(/\//g, '-');
    var data = {
        user_skill_id: user_skill_id,
        place_name: place_name,
        coord_lng: coord_lng,
        coord_lat: coord_lat,
        start_time: start_datetime,
        end_time: end_datetime};
    $.util.ajax({
        url: '/date-order/order-skill-create-order',
        data: data,
        func: function (res) {
            if (res.status) {
                var order_id = res.order_id;
                $.util.confirm('确定支付？', '将扣除美币作为预约金', function () {
                    $.util.ajax({
                        url: '/date-order/order-pay/' + order_id,
                        func: function (resp) {
                            $.util.alert(resp.msg);
                            if (resp.status) {
                                //聊天框
                                $.util.openTalk(resp);
                            } else {
                                if (resp.code == '201') {
                                    //余额不足
                                    setTimeout(function () {
                                        window.location.href = resp.redirect_url;
                                    }, 300);
                                }
                            }
                        }
                    });
                })
            } else {
                dom.removeClass('disabled');
                if (res.code == '201') {
                    //余额不足
                    $.util.alert(res.msg);
                    setTimeout(function () {
                        window.location.href = res.redirect_url;
                    }, 300);
                }
            }
        }
    });
});

LEMON.event.unrefresh();
</script>
<?php $this->end('script'); ?>