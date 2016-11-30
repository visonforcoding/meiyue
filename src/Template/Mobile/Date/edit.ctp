<!-- 添加约会主界面 -->
<div class="wraper page-current" id="page-Date">
    <header>
        <div class="header">
            <span class="l_btn cancel-btn">取消</span>
            <span class="r_btn release-btn" date-id="<?= $date['id']?>">重新发布</span>
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
                                value="<?= $date['user_skill']['skill']['name'] ?>"
                                readonly="true"/>
                            <input
                                id="skill-id-input"
                                name="user_skill_id"
                                type="text"
                                value="<?= $date['user_skill']['id']; ?>"
                                hidden="true"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input type="text" name="title" value="<?= $date['title'] ?>"/>
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
                                value="<?= getFormateDT($date['start_time'], $date['end_time']) ?>"
                                readonly />
                            <input
                                id="start-time"
                                type="text"
                                name="start_time"
                                value="<?= $date['start_time'] ?>"
                                hidden/>
                            <input
                                id="end-time"
                                type="text"
                                name="end_time"
                                value="<?= $date['end_time'] ?>"
                                hidden/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会地点</h3>
                        <div class="edit_r_con">
                            <input
                                id="thePlace"
                                name="site"
                                type="text"
                                readonly="true"
                                placeholder="选择约会地点"
                                onclick="window.location.href='#choosePlace'"
                                value="<?= $date['site']; ?>"/>
                            <input
                                id="site_lat"
                                name="site_lat"
                                type="text"
                                value="<?= $date['site_lat']; ?>"
                                hidden/>
                            <input
                                id="site_lng"
                                name="site_lng"
                                type="text"
                                value="<?= $date['site_lng']; ?>"
                                hidden/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input
                                type="text"
                                value="<?= $date['user_skill']['cost']['money']?> 美币/小时"
                                readonly/>
                            <input
                                type="number"
                                name="price"
                                value="<?= $date['user_skill']['cost']['money']?>"
                                readonly/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40">
                <li>
                    <div class="edit_date_items flex flex_justify marks_edit">
                        <span class="edit_l_con">个人标签</span>
                        <div class="edit_r_con edit_r_marks" id="tag-container">
                            <?php foreach ($date['tags'] as $item): ?>
                                <a class="mark"><?= $item['name']?>
                                    <input
                                        type="text"
                                        name='tags[_ids][]'
                                        value="<?= $item['id']?>"
                                        tag-name="<?= $item['name']?>"
                                        hidden/>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="mt40 inner edit_date_desc">
                <h3 class="title">约会说明</h3>
                <div class="text_con">
                    <textarea name="description" ><?= $date['description']; ?></textarea>
                </div>
            </div>
            <input type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input type="text" name="status" value="2" hidden>
        </form>
    </div>
    <div class="inner">
        <a class="btn btn_cancely mt60 mb60 delete-btn">删除</a>
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
<!-- 地址详情 -->
<div class="wraper fullscreen page" id="page-placeDetail" hidden>
    <iframe src="" width="100%" height="100%"></iframe>
    <div style="height:63px;"></div>
    <a id="go-here" href="#this" class="identify_footer_potion">就去这</a>
</div>


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
                <a
                    data-name="{{name}}"
                    data-coordlng="{{location.lng}}"
                    data-coordlat="{{location.lat}}"
                    data-uid="{{uid}}" class="place_link" >查看详情</a>
                </span>
                <span
                    class="con_price color_y">￥ <i class="lagernum">{{detail_info.price}}</i> /人
                </span>
            </div>
        </div>
    </li>
    {{/places}}
</script>

<script src="/mobile/js/mustache.min.js"></script>
<script>

    $(".cancel-btn").on('click', function () {

        history.back();

    });

    //约会主题选择回调函数
    function chooseSkillCallBack(userSkill) {

        $("#skill-id-input").val(userSkill['id']);
        $("#show-skill-name").val(userSkill['skill_name']);
        $('#cost-btn').val(userSkill['cost'] + " 美币/小时");
        $('#cost-input').val(userSkill['cost']);

    }

    $("#show-skill-name").on('click', function () {
        new skillsPicker().show(chooseSkillCallBack);
    });


    //标签选择回调函数
    function chooseTagsCallBack(tagsData) {
        var html = "";
        for(key in tagsData) {
            var item = tagsData[key];
            html += "<a class='mark'>" + item['name'] +
                "<input type='text' name='tags[_ids][]' value='" + item['id']
                + "' tag-name='"+ item['name'] +"' hidden></a>";
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


    //日期选择回调函数
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


    var dPicker = new mydateTimePicker();
    dPicker.init(choosedateCallBack);
    $("#time").on('click', function () {
        dPicker.show();
    });


    $(".release-btn").on('click', function () {

        //验证开始日期
        var start_time = new Date($("#start-time").val());
        var current_time = new Date();
        if(Date.parse(start_time) < Date.parse(current_time)) {
            $.util.alert("约会时间不能早于当前时间!");
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/date/edit/' + $(this).attr('date-id'),
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {
                        alert(res.msg);
                        window.location.href = '/date/index';
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });

    })


    $(".delete-btn").on('click', function () {

        if(confirm("确定删除?")) {
            $.ajax({
                type: 'POST',
                url: '/date/delete/' + <?= $date['id']?>,
                dataType: 'json',
                success: function (res) {
                    if (typeof res === 'object') {
                        if (res.status) {
                            $.util.alert(res.msg);
                            history.back();
                        } else {
                            $.util.alert(res.msg);
                        }
                    }
                }
            });
        }

    })

    var place_name,coord_lng,coord_lat;
    $(document).on('tap','.place_link',function(){
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


    var curpage = 1;
    $(window).on('hashchange', function () {
        //页面切换
        if (location.hash == '#choosePlace') {
            curpage = 1;
            loadHashPage();
            $.util.asyLoadData({
                gurl: '/date-order/find-place/',
                page: curpage,
                tpl: '#place-list-tpl',
                id: '#place-list',
                key: 'places'
            });
            setTimeout(function () {
                $(window).on("scroll", function () {
                    $.util.listScroll('place-list', function () {
                        //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                        $.util.asyLoadData({
                            gurl: '/date-order/find-place/',
                            page: curpage,
                            tpl: '#place-list-tpl',
                            id: '#place-list',
                            more: true,
                            key: 'places'
                        });
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
        //选择好地址
        place_name = $(this).data('name');
        coord_lng = $(this).data('coordlng');
        coord_lat = $(this).data('coordlat');
        $('#thePlace').val(place_name);
        $('#site_lat').val(coord_lat);
        $('#site_lng').val(coord_lng);
    });

    LEMON.event.unrefresh();
    LEMON.sys.setTopRight('重新发布')
    window.onTopRight = function () {
        $(".release-btn").trigger('click');
    }
</script>