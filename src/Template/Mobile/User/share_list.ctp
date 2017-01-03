<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="invit-list-tpl" type="text/html">
    {{#datas}}
    <li class="flex flex_justify">
        <div class="share_list_leftcon">
            <span class="avatar"><img src="{{invited.avatar}}" alt="" /></span>
            <h3>
                <span class="avatar_name">{{invited.nick}}  <i class="iconfont color_y">&#xe61c;</i> <i class="age">30岁</i></span>
                <span class="beauty smallarea">魅力值：<i class="color_friends">{{meili}}</i></span>
            </h3>
        </div>
        <span class="share_list_rightcon smallarea">我已赚取提成:<i class="color_friends"> {{income}}</i></span>
    </li>
    {{/datas}}
</script>
<?php $this->end('static'); ?>
<!--<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>已成功邀请的人</h1>
    </div>
</header>-->
<div class="wraper">
    <div class="share_num inner flex flex_justify mt20">
        <span class="text">总共已赚取</span>
        <span class="number color_friends"><?= isset($total)?$total:0;?></span>
    </div>
    <div class="share_num_list mt20">
        <p class="alignright inner totalnum">共<?= isset($count)?$count:0?>人</p>
        <ul id="list-con" class="share_num_detail outerblock">
            <!--列表显示-->
        </ul>
    </div>
</div>
<script>
    var curpage = 1;
    var url = '/user/get-invits/';
    var tmpl = '#invit-list-tpl';
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
        if (data.datas) {
            var datas = data.datas;
            for (key in datas) {
                tmp = datas[key];
                if(tmp['invited']['gender'] == 1) {
                    tmp['meili'] = tmp['invited']['recharge'];
                } else {
                    tmp['meili'] = tmp['invited']['charm'];
                }
                //返回格式化回调
                datas[key] = tmp;
            }
            data.datas = datas;
        }
        return data;
    }
</script>