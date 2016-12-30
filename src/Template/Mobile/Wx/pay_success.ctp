<?php $this->start('static') ?>
    <script src="/mobile/js/mustache.min.js"></script>
    <script id="user-list-tpl" type="text/html">
        {{#users}}
        <dl>
            <a href="/index/homepage/{{id}}">
                <dt>
                    <img src="{{avatar}}" alt=""/>
                <h1 class="alignright">
                    <time>{{login_time}}</time>
                    | <i>{{distance}}</i></h1>
                </dt>
                <dd class="flex flex_justify find_list_con">
                    <span class="username">{{nick}}</span>
                    <span class="userinfo"><i class="iconfont color_y">&#xe61d;</i><i class="age">{{age}}</i><i
                            class="job">{{profession}}</i></span>
                </dd>
            </a>
        </dl>
        {{/users}}
    </script>
<?php $this->end('static') ?>
    <!-- <header>
        <div class="header">
            <span class="iconfont toback">&#xe602;</span>
            <h1><?= isset($st['pageTitle']) ? $st['pageTitle'] : ''; ?></h1>
        </div>
    </header> -->
    <div class="wraper">
        <div class="date_pay_content flex flex_justify">
            <div class="date_pay_leftcon">
                <h1 class="pay_tips"><?= isset($st['msg1']) ? $st['msg1'] : ''; ?></h1>
                <p><?= isset($st['msg2']) ? $st['msg2'] : ''; ?></p>
            </div>
            <div class="date_pay_rightcon">
                <?php if (isset($st['reurl'])): ?><a href="<?= $st['reurl']; ?>"
                                                     class="button btn_bg_active"><?= $st['rebtname']; ?></a><?php endif; ?>
                <a href="/index/find-list" class="button btn_light_t">返回首页</a>
            </div>
        </div>
        <!--其它活跃女神-->
        <div class="pay_detail_content">
            <h3 class="pady_detail_tips">其它活跃女神</h3>
            <div class="find_list_box">
                <div id="user-list" class="inner">

                </div>
            </div>
        </div>
    </div>

<?php $this->start('script'); ?>
    <script>
        var curpage = 1;

        $.util.asyLoadData({
            gurl: '/index/get-user-list/',
            page: curpage,
            tpl: '#user-list-tpl',
            id: '#user-list',
            key: 'users'
        });
        setTimeout(function () {
            $(window).on("scroll", function () {
                $.util.listScroll('place-list', function () {
                    //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                    $.util.asyLoadData({
                        gurl: '/index/get-user-list/', page: curpage,
                        tpl: '#user-list-tpl', id: '#user-list', more: true, key: 'users'
                    });
                })
            });
        }, 2000);
        LEMON.sys.back('/user/index');
    </script>
<?php $this->end('script'); ?>