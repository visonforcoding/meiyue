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
    <li data-name="{{name}}" data-coordlng="{{location.lng}}" data-coordlat="{{location.lat}}" data-uid="{{uid}}" onclick="placeInfo(this)">
        <div class="items-block flex flex_justify">
            <div class="l_left flex  maxwid68" data-type='0' onclick="choosePlace(this)">
                <span class="radio-btn iconfont">&#xe635;</span>
                <h3 class="place-choose-text">
                    <div class="place_name">{{name}}</div>
                    <div class="color_gray place_address">{{address}}</div>
                    <div class="commend">
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i>
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_gray iconfont">&#xe62a;</i>
                    </div>
                </h3>
            </div>
            <div class="l_right aligncenter">
                <span class="con_price color_y">￥ <i class="lagernum">{{detail_info.price}}</i> /人</span>
                <a class="button btn_dark con_detail place_link" href="#placeDetail">查看详情</a>
            </div>
        </div>
    </li>
    {{/places}}
</script>
<?php $this->end('static') ?>
<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1>约会详情</h1>
        <span class="r_btn">编辑</span>
    </div>
</header>-->

<!-- 主view -->
<div class="wraper page-current" id="page-orderSkill">
    <div class="find_date_detail">
        <div class="date_top_con flex inner">
            <span class="place"><img src="<?= createImg($data->user->avatar) . '?w=88' ?>"/></span>
            <h3 class="date_top_con_right">
                <span class="date_ability">[<?= $data->skill->name ?>]</span>
                <span class="date_guest"><?= $data->user->nick ?> <i class="iconfont color_y">&#xe61d;</i><i class="age color_y"><?= isset($data->user->birthday) ? getAge($data->user->birthday) : 'xx' ?></i></span>
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
                <?php if(count($data->tags)): ?>
                <li class="flex">
                    <h3 class="commontitle">我的标签</h3>
                    <div class="con con_mark flex maxwid80">
                        <?php foreach ($data->tags as $tag): ?>
                            <a href="#this"><?= $tag->name ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <?php endif; ?>
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
                                <a id="showChoosePlace" href="#choosePlace">
                                    <input id="thePlace" class="alignright" placeholder='请选择' readonly value="" />
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
</div>


<!-- 地点列表  选择、填写区 -->
<div class="wraper page" id="page-choosePlace" hidden>
    <div id="selfPlace" class='aPlace' hidden>
        <div class="place-self">
            <h3 class="basic_info_integrity">没有合适地点，<a href="javascript:toListplace();" class="color_y">回到搜索地址</a></h3>
            <div class="search_place_header inner">
                <div class="search-box flex flex_justify">
                    <div class="search-btn">
                        <input type="text" id="selfInput" value="" placeholder="请输入约会地点" results="5" />
                    </div>
                    <span class="cancel-btn color_y" onclick='submitSelfPlace()'>提交</span>
                </div>

            </div>
        </div>
    </div>
    <div id="listPlace" class='aPlace'>
        <h3 class="basic_info_integrity">没有合适地点，<a href="javascript:toSelfplace();" class="color_y">手动输入地址</a></h3>
        <div class="search_place_header inner">
            <form action="">
                <div class="search-box flex flex_justify">
                    <div class="search-btn">
                        <i class="iconfont ico">&#xe689;</i><input type="text" placeholder="请输入约会地点" results="5" />
                    </div>
                    <span class="cancel-btn color_y">搜索</span>
                </div>
            </form>
        </div>
        <div class="place_filter_tab" hidden>
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
            <ul id="place-list" class="outerblock"></ul>
        </div>
    </div>
</div>


<!-- 地点详情 -->
<div class="wraper fullscreen page" id="page-placeDetail" hidden>
    <iframe src="" width="100%" height="100%"></iframe>
    <div style="height:63px;"></div>
    <span id="go-here"  class="identify_footer_potion">就去这</span>
</div>
<?php $this->start('script'); ?>
<script>
    location.hash = '';
    //日期选择回调函数
    var skill_id = <?= $data->skill_id ?>;
    var lasth, start_time, end_time;
    var place_name, coord_lng, coord_lat, place_uid;
    function choosedateCallBack(start_datetime, end_datetime, last_time) {
        start_time = start_datetime;
        end_time = end_datetime;
        lasth = last_time;
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

    function placeInfo(em) {
        //点击查看详情页
        place_uid = $(em).data('uid');
        place_name = $(em).data('name');
        coord_lng = $(em).data('coordlng');
        coord_lat = $(em).data('coordlat');
    }
    
    function choosePlace(em) {
        $(em).addClass('choose');
        setTimeout(function () {
            $('#thePlace').val(place_name);
            location.hash = '';
        }, 300);
    }

    function toListplace() {
        $('#listPlace').show();
        $('#selfPlace').hide();
    }
    function submitSelfPlace() {
        if ($('#selfInput').val() == '') {
            $.util.alert('请输入地址');
            return;
        }
        $('#thePlace').val($('#selfInput').val());
        place_name = $('#selfInput').val();
        location.hash = '';
    }
    function toSelfplace() {
        $('#selfPlace').show();
        $('#listPlace').hide();
    }

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
        }
        else if (location.hash == '#placeDetail') {
            $.util.showPreloader('加载中...');
            $('#page-placeDetail').find('iframe').remove();
            $('#page-placeDetail').prepend('<iframe width="100%" height="100%"></iframe>');
            setTimeout(function () {
                $('#page-placeDetail').find('iframe').attr('src', 'http://map.baidu.com/mobile/webapp/search/search/qt=inf&uid=' + place_uid + '/?third_party=uri_api');
            }, 30);

            setTimeout(function () {
                $.util.hidePreloader();
                loadHashPage();
            }, 1000);
        }
        else {
            loadHashPage();
        }
    });

    //显示当前view
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
        $('#thePlace').val(place_name);
        location.hash = '';
        $('#page-placeDetail').find('iframe').remove();
    });
    $('#order_create').on('tap', function () {
        //生成订单
        if($.util.isWX){
            $.util.confirm('提示信息','为保障约会顺利安全，必须下载app才能约她',function(){
                document.location.href =  '/down-app';
            },null,'残忍拒绝','立即下载');
            return;
        }
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