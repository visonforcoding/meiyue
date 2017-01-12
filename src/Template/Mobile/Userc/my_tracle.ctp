<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="movement-list-tpl" type="text/html">
    {{#movements}}
    <section>
        <div class="title inner flex flex_justify">
            <div class="tracle_title_left">
                <span class="avatar"><img src="{{user.avatar}}?w=100" onload="$.util.setWH(this)"/></span>
                <h3 class="user_info">
                    <span>{{user.nick}}</span>
                    <time>{{create_time}}</time>
                </h3>
            </div>
           <div class="color_error"> <i>{{#status_checking}}正在审核{{/status_checking}}{{#status_notpass}}审核不通过{{/status_notpass}}</i></div>
        </div>
        <div class="con inner">
            <p class="text">{{body}}</p>
            {{#is_pic}}
            <ul class="piclist_con {{#status_pass}}pic-count{{/status_pass}}" id="imgcontainer_{{id}}" data-index="{{id}}">
                {{#images}}
                <li><img src="{{.}}?w=240" onload="$.util.setWH(this)"/></li>
                {{/images}}
            </ul>
            {{/is_pic}}
            {{#is_video}}
            <div class="piclist_con videolist {{#status_pass}}video-count{{/status_pass}} relpotion">
                <video id="really-cool-video"  class="video-js vjs-default-skin  vjs-16-9" width="100%" height="165px"  poster="{{video_cover}}" controls><source src="{{video}}" type="video/mp4"></video>
            </div>
            {{/is_video}}
        </div>
        <div class="tracle_footer flex flex_justify">
            <div>
                <span class="tracle_footer_info"><i class="iconfont">&#xe65c;</i>{{view_nums}}</span>
                <span class="tracle_footer_info praise"><i class="iconfont">&#xe633;</i> {{praise_nums}}</span>
            </div>
            <div id="del-mv-btn" data-mvtype='{{#is_pic}}1{{/is_pic}}{{#is_video}}2{{/is_video}}' class="{{^status_pass}}cdel{{/status_pass}} tracle_footer_info del" data-id="{{id}}"><i class="iconfont">&#xe650;</i>
            </div>
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
<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1>我的动态</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="tracle_list" id="tracle-list">
    </div>
</div>
<!--发布约会-->
<div class="footer_submit_btn">
    <div class="submit_ico_group">
        <a href="/userc/tracle-pic" class="submit_ico2 submit_ico" id="picbtn">
            <span class="iconfont">&#xe6b9;</span>
        </a>
        <a href="/userc/tracle-video" class="submit_ico3 submit_ico" id="videobtn">
            <span class="iconfont">&#xe6b8;</span>
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

<script>
    var curpage = 1;
    $.util.asyLoadData({gurl: '/userc/get-tracle-list/', page: curpage, tpl: '#movement-list-tpl', id: '#tracle-list',
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
        storeImgs(data.movements);
        $.each(data.movements, function (i, n) {
            count++;
            data.movements[i]['count'] = count;
            if (n.type === 1 || n.type === 3) {
                data.movements[i]['is_pic'] = true;
            } else if(n.type === 2 || n.type === 4){
                data.movements[i]['is_video'] = true;
            }
            var movement = data.movements[i];
            if(movement['images']) {
                $.each(movement['images'], function(j, m) {
                    movement['images'][j] = (movement['images'][j]).replace(/upload/, 'imgs');
                });
            }
            movement['user']['avatar'] = (movement['user']['avatar']).replace(/upload/, 'imgs');
        })
        return data;
    }
    $('#videobtn,#picbtn').bind('click',function(event){
        event.preventDefault();
        var url = $(this).attr('href');
        $.util.ajax({
            url:'/userc/check-user-status',
            func:function(res){
                if(!res.status){
                    $.util.alert(res.msg);
                }else{
                    document.location.href = url;
                }
            }
        })
    });
    $(document).on('tap', '#del-mv-btn', function() {
        var flag = $(this).hasClass('cdel');
        var type = $(this).data('mvtype');
        if(!flag) {
            var video_count = parseInt($('.video-count').length);
            var pic_count = parseInt($('.pic-count').length);
            if(type == '1') {
                if(pic_count <= 1) {
                    $.util.alert('至少要保留一条图片动态');
                    return;
                }
            } else if(type == '2') {
                if(video_count <= 1) {
                    $.util.alert('至少要保留一条视频动态');
                    return;
                }
            }
        }
        var mvid = $(this).data('id');
        $.util.confirm(
            '删除动态',
            '确定要删除此动态吗？',
            function() {
                $.util.ajax({
                    url: '/tracle/delete/' + mvid,
                    method: 'POST',
                    func: function (res) {
                        $.util.alert(res.msg);
                        if(res.status) {
                            location.reload();
                        }
                    }
                })
            },
            null
        );
    });

    allMovements = {};
    function storeImgs(objs) {
        if(objs.length > 0) {
            objs.forEach(function(e) {
                if((e.images).length > 0) {
                    handImgs = [];
                    unHandImgs = e.images
                    unHandImgs.forEach(function(img) {
                        handImgs.push(('<?= getHost(); ?>' + img).replace(/\?.*/, ''));
                    });
                    allMovements[e.id] = handImgs;
                }
            })
        }
    }

    $.util.onbody(function(em, target){
        if(em.id.indexOf('imgcontainer_') != -1){
            if(target.nodeName == 'IMG') target = target.parentNode;
            var index = $(em).data('index');
            var curimg = '<?= getHost(); ?>' + ($(target).find('img').attr('src')).replace(/imgs/, 'upload');
            LEMON.event.viewImg(curimg.replace(/\?.*/, ''), allMovements[index]);
        }
    });

    LEMON.sys.back('/user/index');
</script>
