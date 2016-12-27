<?php

use Cake\I18n\Time;

?>
<!-- 添加约会主界面 -->
<div class="wraper page-current" id="page-Date">
    <header>
        <div class="header">
            <span class="l_btn" id="cancel-btn" onclick="history.back();">取消</span>
            <span class="r_btn" id="release-btn">发布</span>
        </div>
    </header>
    <div class="edit_date_box">
        <form>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会主题</h3>
                        <div class="edit_r_con">
                            <input
                                id="show-skill-name"
                                type="text"
                                placeholder="请选择约会主题"
                                value=""
                                readonly="true"/>
                            <input
                                id="skill-id-input"
                                name="user_skill_id"
                                type="text"
                                placeholder="请选择约会主题"
                                value=""
                                hidden="true"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input
                                id="title"
                                name='title'
                                type="text"
                                value=""
                                placeholder="例：海岸城西餐厅，美女在等你"/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会时间</h3>
                        <div class="edit_r_con">
                            <input
                                id="time"
                                type="text"
                                readonly="true"
                                value=""
                                placeholder="请选择约会时间"/>
                            <input
                                id="start-time"
                                name="start_time"
                                type="text"
                                readonly="true"
                                hidden value=""/>
                            <input
                                id="end-time"
                                name="end_time"
                                type="text"
                                readonly="true"
                                hidden value=""/>
                        </div>
                    </div>
                </li>
                <li onclick="location.hash = '#choosePlace'">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会地点</h3>
                        <div class="edit_r_con">
                            <input
                                id="thePlace"
                                name="site"
                                type="text"
                                readonly="true"
                                placeholder="选择约会地点"
                                value=""/>
                            <input
                                id="site_lat"
                                name="site_lat"
                                type="text"
                                value=""
                                hidden/>
                            <input
                                id="site_lng"
                                name="site_lng"
                                type="text"
                                value=""
                                hidden/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input
                                id="cost-btn"
                                type="text"
                                readonly="true"
                                placeholder="无需手动填写"
                                value=""/>
                            <input
                                id="cost-input"
                                name="price"
                                type="number"
                                readonly="true"
                                value=""
                                hidden/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="outerblock mt40">
                <li>
                    <div class="edit_date_items flex flex_justify marks_edit">
                        <span class="edit_l_con">个人标签</span>
                        <div class="edit_r_con edit_r_marks" id="tag-container">
                            <!--标签容器-->
                        </div>
                    </div>
                </li>
            </ul>
            <div class="mt40 inner edit_date_desc">
                <h3 class="title">约会说明</h3>
                <div class="text_con">
                    <textarea
                        id="description"
                        name="description"
                        placeholder="您的说明将是屌丝买单的动力"></textarea>
                </div>
            </div>
            <input id="user-id" type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input id="status" type="text" name="status" value="2" hidden>
        </form>
    </div>

    <!--弹出层-->
    <!--技能选择框-->
    <?= $this->cell('Date::skillsView', ['user_id' => $user->id]); ?>
    <!--价格选择框-->
    <?= $this->cell('Date::costsView'); ?>
    <!--标签选择框-->
    <?= $this->cell('Date::tagsView'); ?>
    <!--日期时间选择器-->
    <?= $this->element('checkdate'); ?>
</div>

<!-- 地址列表 -->
<div class="wraper page" id="page-choosePlace" hidden>
    <div id="selfPlace" class='aPlace' hidden>
        <div class="place-self">
            <h3 class="basic_info_integrity">没有合适地点，<a href="javascript:toListplace();" class="color_y">回到搜索地址</a></h3>
            <div class="search_place_header inner">
                <div class="search-box flex flex_justify">
                    <div class="search-btn">
                        <input type="text" id="selfInput" value="" placeholder="请输入约会地点" results="5"/>
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
                        <i class="iconfont ico">&#xe689;</i><input type="text" placeholder="请输入约会地点" results="5"/>
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
<!-- 地址详情 -->
<div class="wraper fullscreen page" id="page-placeDetail" hidden>
    <iframe src="" width="100%" height="100%"></iframe>
    <div style="height:63px;"></div>
    <a id="go-here" href="#this" class="identify_footer_potion">就去这</a>
</div>


<script id="place-list-tpl" type="text/html">
    {{#places}}
    <li data-name="{{name}}" data-coordlng="{{location.lng}}" data-coordlat="{{location.lat}}" data-uid="{{uid}}"
        onclick="placeInfo(this)">
        <div class="items-block flex flex_justify">
            <div class="l_left flex  maxwid68" data-type='0' onclick="choosePlace(this)">
                <span class="radio-btn iconfont">&#xe635;</span>
                <h3 class="place-choose-text">
                    <div class="place_name">{{name}}</div>
                    <div class="color_gray place_address">{{address}}</div>
                    <div class="commend">
                        <i class="color_y iconfont">&#xe62a;</i><i class="color_y iconfont">&#xe62a;</i><i
                            class="color_y iconfont">&#xe62a;</i>
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

<script src="/mobile/js/mustache.min.js"></script>
<script>
    var skill_id = '';
    //约会主题选择回调函数
    function chooseSkillCallBack(userSkill) {
        $("#skill-id-input").val(userSkill['id']);
        $("#show-skill-name").val(userSkill['skill_name']);
        $('#cost-btn').val(userSkill['cost'] + " 美币/小时");
        $('#cost-input').val(userSkill['cost']);
        skill_id = userSkill['skill_id'];
    }

    $("#show-skill-name").on('click', function () {
        new skillsPicker().show(chooseSkillCallBack);
    });

    //标签选择回调函数----------------------------------------------------------------
    function chooseTagsCallBack(tagsData) {
        var html = "";
        for (key in tagsData) {
            var item = tagsData[key];
            html += "<a class='mark'>" + item['name'] +
                "<input type='text' name='tags[_ids][]' value='" + item['id']
                + "' tag-name='" + item['name'] + "' hidden></a>";
        }
        $("#tag-container").html(html);
    }

    $("#tag-container").on('click', function () {
        var currentDatas = [];
        $("#tag-container").find("input").each(function () {
            currentDatas.push($(this).val());
        })
        new TagsPicker().show(chooseTagsCallBack, currentDatas);
    });


    //日期选择回调函数--------------------------------------------------------------
    var dPicker = new mydateTimePicker();
    function choosedateCallBack(start_datetime, end_datetime) {
        var start_datetime = start_datetime.replace(/\//g, '-');
        var end_datetime = end_datetime.replace(/\//g, '-');
        var time_tmpstart = (start_datetime).split(" ");
        var time_tmpend = (end_datetime).split(" ");
        var year_month_date = time_tmpstart[0];
        var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
        var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
        $("#time").val(year_month_date + " " + start_hour_second + "~" + end_hour_second);
        $("#start-time").val(start_datetime);
        $("#end-time").val(end_datetime);
    }
    dPicker.init(choosedateCallBack);
    $("#time").on('click', function () {
        dPicker.show();
    });


    $("#release-btn").on('click', function () {
        $date_time = $("#time").val();
        if (!$date_time) {
            $.util.alert("请选择约会时间!");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/date/add',
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {
                        $.util.alert(res.msg);
                        window.location.href = '/date/index';
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });
    });


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


    var curpage = 1;
    $(window).on('hashchange', function () {
        //页面切换
        if (location.hash == '#choosePlace') {
            if (!skill_id) {
                $.util.alert('请先选择约会主题');
                return;
            }
            curpage = 1;
            var gurl = '/date-order/find-place/' + skill_id + "/";
            loadHashPage();
            $.util.asyLoadData({gurl: gurl, page: curpage, tpl: '#place-list-tpl', id: '#place-list', key: 'places'});
            setTimeout(function () {
                $(window).on("scroll", function () {
                    $.util.listScroll('place-list', function () {
                        //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                        $.util.asyLoadData({
                            gurl: gurl, page: curpage,
                            tpl: '#place-list-tpl', id: '#place-list', more: true, key: 'places'
                        });
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

    function placeInfo(em) {
        //点击查看详情页
        place_uid = $(em).data('uid');
        place_name = $(em).data('name');
        coord_lng = $(em).data('coordlng');
        coord_lat = $(em).data('coordlat');
        console.log($(em));
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
        location.hash = '';
    }
    function toSelfplace() {
        $('#selfPlace').show();
        $('#listPlace').hide();
    }

    $('#go-here').on('tap', function () {
        //选择好地址
        place_name = $(this).data('name');
        coord_lng = $(this).data('coordlng');
        coord_lat = $(this).data('coordlat');
        $('#thePlace').val(place_name);
        $('#site_lat').val(coord_lat);
        $('#site_lng').val(coord_lng);
        location.hash = '';
    });

    LEMON.event.unrefresh();
    LEMON.sys.setTopRight('发布');
    window.onTopRight = function () {
        $("#release-btn").trigger('click');
    }
</script>