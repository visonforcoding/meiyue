<?php
$date_action = '/date/get-all-dates-in-page/';  //定义约会请求地址
$activity_action = '/activity/get-all-dates-in-page/';  //定义派对请求地址
?>

<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="date-list-tpl" type="text/html">
    {{#datas}}
    <div class="date_detail_place inner {{^is_first}}mt20{{/is_first}}" onclick="window.location.href = '/date-order/join/{{id}}'">
        <h3 class="title"><i class="itemsname color_y">[{{user_skill.skill.name}}]</i> {{description}}</h3>
        <div class="place_pic">
								<span class="place">
									<img src="/mobile/images/date_place.jpg"/>
								</span>
            <div class="place_info">
                <h3 class="userinfo">{{user.nick}} <span>{{user.age}}岁</span> <em class="price color_y fr"><i class="lagernum">{{user_skill.cost.money}}</i>元/约会金</em>
                </h3>
                <h3 class="otherinfo">
                    <time class="color_gray"><i class="iconfont">&#xe622;</i> {{time}}</time>
                    <address class="color_gray"><i class="iconfont">&#xe623;</i>{{site}}</address>
                </h3>
            </div>
        </div>
    </div>
    {{/datas}}
</script>

<script id="activity-list-tpl" type="text/html">
    {{#datas}}
    <div class="items">
        <div class="items_pic">
            <img src="/mobile/css/icon/party1.jpg"/>
        </div>
        <div class="items_con">
            <h3 class="items_title">{{title}}</h3>
            <div class="items_time flex flex_justify mt20">
                <div>{{ad}}</div>
                <div>
                    <i class="iconfont ico">&#xe64b;</i>
                    {{time}}
                </div>
            </div>
        </div>
        <div class="items_adress flex flex_justify">
            <div><i class="iconfont ico">&#xe623;</i>{{site}}</div>
            <div class="button btn_dark" onclick="window.location.href='/activity/view/{{id}}'">
                我要报名
            </div>
        </div>
    </div>
    {{/datas}}
</script>

<?php $this->end('static') ?>

<div class="wraper pd45">
    <div class="activity_list">
        <div class="date_list">
            <div class="date_list_header" id="imgTab">
                <div id="tab-1" class="alldate cur" contain-id="date-list" tab-action="<?= $date_action; ?>"
                     tpl-id="date-list-tpl"><span class="headertab">约会</span></div>
                |
                <div id="tab-2" class="todate" contain-id="party-list" tab-action="<?= $activity_action; ?>"
                     tpl-id="activity-list-tpl"><span class="headertab">派对</span></div>
                |
                <div id="tab-3" class="todate" contain-id="" tab-action="" tpl-id="top-list-tpl"><span
                        class="headertab">头牌</span></div>
            </div>
        </div>
        <div class="activity_list_con" id='imgBox'>
            <!--活动-->
            <section>
                <!-- 约会列表 -->
                <div id="date-list"></div>
            </section>

            <!--派对-->
            <section>
                <!--轮播图-->
                <div id="party-coverimg" class="abanner">
                    &nbsp;
                </div>
                <div id="party-list" class="party_content">
                    <!-- 派对列表 -->
                </div>
            </section>
            <!--头牌-->
            <section>
                <div class="cover_image">
                    <img src="/mobile/images/cover.jpg" alt=""/>
                    <a href="#this" class="more"><img src="/mobile/images/more.png"/></a>
                </div>
                <div class="invite">
                    <a href="#this" class="btn btn_t_border">邀请好友支持我</a>
                </div>
                <div class="cover_bottom_header mt20">
                    <img src="/mobile/images/tp.jpg"/>
                </div>
                <div class="rank_list">
                    <ul class="rank_header">
                        <li><span>周榜</span></li>
                        <li><span>月榜</span></li>
                        <li class="current"><span>土豪榜</span></li>
                    </ul>
                    <div class="rank_con">
                        <ul class="inner outerblock">
                            <li class="flex flex_justify">
                                <div class="flex">
                                    <span class="place silver">1</span>
                                    <div class="place_info">
                                        <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
                                        <h3>
                                            <span class="place_name"><i class="name">范冰冰</i> <i class="vip">VIP 5</i><i
                                                    class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                                            <span class="place_number color_gray"><em class="color_y"><i
                                                        class="iconfont color_y">&#xe61d;</i> 23</em>
														本周魅力值：<i class="color_y">255554222</i>
													</span>
                                        </h3>
                                    </div>
                                </div>
                                <span class="button btn_dark">支持她</span>
                            </li>
                            <li class="flex flex_justify">
                                <div class="flex">
                                    <span class="place silver">2</span>
                                    <div class="place_info">
                                        <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
                                        <h3>
                                            <span class="place_name"><i class="name">范冰冰</i> <i class="vip">VIP 5</i><i
                                                    class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                                            <span class="place_number color_gray"><em class="color_y"><i
                                                        class="iconfont color_y">&#xe61d;</i> 23</em>
														本周魅力值：<i class="color_y">255554222</i>
													</span>
                                        </h3>
                                    </div>
                                </div>
                                <span class="button btn_dark">支持她</span>
                            </li>
                            <li class="flex flex_justify">
                                <div class="flex">
                                    <span class="place silver">3</span>
                                    <div class="place_info">
                                        <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
                                        <h3>
                                            <span class="place_name"><i class="name">范冰冰</i> <i class="vip">VIP 3</i><i
                                                    class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                                            <span class="place_number color_gray"><em class="color_y"><i
                                                        class="iconfont color_y">&#xe61d;</i> 23</em>
														本周魅力值：<i class="color_y">255554222</i>
													</span>
                                        </h3>
                                    </div>
                                </div>
                                <span class="button btn_dark">支持她</span>
                            </li>
                            <li class="flex flex_justify">
                                <div class="flex">
                                    <span class="place">4</span>
                                    <div class="place_info">
                                        <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
                                        <h3>
                                            <span class="place_name"><i class="name">范冰冰</i> <i class="vip">VIP 3</i><i
                                                    class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                                            <span class="place_number color_gray"><em class="color_y"><i
                                                        class="iconfont color_y">&#xe61d;</i> 23</em>
														本周魅力值：<i class="color_y">255554222</i>
													</span>
                                        </h3>
                                    </div>
                                </div>
                                <span class="button btn_bg_active">支持她</span>
                            </li>
                            <li class="flex flex_justify">
                                <div class="flex">
                                    <span class="place">5</span>
                                    <div class="place_info">
                                        <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
                                        <h3>
                                            <span class="place_name"><i class="name">范冰冰</i> <i class="vip">VIP 1</i><i
                                                    class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                                            <span class="place_number color_gray"><em class="color_y"><i
                                                        class="iconfont color_y">&#xe61d;</i> 23</em>
														本周魅力值：<i class="color_y">255554222</i>
													</span>
                                        </h3>
                                    </div>
                                </div>
                                <span class="button btn_dark">支持她</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!--底部-->
<?= $this->element('footer', ['active' => 'activity']) ?>

<script src="/mobile/js/loopScroll.js" type="text/javascript" charset="utf-8"></script>
<script>

    var activity = function (o) {

        this.opt = {
            tab_date: 1,
            tab_activity: 2,
            tab_top: 3,
            current_tab: 1,  //记录当前显示的tab
            tab1_is_first: true,  //标记tab1是否是第一次加载
            tab2_is_first: true,  //标记tab2是否是第一次加载
            tab3_is_first: true,  //标记tab3是否是第一次加载
            date_curpage: 1,   //记录约会当前页
            party_curpage: 1,  //记录派对当前页
            top_curpage: 1,    //记录封面女神当前页
            activity_curpage: 1,
            currentlist_tpl: '',
            currentlist_container: '',
            current_action: '',
        }
        $.extend(this, this.opt, o);

    }

    $.extend(activity.prototype, {

        init: function () {


        },

        asyLoadData: function (curtab, opt) {
            $.util.showPreloader();
            var gurl = opt.gurl;
            var template = $(opt.tpl).html();
            Mustache.parse(template);   // optional, speeds up future uses
            url = gurl;
            switch (curtab) {
                case this.tab_date:
                    url = url + this.date_curpage;
                    break;
                case this.tab_activity:
                    url = url + this.party_curpage;
                    break;
                case this.tab_top:
                    url = url + this.top_curpage;
                    break;
            }

            var obj = this;
            $.getJSON(url, function (data) {
                if (opt['func']) {
                    data = opt['func'](data);
                }
                window.holdLoad = false;
                $.util.hidePreloader();
                if (data.code === 200) {
                    var rendered = Mustache.render(template, data);
                    if (!data[opt.key].length) {
                        window.holdLoad = true;
                    } else {
                        switch (curtab) {

                            case obj.tab_date:
                                obj.date_curpage++;
                                break;
                            case obj.tab_activity:
                                obj.party_curpage++;
                                break;
                            case obj.tab_top:
                                obj.top_curpage++;
                                break;

                        }
                    }

                    switch (curtab) {

                        case obj.tab_date:
                            if (!obj.tab1_is_first) {
                                $(opt.id).append(rendered);
                            } else {
                                $(opt.id).html(rendered);
                                obj.tab1_flag = true;
                            }
                            break;
                        case obj.tab_activity:
                            if (!obj.tab2_is_first) {
                                $(opt.id).append(rendered);
                            } else {
                                $(opt.id).html(rendered);
                                obj.tab2_flag = true;
                            }
                            break;
                        case obj.tab_top:
                            if (!obj.tab3_is_first) {
                                $(opt.id).append(rendered);
                            } else {
                                $(opt.id).html(rendered);
                                obj.tab3_flag = true;
                            }
                            break;
                    }

                }
            });
        },

    });

    var activityobj = new activity();

    function calFunc(data) {

        console.log(data.datas);
        //返回格式化回调
        if(data.datas) {

            $.each(data.datas, function (i, n) {

                if (!i) {

                    data.datas[i]['is_first'] = true;

                } else {

                    data.datas[i]['is_first'] = false;

                }

            });

        }
        return data;
    }


    var loop = $.util.loop({
        tp: 'text', //图片img或是文字text
        //min : 5,
        loadImg: true,
        isInit:true,
        moveDom: $('#imgBox'), // eg: $('#loopImgUl')
        moveChild: $('#imgBox section'), //$('#loopImgUl li')
        tab: $('#imgTab div'), //$('#loopImgBar li')
        loopScroll: false,
        autoTime: 0,
        lockScrY: true,
        //imgInitLazy: 1000,
        index: 1,
        viewDom: $('.activity_list'),
        fun: function (index) {

            index = parseInt(index);
            if(activityobj.current_tab == index && !this.isInit) {
                return;
            }
            window.scrollTo(0,0);
            this.isInit = false;
            var action = $('#tab-' + index).attr('tab-action');
            activityobj.currentlist_tpl = $('#tab-' + index).attr('tpl-id');
            activityobj.currentlist_container = $('#tab-' + index).attr('contain-id');
            activityobj.current_action = action;

            switch (index) {
                case 1:
                    activityobj.current_tab = activityobj.tab_date;
                    if(activityobj.tab1_is_first) {

                        //首次加载数据
                        activityobj.asyLoadData(activityobj.tab_date, {
                            key: 'datas',
                            gurl: activityobj.current_action,
                            tpl: '#' + activityobj.currentlist_tpl,
                            id: '#' + activityobj.currentlist_container,
                            func: calFunc
                        });
                        activityobj.tab1_is_first = false;

                    }
                    break;
                case 2:
                    activityobj.current_tab = activityobj.tab_activity;
                    if (activityobj.tab2_is_first) {
                        activityobj.asyLoadData(activityobj.tab_activity, {
                            key: 'datas',
                            gurl: activityobj.current_action,
                            tpl: '#' + activityobj.currentlist_tpl,
                            id: '#' + activityobj.currentlist_container,
                            func: calFunc
                        });
                        $('#party-coverimg').html("<img src='/mobile/css/icon/banner1.jpg'/>");
                        activityobj.tab2_is_first = false;
                    }
                    break;
                case 3:
                    activityobj.current_tab = activityobj.tab_top;
                    if(activityobj.tab3_is_first) {
                        /*activityobj.asyLoadData(activityobj.tab_top, {
                            key: 'datas',
                            gurl: activityobj.current_action,
                            tpl: '#' + activityobj.currentlist_tpl,
                            id: '#' + activityobj.currentlist_container,
                            func: calFunc
                        });*/
                        activityobj.tab3_is_first = false;
                    }
                    break;
            }

        }
    });


    setTimeout(function () {

        //滚动加载
        $(window).on("scroll", function () {

            console.log(activityobj.current_tab);
            switch (activityobj.current_tab) {
                case activityobj.tab_date:
                    break;
                case activityobj.tab_activity:
                    if (activityobj.tab2_is_first) {

                        $('#party-coverimg').html("<img src='/mobile/css/icon/banner1.jpg'/>");
                        tab1_is_first = false;

                    }
                    break;
                case activityobj.tab_top:
                    break;
            }
            $.util.listScroll(activityobj.currentlist_container, function () {
                //activity.asyLoadData(activityobj.current_tab, {gurl: activityobj.current_action, tpl: activityobj.currentlist_tpl, id: activityobj.currentlist_container, func: calFunc});
            })

        });
    }, 2000);

</script>