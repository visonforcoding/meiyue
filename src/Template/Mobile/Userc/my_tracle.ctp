<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="movement-list-tpl" type="text/html">
    {{#movements}}
    <section>
        <div class="title inner flex">
            <div class="tracle_title_left">
                <span class="avatar"><img src="{{user.avatar}}"/></span>
                <h3 class="user_info">
                    <span>{{user.nick}}</span>
                    <time>{{create_time}}</time>
                </h3>
            </div>
        </div>
        <div class="con inner">
            <p class="text">{{body}}</p>
            {{#is_pic}}
            <ul class="piclist_con">
                {{#images}}
                <li><img src="{{.}}"/></li>
                {{/images}}
            </ul>
            {{/is_pic}}
            {{#is_video}}
            <div class="piclist_con videolist">
                <video id="really-cool-video"  class="video-js vjs-default-skin  vjs-16-9" 
                       preload="auto" width="100%" height="264"  poster="{{video_cover}}" controls>
                    <source src="{{video}}" type="video/mp4">
                </video>
            </div>
            {{/is_video}}
        </div>
        <div class="tracle_footer flex flex_justify inner">
            <div>
                <span class="tracle_footer_info"><i class="iconfont">&#xe65c;</i>{{view_nums}}</span>
                <span class="tracle_footer_info"><i class="iconfont">&#xe633;</i> {{praise_nums}}</span>
            </div>
            <div class="tracle_footer_info"><i class="iconfont">&#xe650;</i></div>
        </div>
    </section>
    {{/movements}}
</script>
<?php $this->end('static') ?>
<?php $this->start('css')?>
<style>
     .video-js{
        background-color: #000;
   		padding: 0 .1rem;
    }
</style>
<?php $this->end('css')?>
<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>我的动态</h1>
    </div>
</header>
<div class="wraper">
    <div class="tracle_list" id="tracle-list">

    </div>
</div>
<!--发布约会-->
<div class="footer_submit_btn">
    <div class="submit_ico_group">
        <a href="/userc/tracle-pic" class="submit_ico2 submit_ico" id="picbtn">
            <span class="iconfont">&#xe767;</span>
        </a>
        <a href="/userc/tracle-video" class="submit_ico3 submit_ico" id="videobtn">
            <span class="iconfont">&#xe652;</span>
        </a>
        <div class="submit_ico1 submit_ico" id="submitbtn" data-type='0'>
            <span>发布<br />动态</span>
        </div>
    </div>
</div>

<!--约Ta弹出层-->
<div class="raper hide flex flex_center">
    <!--约Ta弹出层-->
    <div class="popup" style="display: none;">
        <div class="popup_con">
            <h3 class="aligncenter">确认删除此动态？</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn color_y">确认</span>
            <span class="footerbtn gopay">取消</span>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#submitbtn').on('tap', function () {
    var data = $(this).data('type');
    switch (data) {
        case '0':
            $('#videobtn').removeClass('moveright').addClass('moveleft');
            $('#picbtn').removeClass('movedown').addClass('moveup');
            $(this).html('<i class="iconfont">&#xe653;</i>');
            $(this).attr('data-type', '1');
            break;
        case '1':
            $('#videobtn').removeClass('moveleft').addClass('moveright');
            $('#picbtn').removeClass('moveup').addClass('movedown');
            $(this).html('<span>发布<br />动态</span>');
            $(this).attr('data-type', '0');
            break;
        default:
            break;
    }
})
</script>
<?php $this->start('script'); ?>
<script>
    var curpage = 1;
    $.util.asyLoadData({gurl: '/tracle/get-tracle-list/', page: curpage, tpl: '#movement-list-tpl', id: '#tracle-list',
        key: 'movements', func: calFunc});
    setTimeout(function () {
        //滚动加载
        $(window).on("scroll", function () {
            $.util.listScroll('tracle-list', function () {
                $.util.asyLoadData({gurl: '/tracle/get-tracle-list/', page: curpage,
                    tpl: '#movement-list-tpl', id: '#tracle-list', more: true, key: 'movements', func: calFunc});
            })
        });
    }, 2000);
    var count = 0;
    function calFunc(data) {
        //返回格式化回调
        $.each(data.movements, function (i, n) {
            count++;
            data.movements[i]['count'] = count;
            if (n.type === 1) {
                data.movements[i]['is_pic'] = true;
            } else {
                data.movements[i]['is_video'] = true;
            }
        })
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
                $obj.find('i').toggleClass('activeico');
                $.util.alert(res.msg);
            }
        })
    }

    LEMON.sys.back('/user/index');
</script>
<?php $this->end('script'); ?>
