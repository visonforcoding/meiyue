<?php
$date_action = '/date/get-all-dates-in-page/';  //定义约会请求地址
$activity_action = '/activity/index/';  //定义派对请求地址
?>

<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="date-list-tpl" type="text/html">
{{#datas}}
<div class="date_detail_place inner {{^is_first}}mt20{{/is_first}}"
     onclick="window.location.href = '/date-order/join/{{id}}'">
    <h3 class="title"><i class="itemsname color_y">[{{user_skill.skill.name}}]</i> {{description}}</h3>
    <div class="place_pic">
                            <span class="place">
                                <img src="/mobile/images/date_place.jpg"/>
                            </span>
        <div class="place_info">
            <h3 class="userinfo">{{user.nick}} <span>{{user.age}}岁</span> <em class="price color_y fr"><i
                        class="lagernum">{{user_skill.cost.money}}</i>元/约会金</em>
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

<script id="top-list-tpl" type="text/html">
{{#datas}}
<li class="flex flex_justify">
    <div class="flex">
        <span class="place silver">{{index}}</span>
        <div class="place_info">
            <span class="avatar"><img src="/mobile/images/avatar.jpg"></span>
            <h3>
                <span class="place_name"><i class="name">{{user.nick}}</i> <i class="vip">VIP 5</i><i
                        class="cup"><img src="/mobile/images/cup.jpg"/></i></span>
                <span class="place_number color_gray"><em class="color_y"><i
                            class="iconfont color_y">&#xe61d;</i> {{user.age}}</em>
                            本周魅力值：<i class="color_y">{{total}}</i>
                        </span>
            </h3>
        </div>
    </div>
    <span class="button btn_dark">支持她</span>
</li>
{{#ishead}}<div style="height:20px;background:#f4f4f4"></div>{{/ishead}}
{{/datas}}
</script>


<script id="rich-list-tpl" type="text/html">
{{#datas}}
<li>
    <div class="voted_con flex flex_justify">
        <div class="flex">
            <span class="voted_place silver">{{index}}</span>
            <div class="voted_place_info">
                <span class="avatar"><img src="{{buyer.avatar}}"/></span>
                <h3>
                    <span class="voted_name">{{buyer.nick}}</span>
                    <span class="voted_number color_gray">已消费：{{total}}美币</span>
                </h3>
            </div>
        </div>
        <div>
            <div data-id="{{user.id}}" class="likeIt alignright"><i class='iconfont'>&#xe61e;</i></div>
            <div class="alignright"><i class='lagernum color_active'>{{total}}</i></div>
        </div>
    </div>
</li>
{{#ishead}}<div style="height:20px;background:#f4f4f4"></div>{{/ishead}}
{{/datas}}
</script>

<?php $this->end('static') ?>

<div class="wraper pd45">
    <div class="activity_list">
        <div class="date_list">
            <div class="date_list_header" id="imgTab">
                <div id="tab-1" class="alldate cur"><span class="headertab">约会</span></div>
                |
                <div id="tab-2" class="todate"><span class="headertab">派对</span></div>
                |
                <div id="tab-3" class="todate"><span class="headertab">头牌</span></div>
            </div>
        </div>
        <div class="activity_list_con" id='imgBox'>
            <!--活动-->
            <section>
                <!-- 约会列表 -->
                <div id="date_list"></div>
            </section>

            <!--派对-->
            <section>
                <!--轮播图-->
                <div id="party-coverimg" class="abanner">
                    &nbsp;
                </div>
                <div id="party_list" class="party_content">
                    <!-- 派对列表 -->
                </div>
            </section>
            <!--头牌-->
            <section>
                <div class="cover_image">
                    <img src="/mobile/images/cover.jpg" alt=""/>
                    <a href="#this" class="more"><img src="/mobile/images/more.png"/></a>
                </div>
                <?php if(isset($user) && $user->gender == 2): ?>
                <div class="invite">
                    <a href="#this" class="btn btn_t_border">邀请好友支持我</a>
                </div>
                <?php else: ?>
                <div class="cover_bottom_header mt20">
                    <img src="/mobile/images/tp.jpg"/>
                </div>
                <?php endif; ?>
                <div class="rank_list">
                    <ul class="rank_header">
                        <li class="top-tab current" act="top_week"><span>周榜</span></li>
                        <li class="top-tab" act="top_month"><span>月榜</span></li>
                        <li class="top-tab" act="rich_list"><span>土豪榜</span></li>
                    </ul>
                    <div class="rank_con">
                        <ul class="inner outerblock" id="top-list">
                            <!-- 头牌列表 -->
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
            cur_tab: 1,  //记录当前显示的tab
            tabInitLoad: [0, 1, 1, 1], //第一次加载
            tabPage: [1, 1, 1, 1], //当前第几页
            tabLoadEnd: [0, 0, 0, 0], //页码加载结束
            tabLoadHold: [0, 0, 0, 0], //页码加载结束
            tabDataTpl: ['', '#date-list-tpl', '#activity-list-tpl', '#top-list-tpl'],
            listId: ['', '#date_list', '#party_list', '#winer_list'],
            tabDataUrl: ['', '/date/get-all-dates-in-page/', '/activity/get-all-dates-in-page/', '/activity/get-top-list/'],
            top_obj: null
        }
        $.extend(this, this.opt, o);
    }

    $.extend(activity.prototype, {
        init: function () {
            this.tabEvent();
            this.scroll();
        },
        tabEvent: function () {
            var obj = this;
            $.util.loop({
                tp: 'text', //图片img或是文字text
                //min : 5,
                loadImg: true,
                isInit: true,
                moveDom: $('#imgBox'),
                moveChild: $('#imgBox section'),
                tab: $('#imgTab div'),
                loopScroll: false,
                autoTime: 0,
                lockScrY: true,
                //imgInitLazy: 1000,
                index: 1,
                viewDom: $('.activity_list'),
                fun: function (index) {
                    index = parseInt(index);
                    if (index != 3) {
                        if (obj.cur_tab == index && !this.isInit) {
                            return;
                        }
                        window.scrollTo(0, 0);
                        this.isInit = false;
                        obj.cur_tab = index;
                        obj.tabInit(index);
                    } else {
                        if (!obj.top_obj) {
                            obj.top_obj = new topPage();
                            obj.top_obj.init();
                        }
                    }
                }
            });
        },
        tabInit: function (index) {
            if (!this.tabInitLoad[index]) return;
            this.tabInitLoad[index] = 0;
            //首次加载数据
            this.asyLoadData(this.cur_tab);

        },
        scroll: function () {
            var obj = this;
            $(window).on("scroll", function () {
                if (obj.tabInitLoad[obj.cur_tab]) return;
                var st = document.body.scrollTop;
                var cbodyH = $(obj.listId[obj.cur_tab]).height() - 600;

                if (st >= cbodyH && obj.cur_tab != 3) {
                    obj.asyLoadData(obj.cur_tab);
                }
            });
        },

        asyLoadData: function (curtab) {
            if (this.tabLoadHold[curtab] || this.tabLoadEnd[curtab]) return;
            this.tabLoadHold[curtab] = true;
            $.util.showPreloader();
            var template = $(this.tabDataTpl[curtab]).html();
            var url = this.tabDataUrl[curtab] + this.tabPage[curtab];
            Mustache.parse(template);   // optional, speeds up future uses
            var obj = this;
            $.getJSON(url, function (data) {
                obj.tabLoadHold[curtab] = false;
                $.util.hidePreloader();
                if (data.code === 200) {
                    var rendered = Mustache.render(template, data);
                    if (!data.datas.length) {
                        obj.tabLoadEnd[curtab] = true;
                    } else {
                        obj.tabPage[curtab]++;
                    }

                    switch (curtab) {
                        case obj.tab_date:
                            if (!obj.tabInitLoad[curtab]) {

                            }
                            break;
                        case obj.tab_activity:
                            if (!obj.tabInitLoad[curtab]) {
                                $('#party-coverimg').html("<img src='/mobile/css/icon/banner1.jpg'/>");
                            }
                            break;
                        case obj.tab_top:
                            if (!obj.tabInitLoad[curtab]) {
                            }
                            break;
                    }
                    $(obj.listId[curtab]).append(rendered);
                }
            });
        },
    });


    var topPage = function (o) {

        this.opt = {
            week_tab: 1,
            month_tab: 2,
            rich_tab: 3,
            cur_tab: 1,
            tabDataTpl: ['', '#top-list-tpl', '#top-list-tpl', '#rich-list-tpl'],
            tab_action: ['/activity/get-top-list/week', '/activity/get-top-list/month', '/activity/get-rich-list'],   //请求url
            container_id: '#top-list',
        };
        $.extend(this, this.opt, o);

    };

    $.extend(topPage.prototype, {
        init: function () {
            this.addTabEvent();
            this.loadDataWithoutPage(this.tab_action[0]);
        },
        addTabEvent: function () {
            var obj = this;
            $(".top-tab").on('click', function () {
                $(".top-tab").each(function () {
                    $(this).removeClass('current');
                });
                $(this).addClass('current');
                if ($(this).attr('act') == 'top_week') {
                    obj.cur_tab = obj.week_tab;
                    obj.loadDataWithoutPage(obj.tab_action[0]);
                } else if ($(this).attr('act') == 'top_month') {
                    obj.cur_tab = obj.month_tab;
                    obj.loadDataWithoutPage(obj.tab_action[1]);
                } else if ($(this).attr('act') == 'rich_list') {
                    obj.cur_tab = obj.rich_tab;
                    obj.loadDataWithoutPage(obj.tab_action[2]);
                }

            });
        },
        loadDataWithoutPage: function (action) {
            var obj = this;
            var template = $(this.tabDataTpl[this.cur_tab]).html();
            console.log(this.cur_tab);
            Mustache.parse(template);   // optional, speeds up future uses
            $.util.showPreloader('加载中...');
            $.ajax({
                url: action,
                type: "POST",
                dataType: "json",
                success: function (res) {
                    $.util.hidePreloader();
                    if (res.status) {
                        var rendered = Mustache.render(template, res);
                        console.log(res.datas);
                        console.log(obj.container_id);
                        console.log(rendered);
                        $(obj.container_id).html(rendered);
                    }
                }
            });
        }
    });


    var activityobj = new activity();
    activityobj.init();

</script>