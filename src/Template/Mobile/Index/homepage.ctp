<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="location.href='/index/index'">&#xe602;</span>
        <h1><?= $user->nick; ?></h1>
        <span class="iconfont r_btn ico" onclick="location.href='/user/share'">&#xe62d;</span>
    </div>
</header> -->
<div class="wraper">
    <div class="home_page">
        <div class="header" style="overflow:hidden">
            <img src="<?= $user->avatar; ?>" class="responseimg"/>
            <!--<span class="l_btn iconfont">&#xe602;</span>
            <span class="r_btn iconfont">&#xe62d;</span>-->
            <?php if($user->status == 3): ?><span class="identify-info  id-btn">视频已认证</span><?php endif; ?>
            <?php if($user->id_status == 3): ?><span class="identify-info video-btn">身份已认证</span><?php endif; ?>
        </div>
     </div>
    <!--基本信息-->
    <div class="home_page_basic">
        <h3 class="aligncenter">
            <span class="home_name"><b><?= $user->nick ?></b></span>
            <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
            <span class="vip"><img src="/mobile/images/my-hot.png" class="responseimg"/></span>
        </h3>
        <div class="home_name_info aligncenter">
            <i class="iconfont color_y"><?= ($user->gender)?'&#xe61d;':'&#xe61c;'; ?></i> <?= $age ?> <i class="job"><?= $user->profession ?></i> <i class="address"><?= $user->city ?> <i class="iconfont">&#xe623;</i><i class='distance'><?= $distance ?></i></i>
        </div>
        <!--<div class="commend aligncenter">
            <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_light">&#xe62a;</i>
            <span class="total">4.2分</span>
        </div>-->
        <ul class="otherinfo flex flex_justify bdbottom">
            <li><span class="t_desc"><?= ($user->height)?$user->height.$user->cup:'--' ?></span><span class="b_desc">身高</span></li>
            <li><span class="t_desc"><?= ($user->weight)?$user->weight.'kg':'--' ?></span><span class="b_desc">体重</span></li>
            <li><span class="t_desc"><?= ($user->bwh)?$user->bwh:'--' ?></span><span class="b_desc">三围</span></li>
            <li><span class="t_desc"><?= ($birthday)?$birthday:'--' ?></span><span class="b_desc">生日</span></li>
        </ul>
    </div>

    <!--图片 && 视频展示-->
    <?php if (($user->status == 3) && (@unserialize($user->images) || $user->video)): ?>
    <div class="home_pic_info mt40">
        <ul class="inner flex">
            <?php if (@unserialize($user->images)): ?>
                <?php foreach(array_slice(unserialize($user->images), 0, 3) as $img): ?>
                    <li class="img-item"><img src="<?= createImg($img) ?>?w=160" onload="$.util.setWH(this);"/></li>
                <?php endforeach; ?>
                <li onclick="checkBrownR(1);">
                    <a class='ablock' >
                        <img src="<?= unserialize($user->images)[3]; ?>?w=160" onload="$.util.setWH(this);"/>
                        <span>更多私房</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if($user->video): ?>
        <div id="see-basic-mv" class="inner home_video mt20  flex flex_center  relpotion init">
            <?php if($browseRight == SerRight::OK_CONSUMED): ?>
                <video preload="preload" poster="<?= $user->video_cover; ?>"><source src="<?= $user->video; ?>" type="video/mp4"></video>
            <?php else: ?>
                <img src="<?= $user->video_cover ?>" />
                <div class='play-icon'><i class='iconfont'>&#xe6b8;</i></div>
            <?php endif; ?>
        </div>
        <?php endif;?>
    </div>
    <?php endif; ?>
    <!--Ta的资料-->
    <div class="home_basic_mark mt40">
        <div class="inner">
            <div class="title">
                <h3>TA的资料</h3>
            </div>
            <div class="con">
                <?php if($user->zodiac): ?><a><?= Zodiac::getStr($user->zodiac);?></a><?php endif;?>
                <?php if($user->birthday): ?><a>生日 <?= $user->birthday;?></a><?php endif;?>
                <?php foreach($user->tags as $item): ?>
                    <a><?= $item->name; ?></a>
                <?php endforeach; ?>
            </div>
            <?php if(trim($user->career)): ?>
            <div class="bottom">
                <div class="title">工作经验:</div>
                <p><?= $user->career ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!--Ta的技能-->
    <?php if(count($user->user_skills) > 0): ?>
    <div class="home_basic_ability mt40">
        <div class="">
            <div class="title inner">
                <h3>TA的技能</h3>
            </div>
            <ul class="outerblock">
                <?php foreach (array_slice($user->user_skills, 0, 3) as $user_skill): ?>
                    <li class="itms_list">
                        <div class="items flex flex_justify">
                            <span class="items_name">
                                <i class="iconfont color_y"><?= $user_skill->skill->class ?></i>
                                <?= $user_skill->skill->name ?>
                            </span>
                            <div>
                                <span class="price"><i><?= $user_skill->cost->money ?></i>美币/h</span>
                                <a class="date data-ta" data-id="<?= $user_skill->id; ?>">约TA</a>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                <?php if(count($user->user_skills) > 3): ?>
                <li class="itms_list" onclick="window.location.href = '/index/find-skill/<?=$user->id?>';">
                    <div class="items flex flex_center more">
                        <i class="iconfont more color_y">&#xe62f;</i>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <?php endif;?>

    <!--查看Ta的微信-->
    <ul class="home_seach_info outerblock mt40">
        <?php if($user->wx_ishow && $user->wxid): ?>
        <li>
            <a name="showWx" class="items flex flex_justify" >
                <span class="seach_name">查看TA的微信</span>
                <span id="showWx" class="golook  color_y">点击查看</span>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->hasjoin): ?>
        <li>
            <a class="items flex flex_justify" href="javascript:toJoind();">
                <span class="seach_name">Ta的约会/派对</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <?php endif; ?>
        <?php if($user->charm > 0): ?>
        <li>
            <a class="items flex flex_justify" href="javascript:toVoted();">
                <span class="seach_name">TA的选美</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
    <!--其它资料-->
    <ul class="home_seach_otherinfo outerblock mt40">
        <li class='nobottom'>
            <a class="items flex flex_justify" href="#this">
                <span class="seach_name importext">其它资料</span>
                <span class="golook"><i class="iconfont r_icon"></i></span>
            </a>
        </li>
        <?php if($user->state): ?>
        <li>
            <div class="items flex">
                <span class="seach_name">情感状态</span>
                <span class="golook"><?= UserState::getStatus($user->state);?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if(trim($user->hometown)): ?>
        <li>
            <div class="items flex">
                <span class="seach_name">TA的家乡</span>
                <span class="golook"><?= $user->hometown ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if(trim($user->place)): ?>
            <li>
                <div class="items flex">
                    <span class="seach_name">常出没地</span>
                    <span class="golook"><?= $user->place ?></span>
                </div>
            </li>
        <?php endif; ?>
        <?php if($user->food): ?>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的美食</span>
                <span class="golook"><?= $user->food ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if($user->music): ?>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的音乐</span>
                <span class="golook"><?= $user->music ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if($user->movie): ?>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的电影</span>
                <span class="golook"><?= $user->movie ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if($user->sport): ?>
        <li>
            <div class="items flex">
                <span class="seach_name sport_items">喜欢的运动/娱乐</span>
                <span class="golook"><?= $user->sport ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if($user->sign): ?>
        <li>
            <div class="items items-con flex">
                <span class="seach_name">个人签名</span>
                <span class="golook"><?= $user->sign ?></span>
            </div>
        </li>
        <?php endif; ?>
    </ul>
</div>
<div id="send-gift" class="togift flex flex_center">
    <i class="iconfont">&#xe614;</i>
</div>
<div style="height:1.6rem"></div>
<!--底部-->
<div class="home_page_footer">
    <ul id="dibu-touch" class="clearfix flex flex_justify
        <?= (count($user->user_skills) == 0)?'changeli':''; ?>">
        <?php if ($isFollow): ?>
            <li>
                <a id="focusIt">
                    <i class="iconfont">&#xe63d;</i><i class="status-txt">已关注</i>
                </a>
            </li>|
        <?php else: ?>
            <li>
                <a id="focusIt" class="active">
                    <i class="iconfont">&#xe63d;</i><i class="status-txt">关注</i>
                </a>
            </li>|
        <?php endif; ?>
        <?php if (count($user->user_skills) > 0): ?>
        <li>
            <a id="dateit">
                <i class="iconfont">&#xe632;</i>约TA
            </a>
        </li>|
        <?php endif; ?>
        <li id="chat-btn">
            <a>
                <i class="iconfont">&#xe603;</i>私聊
            </a>
        </li>
    </ul>
</div>
<!--弹出层-->
<!--约Ta弹出层-->
<div class="raper hide">
    <div class='fullwraper flex flex_center'>
    <!--约Ta弹出层-->
    <div class="popup showxpay" hidden>
        <div class="popup_con">
            <h3 class="aligncenter">需支付100美币才能看到她的微信</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn cancel">取消</span>
            <span class="footerbtn gopay">立即支付</span>
        </div>
    </div>

    <!--查看微信弹出层-->
    <div id="showx-container" class="popup wx_popup showx" hidden>

    </div>
    </div>
</div>

<script id="wxshower-tpl" type="text/html">
<div class="popup_con">
    <h3 class="aligncenter"><span class="wx_user">{{wxer.nick}}的微信<i class="iconfont color_wx">&#xe641;</i></span></h3>
    <ul class="wx_copy_con">
        <li class="flex flex_justify">
            <span class="wxidtxt wx_l_con">微信号：<i>{{wxer.wxid}}</i></span><span class="copywxid wx_r_copy">复制</span>
        </li>
        <li class="flex flex_justify">
            <span class="anhaotxt wx_l_con">暗&nbsp;&nbsp;&nbsp;号：<i>{{anhao}}</i></span><span class="copyanhao wx_r_copy">复制</span>
        </li>
    </ul>
    <h3 class="wx_tips smallarea">添加微信时，注意一定要填写暗号</h3>
    <p class="wx_care_tips smallarea">若微信号为空假号，点击此处<a onclick="tel();" class="color_ts">举报</a></p>
</div>
<span class="closed"><i class="iconfont">&#xe644;</i></span>
</script>

<?php $this->start('script'); ?>
<script src="/mobile/js/mustache.min.js"></script>
<script>
    LEMON.sys.back('/index/index');
    LEMON.sys.setTopRight('分享')
    window.onTopRight = function () {
        shareBanner();
    }

    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/index/homepage/'.$user->id; ?><?= isset($loginer)?'?ivc='.$loginer->invit_code:'';?>';
        window.shareConfig.title = '一人宅家好无聊，想去疯玩没人陪？';
        window.shareConfig.imgUrl = '<?= getHost().(isset($user)?$user->avatar:'/upload/ico/meiyue.png');?>';
        var share_desc = '上美约APP，约K歌、美食、运动、工作，同城上万高颜值美女在线';
        share_desc && (window.shareConfig.desc = share_desc);
        LEMON.show.shareBanner();
    }
    $.util.checkShare();
</script>
<script>
    $('.data-ta').on('tap', function() {
        var dateid = $(this).data('id');
        $.util.checkLogin('/date-order/order-skill/' + dateid);
    })

    function toVoted() {
        $.util.checkLogin('/user/voted/<?=$user->id?>');
    }

    function toJoind() {
        location.href='/index/her-join-view/<?=$user->id?>';
    }

    $('#send-gift').on('click', function(event) {
        event.stopPropagation();
        $.util.checkLogin('/gift/index/<?= $user->id; ?>');
    });

    $('#focusIt').on('click', function (event) {
        //加关注
        event.stopPropagation();
        var id = <?= $user->id ?>;  //该对象
        var obj = $('#focusIt');
        if (!obj.hasClass('active')) {
            //取消关注
            $.util.confirm('取消关注', '你确定取消关注她吗?', function () {
                followIt(id,obj);
            });
        } else {
            followIt(id,obj);
        }

    });
    function followIt(id,obj) {
        $.util.ajax({
            url: '/user/follow',
            data: {id: id},
            func: function (res) {
                if(res.status){
                    if(obj.hasClass('active')){
                        $.util.alert('关注成功');
                        obj.find('.status-txt').first().text('已关注');
                    }else{
                        obj.find('.status-txt').first().text('关注');
                    }
                    obj.toggleClass('active');
                }
                $.util.alert(res.msg);
            }
        })
    }
    $('#dateit').on('click',function(event){
        event.stopPropagation();
        $.util.ajax({
            url:'/user/clogin',
            func:function(res){
                 if(res.status){
                     window.location.href = '/index/find-skill/<?=$user->id?>';
                 }
            }
        })
    })


    function checkBrownR(action) {
        if(!$.util.checkLogin()) {
            return;
        }
        $.util.ajax({
            url:'/tracle/browse/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                switch(res.right) {
                    case <?= SerRight::OK_CONSUMED; ?>:
                        switch(action) {
                            case 1:
                                location.href = '/tracle/ta-tracle/<?=$user->id?>';
                                break;
                            case 2:
                                initVideo();
                                break;
                        }
                        break;
                    case <?= SerRight::NO_HAVENUM; ?>:
                        $.util.confirm(
                            '查看美女动态',
                            '将会消耗一个查看名额',
                            function() {
                                switch(action) {
                                    case 1:
                                        location.href = '/tracle/ta-tracle/<?=$user->id?>';
                                        break;
                                    case 2:
                                        initVideo();
                                        break;
                                }
                            },
                            null
                        );
                        break;
                    case <?= SerRight::NO_HAVENONUM; ?>:
                        $.util.confirm(
                            '查看美女动态',
                            '需要成为会员才能查看人家的动态哦~',
                            function() {
                                window.location.href = '/userc/vip-buy?reurl=/index/homepage/<?= $user->id; ?>';
                            },
                            null,
                            null,
                            '购买会员'
                        );
                        break;
                }
            }
        })
    }


    function initVideo() {
        if($('#see-basic-mv').hasClass('init')) {
            $.util.ajax({
                url:'/tracle/see-bvideo/<?=$user->id?>',
                method: 'POST',
                func:function(res){
                    console.log(res);
                    if(res.status) {
                        $('#see-basic-mv').html('<video id="see-basic-mv" controls="controls" preload="preload" poster="'+ res.video_cover +'" autoplay="autoplay"><source src="'+ res.video +'" type="video/mp4"></video>');
                        $(this).removeClass('init')
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            })
        }
    }


    /**
     * 播放基本视频
     */
    $('#see-basic-mv').on('click', function(event) {
        event.stopPropagation();
        checkBrownR(2);
    })


    $.util.tap($('#showWx'), function() {
        if(!$.util.isLogin()) {
            $.util.alert('请先登录');
            setTimeout(function() {
                LEMON.event.login();
            }, 1000)
            return;
        }
        $.util.showPreloader();
        $.util.ajax({
            url:'/index/check-wx-rig/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                $.util.hidePreloader();
                if(res.status) {
                    showx();
                } else {
                    $('.raper').removeClass('hide');
                    $('.raper .showxpay').show();
                    $.util.tap($('.raper .cancel'), function() {
                        $('.raper').addClass('hide');
                        $('.raper .showxpay').hide();
                        $('.raper .cancel').off('click');
                    });
                    $.util.tap($('.raper .gopay'), function() {
                        $('.raper').addClass('hide');
                        $('.raper .showxpay').hide();
                        if(res.moneycheck) {
                            showmbpay();
                        } else {
                            $.util.confirm('美币不足','您的美币余额不足，前往充值美币？', function() {
                                showxpay();
                            }, null);
                        }
                        $('.raper .gopay').off('click');
                    });
                }
            }
        })
    });

    function showmbpay() {
        $.util.showPreloader();
        $.util.ajax({
            url:'/index/pay4wx/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                $.util.hidePreloader();
                $.util.alert(res.msg);
                if(res.status) {
                    showx();
                }
            }
        })
    }

    /**
     * 显示微信查看微信支付提示
     */
    function showxpay() {
        $.util.alert('正在生成支付单...');
        $.util.showPreloader();
        $.util.ajax({
            url:'/index/create-payorder/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                $.util.hidePreloader();
                $.util.alert(res.msg);
                if(res.status) {
                    window.location.href= '/wx/pay/' + res.orderid + '/查看美女微信支付金?redurl=/index/homepage/<?=$user->id?>#showWx';
                }
            }
        })
    }


    /**
     * 显示微信框
     */
    function showx() {
        $.util.ajax({
            url:'/index/check-wx-rig/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                if(res.status) {
                    var template = $('#wxshower-tpl').html();
                    Mustache.parse(template);   // optional, speeds up future uses
                    var rendered = Mustache.render(template, res.userwx);
                    $('#showx-container').html(rendered);
                    $('.raper').removeClass('hide');
                    $('.raper .showx').show();
                    $('.raper .copywxid').on('click', function() {
                        //alert($('.raper .wxidtxt i').text());
                        LEMON.sys.copy2Clipper($('.raper .wxidtxt i').text());
                        $.util.alert('复制成功');
                    });
                    $('.raper .copyanhao').on('click', function() {
                        //alert($('.raper .anhaotxt i').text());
                        LEMON.sys.copy2Clipper($('.raper .anhaotxt i').text());
                        $.util.alert('复制成功');
                    });
                    $('.raper .closed').on('click', function() {
                        $('.raper').addClass('hide');
                        $('.raper .showx').hide();
                    });
                } else {
                    $.util.alert(res.msg);
                }
            }
        })
    }

    $(document).on('click', '.img-item', function() {
        var imgs = [];
        $('.img-item img').each(function() {
            imgs.push((this.src).replace(/\?.*/, ''));
        });
        var curimg = $(this).find('img').first().attr('src');
        var imgpath = '<?= getHost(); ?>' + curimg;
        var status = <?= isset($browseRight)?$browseRight:-1 ?>;
        var user_id = <?= isset($loginer)?$loginer->id:-1; ?>;
        var view_id = <?= isset($user)?$user->id:-1; ?>;
        var to_url = '';
        <?php if(SerRight::OK_CONSUMED == $browseRight): ?>
        to_url = '/tracle/ta-tracle/<?=$user->id?>';
        <?php elseif(SerRight::NO_HAVENONUM == $browseRight): ?>
        to_url = '/userc/vip-buy?reurl=/index/homepage/<?= $user->id; ?>';
        <?php elseif(SerRight::NO_HAVENUM == $browseRight): ?>
        to_url = '/tracle/ta-tracle/<?=$user->id?>';
        <?php endif; ?>
        LEMON.event.viewImgExt(imgpath.replace(/\?.*/, ''), imgs, status, user_id, view_id, to_url);
    });

    function tel() {
        $.util.confirm(
            '联系客服',
            '0755-33580266',
            function() {
                LEMON.event.tel('0755-33580266');
            },
            null,
            null,
            '拨打'
        )
    }

    $.util.tap($('#chat-btn'), function() {
        checkim();
    });

    function checkim() {
        $.util.ajax({
            url:'/user/check-chat/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                switch(res.right) {
                    case <?= SerRight::OK_CONSUMED; ?>:
                        chat(res.accid);
                        break;
                    case <?= SerRight::NO_HAVENUM; ?>:
                        $.util.confirm(
                            '私聊',
                            '将会消耗一个聊天名额',
                            function() {
                                consumeChat();
                            },
                            null
                        );
                        break;
                    case <?= SerRight::NO_HAVENONUM; ?>:
                        $.util.confirm(
                            '私聊美女',
                            '需要成为会员才能私聊美女哦~',
                            function() {
                                window.location.href = '/userc/vip-buy?reurl=/index/homepage/<?= $user->id; ?>';
                            },
                            null,
                            null,
                            '购买会员'
                        );
                        break;
                }
            }
        })
    }


    function consumeChat() {
        $.util.showPreloader();
        $.util.ajax({
            url:'/user/consume-chat/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                $.util.hidePreloader();
                if(res.status) {
                    chat(res.accid);
                } else {
                    $.util.alert(res.msg);
                }
            }
        })
    }


    $('#dibu-touch').on('click', function(event) {
        event.stopPropagation();
    });


    /**
     * 聊天
     * @param accid
     */
    function chat(accid) {
        var param = {};
        var accid = accid;
        var nick = '<?= $user->nick; ?>';
        var avatar = '<?= getHost().$user->avatar; ?>';
        var user_id = '<?= $user->id; ?>';
        param['imaccid'] = accid;
        param['nick'] = nick;
        param['avatar'] = avatar;
        param['id'] = user_id;
        //LEMON.event.imTalk(param);
        var res = {obj:param};
        $.util.openTalk(res);
    }
</script>
<?php $this->end('script'); ?>
