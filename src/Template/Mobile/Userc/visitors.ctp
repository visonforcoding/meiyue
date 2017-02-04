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
                    <span class="attractive ">魅力值<i class="numbers">{{visiter.charm}}</i><!--<i class="iconfont ico">{{#isfan}}&#xe61e;{{/isfan}}{{^isfan}}&#xe61f;{{/isfan}}</i>--></span>
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
        <div class="visited-box not-vip-show">
            <span class="visited-ico iconfont">&#xe64a;</span>
            <p class="visited-num">有 <span class="lagernum color_y"><?= $visitnum; ?></span> 人来看过你</p>
            <p class="smallarea">多充值将会使你增加曝光率，让你更受欢迎哦~</p>
        </div>
        <ul id="visitors-list" class="praised_list bgff">

        </ul>
        <div id="blank-area" class="empty_container">

        </div>
    </div>
    <div style="height:62px;" class="not-vip-show"></div>
    <a class="identify_footer_potion not-vip-show" id="beVIP">
        <?= $isChecking?'需要消耗'.$iosCheckConf['view_visitors'].'积分才能查看访客哦~':'成为会员，立即查看访客信息'; ?>
    </a>
<?php $this->start('script'); ?>
    <script type="text/javascript">
        <?php if($isvip || ($user->gender == 2)): ?>
        var curpage = 1;
        init();
        loadUser(curpage);
        function loadUser(page, more, query) {
            var template = '';
            if(<?= $user->gender; ?> == 1) {
                template = $('#male-list-tpl').html();
            } else {
                template = $('#female-list-tpl').html();
            }
            Mustache.parse(template);   // optional, speeds up future uses
            url = '/userc/visitors/' + page + '.json';
            $.getJSON(url, function (data) {
                if ((data.visitors).length) {
                    var rendered = Mustache.render(template, data);
                    if (more) {
                        $('#visitors-list').append(rendered);
                        curpage++;
                    } else {
                        $('#visitors-list').html(rendered);
                    }
                    window.holdLoad = false;
                } else {
                    if(curpage == 1) {
                        $('#blank-area').html('<div class="empty-content  empty-text mt350"><p class="empty-tips">您暂时没有访客哦</p></div>');
                    } else {
                        $('#blank-area').html('<p class="smallarea aligncenter mt60">没有更多数据了</p><br>');
                        window.holdLoad = true;
                    }
                }
                if(curpage == 1) {
                    $(window).on("scroll", function () {
                        $.util.listScroll('visitors-list', function () {
                            loadUser(curpage + 1, true);
                        })
                    });
                }
            });
        }
        function viewta(uid) {
            location.href = (<?= $user->gender; ?> == 2)?'/user/male-homepage/' + uid:'/index/homepage/' + uid;
        }
        function init() {
            $('.not-vip-show').hide();
            window.holdLoad = false;
        }
        <?php elseif($isChecking): ?>
        $.util.tap($('#beVIP'), function() {
            $.util.confirm(
                ' ',
                '将消耗<?= $iosCheckConf['view_visitors']; ?>积分',
                function() {
                    $.util.ajax({
                        url:'/userc/consume-visit/<?=$user->id?>',
                        method: 'POST',
                        func:function(res){
                            $.util.hidePreloader();
                            if(res.status) {
                                location.reload();
                            } else {
                                $.util.alert(res.msg);
                            }
                        }
                    })
                },
                null
            );
        });
        <?php else: ?>
        $.util.tap($('#beVIP'), function() {
            location.href = '/userc/vip-buy?reurl=/userc/visitors';
        });
        <?php endif; ?>
    </script>
<?php $this->end('script'); ?>