<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="rich-list-tpl" type="text/html">
    {{#richs}}
    <li>
        <div class="voted_con flex flex_justify">
            <div class="flex">
                <span class="voted_place">{{count}}</span>
                <div class="voted_place_info">
                    <span class="avatar"><img src="{{user.avatar}}"/></span>
                    <h3>
                        <span class="voted_name">{{user.nick}}</span>
                        <span class="voted_number color_gray">已消费：{{total}}美币</span>
                    </h3>
                </div>
            </div>
            <div>
                <div data-id="{{user.id}}" class="alignright likeIt"><i class='iconfont'>&#xe61e;</i></div>
                <div class="alignright"><i class='lagernum color_active'>{{total}}</i></div>
            </div>
        </div>
    </li>
    {{/richs}}
</script>
<?php $this->end('static') ?>

<header>
    <div class="header">
        <h1>土豪财富榜</h1>
    </div>
</header>
<div class="wraper bgff">
    <h3 class="rich_header"></h3>
    <!--土豪第一名-->
    <?php if ($top3): ?>
        <div class="rich_list_first inner flex">
            <div class="rich_first_left">
                <div class="first_info">
                    <div class="first_info_img">
                        <img src="<?= $top3[0]->user->avatar ?>" class="richman"/>
                    </div>
                    <div class="first_info_bg"></div>
                </div>
                <span class="coast color_friends">已消费：<?= $top3[0]->total ?></span>
            </div>
            <div class="rich_first_right">
                <div data-id="<?= $top3[0]->user->id ?>" class="first_r_info beauty likeIt">魅力值 <i class='iconfont'>&#xe61e;</i></div>
                <span class="color_active lagernum"><?= $top3[0]->total ?></span>
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
                    <li>
                        <div class="voted_con flex flex_justify">
                            <div class="flex">
                                <span class="voted_place silver"><?= $count ?></span>
                                <div class="voted_place_info">
                                    <span class="avatar"><img src="<?= $top->user->avatar ?>"/></span>
                                    <h3>
                                        <span class="voted_name"><?= $top->user->nick ?></span>
                                        <span class="voted_number color_gray">已消费：<?= $top->total ?>美币</span>
                                    </h3>
                                </div>
                            </div>
                            <div>
                                <div data-id="<?= $top->user->id ?>" class="likeIt alignright"><i class='iconfont'>&#xe61e;</i></div>
                                <div class="alignright"><i class='lagernum color_active'><?= $top->total ?></i></div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <ul id="rich-list" class="voted_list outerblock"> 

        </ul>
    </div>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/index/get-rich-list/', page: curpage, tpl: '#rich-list-tpl', id: '#rich-list',
    key: 'richs', func: calFunc});
setTimeout(function () {
    //滚动加载
    $(window).on("scroll", function () {
        $.util.listScroll('order-list', function () {
            $.util.asyLoadData({gurl: '/index/get-rich-list/', page: curpage,
                tpl: '#rich-list-tpl', id: '#rich-list', more: true, key: 'richs', func: calFunc});
        })
    });
}, 2000);
var count = 3;
function calFunc(data) {
    //返回格式化回调
    $.each(data.richs, function (i, n) {
        count++;
        data.richs[i]['count'] = count;
    })
    return data;
}
$(document).on('tap', '.likeIt', function () {
    var user_id = $(this).data('id');
    var $obj = $(this);
    followIt(user_id,$obj);
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
</script>
<?php $this->end('script'); ?>