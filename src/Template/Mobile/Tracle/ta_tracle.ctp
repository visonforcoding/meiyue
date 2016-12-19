<header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1><?= $pageTitle;?></h1>
    </div>
</header>
<div class="wraper">
    <div class="tracle_list" id="tracle-list">

    </div>
</div>

<script id="movement-list-tpl" type="text/html">
    {{#movements}}
    <section>
        <div class="title inner flex flex_justify">
            <div class="tracle_title_left">
                <span class="avatar"><img src="{{user.avatar}}"/></span>
                <h3 class="user_info">
                    <span>{{user.nick}}</span>
                    <time>{{create_time}}</time>
                </h3>
            </div>
            <span class="focusbtn likeIt" data-id="<?= $user->id; ?>">{{#followed}}已关注{{/followed}}{{^followed}}+ 关注{{/followed}}</span>
        </div>
        <div class="con inner">
            <p class="text">{{body}}</p>
            {{#is_pic}}
            <ul class="piclist_con" id="imgcontainer_{{id}}" data-index="{{id}}">
                {{#images}}
                <li><img src="{{.}}?w=160" onload="$.util.setWH(this)"/></li>
                {{/images}}
            </ul>
            {{/is_pic}}
            {{#is_video}}
            <div class="piclist_con videolist">
                <video id="really-cool-video"
                       class="video-js vjs-default-skin  vjs-16-9"
                       preload="auto" width="100%" height="264"
                       poster="{{video_cover}}" controls>
                    <source src="{{video}}" type="video/mp4">
                </video>
            </div>
            {{/is_video}}
        </div>
        <div class="tracle_footer flex flex_justify inner">
            <div>
                <span class="tracle_footer_info">
                    <i class="iconfont">&#xe65c;</i>{{view_nums}}
                </span>
                <span class="tracle_footer_info praise-btn {{#ispraised}}color_y{{/ispraised}}" data-id="{{id}}">
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
        })
        return data;
    }

    $(document).on('tap', '.likeIt', function () {
        var user_id = $(this).data('id');
        followIt(user_id);
    });
    function followIt(id) {
        $.util.ajax({
            url: '/user/follow',
            data: {id: id},
            func: function (res) {
                if(res.status) {
                    if($('.likeIt').first().text() == '+ 关注') {
                        $('.likeIt').text('取消关注');
                    } else {
                        $('.likeIt').text('+ 关注');
                    }
                }
            }
        })
    }

    $(document).on('tap', '.praise-btn', function() {
        mid = $(this).data('id');
        obj = $(this);
        $.util.ajax({
            url: '/tracle/praise/' + mid,
            func: function (res) {
                if(res.status) {
                    curpriase = parseInt(obj.find('.praise-num').first().text());
                    if(res.act == 1) {
                        curpriase ++;
                    } else {
                        if(curpriase > 0) {
                            curpriase --;
                        }
                    }
                    obj.toggleClass('color_y');
                    obj.find('.praise-num').first().text(curpriase);
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
        console.log(allMovements);
        if(em.id.indexOf('imgcontainer_') != -1){
            if(target.nodeName == 'IMG') target = target.parentNode;
            var index = $(em).data('index');
            var curimg = '<?= getHost(); ?>' + ($(target).find('img').attr('src')).replace(/imgs/, 'upload');
            LEMON.event.viewImg(curimg.replace(/\?.*/, ''), allMovements[index]);
        }
    });

</script>
