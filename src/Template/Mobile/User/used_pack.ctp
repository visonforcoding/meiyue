<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>付费查看记录</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="deadline-box"></div>
    <div class="date_list_header">
        <div class="date-tab alldate cur" data-query="1"><span class="headertab">查看动态</span></div> | <div class="date-tab todate" data-query="2"><span class="headertab">聊天</span></div>
    </div>
    <div class="deadline-content">
        <ul id="list-con" class="praised_list mt20 bgff">

        </ul>
    </div>
</div>
</div>

<script id="myAct-list-tpl" type="text/html">
    {{#datas}}
    <li>
        <a href="/index/homepage/{{used.id}}" class="praised_block">
            <div class="praised_list_left">
                <span class="avatar"><img src="{{used.avatar}}" alt="" /></span>
                <h3>
                    <span class="username">{{used.nick}}</span>
                    <span class="usersex"><i class="iconfont color_y">&#xe61c;</i>{{used.age}}岁</span>
                </h3>
            </div>
            <div class="praised_list_right">
                <span class="attractive ">{{deadline}} 到期</span>
            </div>
        </a>
    </li>
    {{/datas}}
</script>
<?php $this->start('script'); ?>
<script src="/mobile/js/mustache.min.js"></script>
<script>

    var curpage = 1;  //当前页
    var curtab = 1;
    var url = '/user/get-used-packs/';
    var tmpl = '#myAct-list-tpl';
    var conid = 'list-con';
    $.util.asyLoadData({
        gurl: url,
        page: curpage,
        query: '?query=1',
        tpl: tmpl,
        id: '#' + conid,
        key: 'datas',
        func: calFunc
    });

    //点击tab的切换效果
    $(".date-tab").on('tap', function () {
        curtab = parseInt($(this).data('query'));
        curpage = 1;
        console.log(curpage);
        $(".date-tab").each(function () {
            $(this).removeClass('cur');
        });
        $(this).addClass('cur');
        var query = "?query=" + curtab;
        $.util.asyLoadData({
            gurl: url,
            page: curpage,
            query: query,
            tpl: tmpl,
            id: '#' + conid,
            key: 'datas',
            func: calFunc
        });
    });


    setTimeout(function () {
        //滚动加载
        $(window).on("scroll", function () {
            $.util.listScroll(conid, function () {
                $.util.asyLoadData({
                    gurl: url, page: curpage,
                    tpl: tmpl, id: '#' + conid, more: true, key: 'datas', func: calFunc
                });
            })
        });
    }, 2000);


    //可以定制输出内容data.datas为数据列表
    function calFunc(data) {
        if (data.status) {
            curpage ++;
        }
        return data;
    }
    LEMON.sys.back('/user/index');
</script>
<?php $this->end('script'); ?>