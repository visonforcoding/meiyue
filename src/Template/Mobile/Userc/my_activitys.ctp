<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="myAct-list-tpl" type="text/html">
    {{#datas}}
    <li>
        <div class="items_date_info flex flex_justify">
            <div class="items_left_info">
							<span class="items_left_picinfo">
								<img src="/mobile/images/place3.png"/>
							</span>
                <div class="items_left_textinfo">
                    <h3><i class="color_y"></i>{{activity.title}}</h3>
                    <address class="smallarea"><i class="iconfont">&#xe623;</i> {{activity.site}}</address>
                </div>
            </div>
            <div class="items_right_info">
                <span class="color_y"><i class="iconfont">&#xe622;</i>{{date}}</span>
                <time class="party_time">{{time}}</time>
                <span class="getdatebtn button btn_bg_active">{{bustr}}</span>
            </div>
        </div>
    </li>
    {{/datas}}
</script>
<?php $this->end('static'); ?>
<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>我的派对</h1>
    </div>
</header>
<div class="wraper">
    <div class="home_paty_container">
        <div class="date_list_header">
            <div class="date-tab alldate cur" data-query="1"><span class="headertab">进行中</span></div>
            |
            <div class="date-tab todate" data-query="2"><span class="headertab">已结束</span>
            </div>
        </div>
        <div class="home_paty_con">
            <section>
                <ul class="female_date_list outerblock mt20" id="list-con">

                </ul>
            </section>
        </div>
    </div>
</div>

<script>
    var curpage = parseInt(1);
    var url = '/userc/get-acts-in-page/';
    var tmpl = '#myAct-list-tpl';
    var conid = '#list-con';
    $.util.asyLoadData({
        gurl: url,
        page: curpage,
        query: '?query=1',
        tpl: tmpl,
        id: conid,
        key: 'datas',
        func: calFunc
    });

    //点击tab的切换效果
    $(".date-tab").on('tap', function () {

        $(".date-tab").each(function () {

            $(this).removeClass('cur');

        });
        $(this).addClass('cur');
        var query = $(this).data('query');
        var curpage = 1;
        $.util.asyLoadData({
            gurl: url,
            page: curpage,
            query: '',
            tpl: tmpl,
            id: conid,
            key: 'datas',
            func: calFunc
        });

    });


    /*setTimeout(function () {
     //滚动加载
     $(window).on("scroll", function () {
     $.util.listScroll('order-list', function () {
     $.util.asyLoadData({
     gurl: '/userc/get-acts-in-page/', page: curpage,
     tpl: '#myAct-list-tpl', id: '#list-con', more: true, key: 'datas', func: calFunc
     });
     })
     });
     }, 2000);*/


    //可以定制输出内容data.datas为数据列表
    function calFunc(data) {
        //返回格式化回调
        if (data.datas) {

        }
        console.log(data);
        return data;
    }
</script>