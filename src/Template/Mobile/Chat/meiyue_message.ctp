<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1><?= $pageTitle; ?></h1>
    </div>
</header> -->
<div class="wraper">
    <ul id="list-container" class="chart-systerm-box inner">
        <li class="timebox">
            <time><?= $user->create_time->i18nFormat('yyyy-MM-dd HH:mm');?></time>
        </li>
        <li class="infobox">
            <p>Hi，欢迎来到美约，希望你在这里玩得开心哦~</p>
        </li>
    </ul>
</div>
<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<?php $this->end('static') ?>
<script id="tpl-common" type="text/html">
{{#datas}}
    <li class="timebox">
        <time>{{create_time}}</time>
    </li>
    <li class="infobox">
        <p>{{ptmsg.body}}&nbsp;&nbsp;{{#ptmsg.to_url}}<a href="{{ptmsg.to_url}}" style="color: dodgerblue">查看详情</a>{{/ptmsg.to_url}}</p>
    </li>
{{/datas}}
</script>
<script>
    var curpage = 1;
    $.util.asyLoadData({
        gurl: '/chat/get-messages/', page: curpage, tpl: '#tpl-common', id: '#list-container',
        key: 'datas', more: true
    });
    setTimeout(function () {
        //滚动加载
        $(window).on("scroll", function () {
            $.util.listScroll('list-container', function () {
                $.util.asyLoadData({
                    gurl: '/chat/get-messages/', page: curpage,
                    tpl: '#tpl-common', id: '#list-container', more: true, key: 'datas'
                });
            })
        });
    }, 2000);
</script>