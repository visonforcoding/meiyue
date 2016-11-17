<?php
$date_action = '/date/get-all-dates-in-page/';  //定义约会请求地址
$activity_action = '/activity/index/';  //定义派对请求地址
?>

<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="date-list-tpl" type="text/html">
    {{#datas}}
    <div class="date_detail_place inner {{^is_first}}mt20{{/is_first}}">
        <h3 class="title"><i class="itemsname color_y">[约吃饭]</i> 海岸城高级西餐厅 美女在等你</h3>
        <div class="place_pic">
								<span class="place">
									<img src="/mobile/images/date_place.jpg"/>
								</span>
            <div class="place_info">
                <h3 class="userinfo">范冰冰 <span>23岁</span> <em class="price color_y fr"><i class="lagernum">500</i>元/约会金</em>
                </h3>
                <h3 class="otherinfo">
                    <time class="color_gray"><i class="iconfont">&#xe622;</i> 今日 · 12:00-15:00</time>
                    <address class="color_gray"><i class="iconfont">&#xe623;</i>广东省深圳市福田区 福田口岸</address>
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
            <h3 class="items_title">中秋国庆 三门岛游艇Party 七日游中秋国庆 三门岛游艇Party 七日游中秋国庆 三门岛游艇Party 七日游</h3>
            <div class="items_time flex flex_justify mt20">
                <div>名额有限，大家速速报名</div>
                <div>
                    <i class="iconfont ico">&#xe64b;</i>
                    即将开始
                </div>
            </div>
        </div>
        <div class="items_adress flex flex_justify">
            <div><i class="iconfont ico">&#xe623;</i>广东省深圳市福田区福田口岸</div>
            <div class="button btn_dark">
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
                <div id="date_list">&nbsp;</div>
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
            cur_tab: 1,  //记录当前显示的tab
            tabInitLoad:[0,0,0,0], //第一次加载
            tabPage:[1,1,1,1], //当前第几页
            tabLoadEnd:[0,0,0,0], //页码加载结束
            tabLoadHold:[0,0,0,0], //页码加载结束
            tabDataTpl: ['','#date-list-tpl', '#activity-list-tpl', '#top-list-tpl'],
            listId: ['','#date_list', '#party_list', '#winer_list'],
            tabDataUrl:['','/date/get-all-dates-in-page/','/activity/index/','/activity/index/'],
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
            this.tabEvent();
            this.scroll();

        },
        tabEvent: function () {
            var obj = this;
            $.util.loop({
                tp: 'text', //图片img或是文字text
                //min : 5,
                loadImg: true,
                isInit:true,
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
                    if(obj.cur_tab == index && !this.isInit) {
                        return;
                    }
                    window.scrollTo(0,0);
                    this.isInit = false;
                    this.cur_tab = index;
                    obj.tabInit(index);
                }
            });
        },
        tabInit: function(index){
            if(this.tabInitLoad[index]) return;
            this.tabInitLoad[index] = 1;
            //首次加载数据
            this.asyLoadData(this.cur_tab);

            switch (index) {
                case 1:
                    break;
                case 2:
                    $('#party-coverimg').html("<img src='/mobile/css/icon/banner1.jpg'/>");
                    break;
                case 3:
                    break;
            }

        },
        scroll:function () {
            var obj = this;
            $(window).on("scroll", function () {
                if(!obj.tabInitLoad[obj.cur_tab]) return;
                var st = document.body.scrollTop;
                var cbodyH = $(obj.listId[obj.cur_tab]).height();

                //console.log([$(document).height(), $(window).height(),$(document).height()-$(window).height()-200,st].join('-'));
                //if (st >= (($(document).height() - 150))) {
                console.log([st, cbodyH,st - cbodyH].join('-'));
                if (st >= cbodyH) {
                    obj.asyLoadData(obj.cur_tab);
                }
            });
        },

        asyLoadData: function (curtab) {
            if(this.tabLoadHold[curtab] || this.tabLoadEnd[curtab]) return;
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

                    obj.tabInitLoad[curtab] ? $(obj.listId[curtab]).html(rendered) : $(obj.listId[obj.cur_tab]).append(rendered);
                }
            });
        },
    });

    var activityobj = new activity();
    activityobj.init();

</script>