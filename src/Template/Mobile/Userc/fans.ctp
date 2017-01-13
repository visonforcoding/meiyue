<?php $this->start('static') ?>
    <script src="/mobile/js/mustache.min.js"></script>
    <script id="fans-list-tpl" type="text/html">
        {{#fans}}
        <li>
            <a class="praised_block" onclick="viewta({{user.id}});">
                <div class="praised_list_left">
                    <span class="avatar"><img src="{{user.avatar}}" alt=""/></span>
                    <h3>
                        <span class="username">{{user.nick}}</span>
                        <span class="usersex"><i class="iconfont color_y">&#xe61c;</i>{{user.age}}岁</span>
                    </h3>
                </div>
                <div class="praised_list_right">
                    <span class="attractive ">魅力值<i class="numbers">{{user.charm}}</i><!--<i class="iconfont ico">&#xe61e;</i>--></span>
                </div>
            </a>
        </li>
        {{/fans}}
    </script>
<?php $this->end('static') ?>
    <!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1><?= $pageTitle ?></h1>
    </div>
</header> -->
    <div class="wraper">
        <ul id="fans-list" class="praised_list mt20 bgff">

        </ul>
        <div id="blank-area" class="empty_container">

        </div>
    </div>
<?php $this->start('script'); ?>
    <script type="text/javascript">
        var curpage = 1;
        loadUser(curpage);

        function loadUser(page, more, query) {
            $.util.showPreloader();
            var template = $('#fans-list-tpl').html();
            Mustache.parse(template);   // optional, speeds up future uses
            url = '/userc/fans/' + page + '.json';
            $.getJSON(url, function (data) {
                window.holdLoad = false;
                $.util.hidePreloader();
                if ((data.fans).length) {
                    var rendered = Mustache.render(template, data);
                    if (more) {
                        $('#fans-list').append(rendered);
                        if (!data.fans.length) {
                            window.holdLoad = true;
                        } else {
                            curpage++;
                        }
                    } else {
                        $('#fans-list').html(rendered);
                    }
                } else {
                    $blankStr = '<div class="empty-content  mt350"><span class="empty-ico-box bg-light">' +
                        '<i class="iconfont empty-ico">&#xe699;</i></span>' +
                        '<p class="empty-tips">你暂时还没有粉丝，赶快更新动态吧~</p>' +
                        '<div class="empty-btn inner"><a href="/userc/my-tracle" class="btn btn_t_border">我的动态</a></div></div>';
                    if(curpage == 1) {
                        if(1 == <?= $user->gender; ?>) {
                            $blankStr = '<div class="empty-content  empty-text">' +
                                '<p class="empty-tips">还没有人赞赏过你<br />快去' +
                                '<a href="/purse/recharge" class="color_y">充值</a>提升魅力值吧</p></div>';
                        }
                    } else {
                        $blankStr = '<p class="smallarea aligncenter mt60">没有更多数据了</p><br>';
                    }
                    $('#blank-area').html($blankStr);
                }
            });
        }


        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('fans-list', function () {
                    //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                    loadUser(curpage + 1, true);
                })
            });
        }, 2000)


        function viewta(uid) {
            location.href = (<?= $user->gender; ?> == 2)?'/user/male-homepage/' + uid:'/index/homepage/' + uid;
        }

    </script>
<?php $this->end('script'); ?>