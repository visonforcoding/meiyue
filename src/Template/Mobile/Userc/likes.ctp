<?php $this->start('static') ?>
    <script src="/mobile/js/mustache.min.js"></script>
    <script id="like-list-tpl" type="text/html">
        {{#likes}}
        <li>
            <a class="praised_block" onclick="viewta({{follower.id}});">
                <div class="praised_list_left">
                    <span class="avatar"><img src="{{follower.avatar}}" alt=""/></span>
                    <h3>
                        <span class="username">{{follower.nick}}</span>
                        <span class="usersex"><i class="iconfont color_y">&#xe61c;</i>{{follower.age}}岁</span>
                    </h3>
                </div>
                <div class="praised_list_right">
                    <span class="attractive ">魅力值<i class="numbers">{{follower.charm}}</i></span>
                </div>
            </a>
        </li>
        {{/likes}}
    </script>
<?php $this->end('static') ?>
    <!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1><?= $pageTitle; ?></h1>
    </div>
</header> -->
    <div class="wraper">
        <ul id="like-list" class="praised_list mt20 bgff">

        </ul>
        <div id="blank-area" class="empty_container">

        </div>
    </div>
<?php $this->start('script'); ?>
    <script>
        var curpage = 1;
        loadUser(curpage);
        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('like-list', function () {
                    loadUser(curpage + 1, true);
                })
            });
        }, 2000)

        function loadUser(page, more, query) {
            var template = $('#like-list-tpl').html();
            Mustache.parse(template);   // optional, speeds up future uses
            url = '/userc/get-likes-list/' + page + '.json';
            $.getJSON(url, function (data) {
                window.holdLoad = false;
                if ((data.likes).length) {
                    var rendered = Mustache.render(template, data);
                    if (more) {
                        $('#like-list').append(rendered);
                        if (!data.fans.length) {
                            window.holdLoad = true;
                        } else {
                            curpage++;
                        }
                    } else {
                        $('#like-list').html(rendered);
                    }
                } else {
                    $blankStr = '<div class="empty-content  mt350"><span class="empty-ico-box bg-light">' +
                        '<i class="iconfont empty-ico">&#xe699;</i></span>' +
                        '<p class="empty-tips">你还没有赞赏过的人，快去寻找那个他吧~</p>' +
                        '<div class="empty-btn inner"><a href="/index/find-rich-list" class="btn btn_t_border">立即寻找他</a></div></div>';
                    if(curpage == 1) {
                        if(1 == <?= $user->gender; ?>) {
                            $blankStr = '<div class="empty-content  empty-text mt350">' +
                                '<p class="empty-tips">你还没有关注任何人<br />点击' +
                                '<a href="/index/find-list" class="color_y">发现列表</a> 去找喜欢的吧~</p></div>';
                        }
                    } else {
                        $blankStr = '<p class="smallarea aligncenter mt60">没有更多数据了</p><br>';
                    }
                    $('#blank-area').html($blankStr);
                }
            });
        }

        $(document).on('tap', '.likeIt', function () {
            var user_id = $(this).data('id');
            var $obj = $(this);
            followIt(user_id, $obj);
        });
        function followIt(id, $obj) {
            $.util.ajax({
                url: '/user/follow',
                data: {id: id},
                func: function (res) {
                    $obj.find('i').toggleClass('color_active');
                    $.util.alert(res.msg);
                }
            })
        }

        function viewta(uid) {
            location.href = (<?= $user->gender; ?> == 2)?'/user/male-homepage/' + uid:'/index/homepage/' + uid;
        }
        LEMON.sys.back('/user/index');
    </script>
<?php $this->end('script'); ?>