<?php $this->start('static') ?>
    <script src="/mobile/js/mustache.min.js"></script>
    <script id="rich-list-tpl" type="text/html">
        {{#richs}}
        <li>
            <div class="voted_con flex flex_justify">
                <div class="flex">
                    <span class="voted_place">{{count}}</span>
                    <div class="voted_place_info">
                        <span class="avatar" onclick="location.href='/user/male-homepage/{{id}}'"><img
                                    src="{{avatar}}"/></span>
                        <h3>
                            <div class='flex'><span class="voted_name">{{nick}}</span>
                                {{#isActive}}<span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>{{/isActive}}
                                {{#isTuHao}}<span class="hot"><img src="/mobile/images/zs.png" class="responseimg"/></span>{{/isTuHao}}
                                {{#upackname}}<span class="highter-vip {{upackstyle}}">{{upackname}}</span>{{/upackname}}
                            </div>
                            <span class="voted_number color_gray">已消费：{{recharge}}元</span>
                        </h3>
                    </div>
                </div>
                <div>
                    <div data-id="{{id}}" class="alignright likeIt"><i
                                class='iconfont commico {{#like}}activeico{{/like}}'></i></div>
                    <div class="alignright"><i class='lagernum color_active'>{{recharge}}</i></div>
                </div>
            </div>
        </li>
        {{/richs}}
    </script>
<?php $this->end('static') ?>

    <!-- <header>
        <div class="header">
            <h1>土豪财富榜</h1>
        </div>
    </header> -->
    <div class="wraper bgff">
        <h3 class="rich_header"></h3>
        <!--土豪第一名-->
        <?php if ($top3): ?>
            <div class="rich_list_first inner flex">
                <div class="rich_first_left">
                    <div class="first_info" onclick="location.href='/user/male-homepage/<?= $top3[0]->id; ?>'">
                        <div class="first_info_img">
                            <img src="<?= $top3[0]->avatar ?>" class="richman"/>
                        </div>
                        <div class="first_info_bg"></div>
                    </div>
                    <span class="coast color_friends">已消费：<?= $top3[0]->recharge ?></span>
                </div>
                <div class="rich_first_right">
                    <div data-id="<?= $top3[0]->id ?>" class="first_r_info beauty likeIt">魅力值
                        <i class='iconfont commico <?php if (isset($top3[0]->fans)): ?>
                        <?php if ($top3[0]->fans): ?>activeico<?php endif; ?><?php endif; ?>'></i>
                    </div>
                    <span class="color_active lagernum"><?= $top3[0]->recharge ?></span>
                </div>
            </div>
        <?php endif; ?>
        <!--土豪list-->
        <div class="rich_list">
            <ul class="voted_list outerblock">
                <?php if (count($top3) > 1): ?>
                    <?php $count = 1; ?>
                    <?php foreach ($top3 as $i => $top): ?>
                        <?php if ($i == 0): ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <?php $count++; ?>
                        <li style='border-bottom:1px #efefef solid;'>
                            <div class="voted_con flex flex_justify">
                                <div class="flex">
                                    <div class='flex flex_center'><span class="voted_place silver"><?= $count ?></span>
                                    </div>
                                    <div class="voted_place_info">
                                        <span class="avatar"
                                              onclick="location.href='/user/male-homepage/<?= $top->id; ?>'"><img
                                                    src="<?= $top->avatar ?>"/></span>
                                        <h3>
                                            <div class="flex">
                                                <span class="voted_name"><?= $top->nick ?></span>
                                                <?php if($top->isActive): ?>
                                                    <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
                                                <?php endif; ?>
                                                <?php if($top->isTuHao): ?>
                                                    <span class="hot"><img src="/mobile/images/zs.png" class="responseimg"/></span>
                                                <?php endif; ?>
                                                <?php if ($top->upackname): ?>
                                                <span class="highter-vip <?= isset($top->upackstyle)?$top->upackstyle:'' ?>">
                                                    <?= $top->upackname; ?>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="voted_number color_gray">已消费：<?= $top->total ?>元</span>
                                        </h3>
                                    </div>
                                </div>
                                <div>
                                    <div data-id="<?= $top->id ?>" class="likeIt alignright">
                                        <i class='iconfont commico <?php if (isset($top->fans)): ?>
                                        <?php if ($top->fans): ?>activeico<?php endif; ?><?php endif; ?>'></i>
                                    </div>
                                    <div class="alignright"><i class='lagernum color_active'><?= $top->recharge ?></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <ul id="rich-list" class="voted_list outerblock  set-voted-wid">

            </ul>
        </div>
    </div>
    <div style="height:1.4rem"></div>
    <!--底部-->
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
    <script>
        var curpage = 1;
        $.util.asyLoadData({
            gurl: '/index/get-rich-list/', page: curpage, tpl: '#rich-list-tpl', id: '#rich-list',
            key: 'richs', func: calFunc
        });
        setTimeout(function () {
            //滚动加载
            $(window).on("scroll", function () {
                $.util.listScroll('order-list', function () {
                    $.util.asyLoadData({
                        gurl: '/index/get-rich-list/', page: curpage,
                        tpl: '#rich-list-tpl', id: '#rich-list', more: true, key: 'richs', func: calFunc
                    });
                })
            });
        }, 2000);
        var count = 3;
        function calFunc(data) {
            //返回格式化回调
            $.each(data.richs, function (i, n) {
                count++;
                var like = false;
                if (n.hasOwnProperty('fans')) {
                    like = n.fans.length > 0 ? true : false;
                }
                data.richs[i]['count'] = count;
                if(count <= 100) {
                    //data.richs[i]['isTuHao'] = true;
                }
                data.richs[i]['like'] = like;
            })
            console.log(data);
            return data;
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
                    if (res.status) {
                        if ($obj.find('i').hasClass('activeico')) {
                            $.util.alert('取消点赞成功');
                        } else {
                            $.util.alert('点赞成功');
                        }
                    }
                    $obj.find('i').toggleClass('activeico');
                    $.util.alert(res.msg);
                }
            })
        }
    </script>
<?php $this->end('script'); ?>