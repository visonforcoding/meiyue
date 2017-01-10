<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1><?= $pageTitle;?></h1>
    </div>
</header> -->
<div class="wraper">
    <div class="tracle_list" id="tracle-list">
    </div>
</div>

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
            {{#followed}}<div class="button btn_light likeIt" data-id="{{user.id}}">已关注</div>{{/followed}}
            {{^followed}}<div class="button btn_dark_t likeIt" data-id="{{user.id}}">+ 关注</div>{{/followed}}
        </div>
        <div class="con inner">
            <p class="text">{{body}}</p>
            {{#is_pic}}
            <ul class="piclist_con" id="imgcontainer_{{id}}" data-index="{{id}}">
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
        <div class="tracle_footer flex flex_justify inner">
            <div>
                <span class="tracle_footer_info">
                    <i class="iconfont">&#xe65c;</i>{{view_nums}}
                </span>
                <span class="tracle_footer_info praise praise-btn {{#ispraised}}color_y{{/ispraised}}" data-id="{{id}}">
                    <i class="iconfont">&#xe633;</i><span class="praise-num">{{praise_nums}}</span>
                </span>
            </div>
        </div>
    </section>
    {{/movements}}
</script>

<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<?php $this->end('static') ?>
<?php $this->start('css')?>
<style>
    .video-js{
        background-color: #000;
        padding: 0 .1rem;
    }
</style>
<?php $this->end('css')?>

<script>
    var curpage = 1;
    $.util.asyLoadData({
        gurl: '/tracle/get-ta-tracles/',
        page: curpage,
        query: '/<?= $user->id;?>',
        tpl: '#movement-list-tpl',
        id: '#tracle-list',
        key: 'movements',
        func: calFunc});
    setTimeout(function () {
        //滚动加载
        $(window).on("scroll", function () {
            $.util.listScroll('tracle-list', function () {
                $.util.asyLoadData({
                    gurl: '/tracle/get-ta-tracles/',
                    page: curpage,
                    query: '/<?= $user->id;?>',
                    tpl: '#movement-list-tpl',
                    id: '#tracle-list',
                    more: true,
                    key: 'movements',
                    func: calFunc
                });
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
            if (n.type === 1) {
                data.movements[i]['is_pic'] = true;
            } else if(n.type === 2){
                data.movements[i]['is_video'] = true;
            } else if(n.type === 3){
                data.movements[i]['is_pic'] = true;
            } else if(n.type === 4){
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

    $(document).on('tap', '.likeIt', function () {
        var user_id = $(this).data('id');
        followIt(user_id);
    });
    function followIt(id) {
        if($('.likeIt').text()=='已关注') {
            $.util.confirm(
                '取消关注',
                '确认不再关注此人？',
                function() {
                    follow(id);
                },
                null
            );
        } else {
            follow(id);
        }
    }

    function follow(id) {
        $.util.ajax({
            url: '/user/follow',
            data: {id: id},
            func: function (res) {
                if(res.status) {
                    if($('.likeIt').first().text() == '+ 关注') {
                        $.util.alert('关注成功');
                        $('.likeIt').text('已关注');
                        $('.likeIt').removeClass('btn_dark_t');
                        $('.likeIt').addClass('btn_light');
                    } else {
                        $('.likeIt').text('+ 关注');
                        $('.likeIt').removeClass('btn_light');
                        $('.likeIt').addClass('btn_dark_t');
                    }
                }
            }
        })
    }

    $(document).on('tap', '.praise-btn', function() {
        mid = $(this).data('id');
        curpriase = parseInt($(this).find('.praise-num').first().text());
        if($(this).hasClass('color_y')) {
            $(this).find('.praise-num').first().text(curpriase - 1);
        } else {
            $(this).find('.praise-num').first().text(curpriase + 1);
        }
        $(this).toggleClass('color_y');
        $.util.ajax({
            url: '/tracle/praise/' + mid,
            func: function (res) {
                if(res.status) {
                    /*curpriase = parseInt(obj.find('.praise-num').first().text());
                    if(res.act == 1) {
                        curpriase ++;
                    } else {
                        if(curpriase > 0) {
                            curpriase --;
                        }
                    }
                    obj.toggleClass('color_y');
                    obj.find('.praise-num').first().text(curpriase);*/
                } else {
                    $.util.alert(res.msg);
                }
            }
        })
    })


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

</script>
