<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="like-list-tpl" type="text/html">
    {{#likes}}
    <li>
        <a class="praised_block click-like-item" data-id="{{follower.id}}">
            <div class="praised_list_left">
                <span class="avatar"><img src="{{follower.avatar}}" alt="" /></span>
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
<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1><?= $pageTitle; ?></h1>
    </div>
</header>
<div class="wraper">
    <ul id="like-list" class="praised_list mt20 bgff">

    </ul>
</div>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/userc/get-likes-list/', page: curpage, tpl: '#like-list-tpl', id: '#like-list',
    key: 'likes'});
setTimeout(function () {
    //滚动加载
    $(window).on("scroll", function () {
        $.util.listScroll('like-list', function () {
            $.util.asyLoadData({gurl: '/userc/get-likes-list/', page: curpage,
                tpl: '#like-list-tpl', id: '#like-list', more: true, key: 'likes'});
        })
    });
}, 2000);

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
LEMON.sys.back('/user/index');
</script>
<?php $this->end('script'); ?>