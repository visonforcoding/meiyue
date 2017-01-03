<?php $this->start('static') ?>
    <script src="/mobile/js/mustache.min.js"></script>
    <script id="male-list-tpl" type="text/html">
        {{#visitors}}
        <li>
            <a class="praised_block" onclick="viewta({{visiter.id}});">
                <div class="praised_list_left">
                    <span class="avatar"><img src="{{visiter.avatar}}" alt="" /></span>
                    <h3>
                        <span class="username">{{visiter.nick}}</span>
                        <span class="usersex"><i class="iconfont color_y">&#xe61c;</i>{{visiter.age}}岁</span>
                    </h3>
                </div>
                <div class="praised_list_right">
                    <span class="attractive ">魅力值<i class="numbers">{{visiter.charm}}</i><i class="iconfont ico">{{#isfan}}&#xe61e;{{/isfan}}{{^isfan}}&#xe61f;{{/isfan}}</i></span>
                </div>
            </a>
        </li>
        {{/visitors}}
    </script>

    <script id="female-list-tpl" type="text/html">
        {{#visitors}}
        <li>
            <a class="praised_block" onclick="viewta({{visiter.id}});">
                <div class="praised_list_left">
                    <span class="avatar"><img src="{{visiter.avatar}}" alt="" /></span>
                    <h3>
                        <span class="username">{{visiter.nick}}</span>
                        <span class="usersex"><i class="iconfont color_y">&#xe61c;</i>{{visiter.age}}岁</span>
                    </h3>
                </div>
                <div class="praised_list_right">
                    <span class="attractive ">魅力值<i class="numbers">{{visiter.charm}}</i><!--<i class="iconfont ico">{{#isfan}}&#xe61e;{{/isfan}}{{^isfan}}&#xe61f;{{/isfan}}</i>--></span>
                </div>
            </a>
        </li>
        {{/visitors}}
    </script>
<?php $this->end('static') ?>
    <!-- <header>
        <div class="header">
            <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
            <h1><?=$pageTitle?></h1>
        </div>
    </header> -->
    <div class="wraper">
        <ul id="visitors-list" class="praised_list mt20 bgff">

        </ul>
    </div>
<?php $this->start('script'); ?>
    <script type="text/javascript">
        var curpage = 1;
        loadUser(curpage);

        function loadUser(page, more, query) {
            $.util.showPreloader();
            var template = '';
            if(<?= $user->gender; ?> == 1) {
                template = $('#male-list-tpl').html();
            } else {
                template = $('#female-list-tpl').html();
            }

            Mustache.parse(template);   // optional, speeds up future uses
            url = '/userc/visitors/' + page + '.json';
            $.getJSON(url, function (data) {
                window.holdLoad = false;
                if (data.visitors) {
                    var rendered = Mustache.render(template, data);
                    if (more) {
                        $('#visitors-list').append(rendered);
                        curpage++;
                    } else {
                        $('#visitors-list').html(rendered);
                    }
                    $.util.hidePreloader();
                } else {
                    window.holdLoad = true;
                }
            });
        }

        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('visitors-list', function () {
                    loadUser(curpage + 1, true);
                })
            });
        }, 2000)


        function viewta(uid) {
            location.href = (<?= $user->gender; ?> == 2)?'/user/male-homepage/' + uid:'/index/homepage/' + uid;
        }
    </script>
<?php $this->end('script'); ?>