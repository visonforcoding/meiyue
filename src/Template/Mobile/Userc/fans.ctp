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
                window.holdLoad = false
                if (data.fans) {
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
                    $.util.hidePreloader();
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