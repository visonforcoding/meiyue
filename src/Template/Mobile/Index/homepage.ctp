<div class="wraper">
    <div class="home_page">
        <div class="header" style="overflow:hidden">
            <img src="<?= $user->avatar; ?>" class="responseimg"/>
            <!--<span class="l_btn iconfont">&#xe602;</span>
            <span class="r_btn iconfont">&#xe62d;</span>-->
            <span class="identify-info  id-btn">视频已认证</span>
            <span class="identify-info video-btn">身份已认证</span>
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
            <i class="iconfont color_y"><?= ($user->gender)?'&#xe61d;':'&#xe61c;'; ?></i> <?= $age ?> <i class="job"><?= $user->profession ?></i> <i class="address"><?= $user->city ?> <i class="iconfont">&#xe623;</i> <?= $distance ?></i>
        </div>
        <!--<div class="commend aligncenter">
            <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_light">&#xe62a;</i>
            <span class="total">4.2分</span>
        </div>-->
        <ul class="otherinfo flex flex_justify bdbottom">
            <li><span class="t_desc"><?= ($user->height)?$user->height.'cm':'--' ?></span><span class="b_desc">身高</span></li>
            <li><span class="t_desc"><?= ($user->weight)?$user->weight.'kg':'--' ?></span><span class="b_desc">体重</span></li>
            <li><span class="t_desc"><?= ($user->bwh)?$user->bwh:'--' ?></span><span class="b_desc">三围</span></li>
            <li><span class="t_desc"><?= ($birthday)?$birthday:'--' ?></span><span class="b_desc">生日</span></li>
        </ul>
    </div>
    <!--图片 && 视频展示-->
    <?php if (@unserialize($user->images) || $user->video): ?>
    <div class="home_pic_info mt40">
        <ul class="inner flex">
            <?php if (@unserialize($user->images)): ?>
                <?php foreach(array_slice(unserialize($user->images), 0, 3) as $img): ?>
                    <li><img src="<?= createImg($img) ?>"/></li>
                <?php endforeach; ?>
                <li id="see-movements">
                    <a class='ablock' >
                        <img src="/mobile/images/avatar.jpg"/>
                        <span>更多私房</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if($user->video): ?>
        <div class="inner home_video mt20">
           <video width="100%" height="165px" controls="controls" preload="preload" src="<?= $user->video ?>" poster="<?= $user->video_cover ?>">
            </video>
        </div>
        <?php endif;?>
    </div>
    <?php endif; ?>
    <!--Ta的资料-->
    <div class="home_basic_mark mt40">
        <div class="inner">
            <div class="title">
                <h3>Ta的资料</h3>
            </div>
            <div class="con">
                <?php if($user->zodiac): ?><a href="#this"><?= Zodiac::getStr($user->zodiac);?></a><?php endif;?>
                <?php if($user->birthday): ?><a href="#this">生日 <?= $user->birthday;?></a><?php endif;?>
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
                <h3>Ta的技能</h3>
            </div>
            <ul class="outerblock">
                <?php foreach (array_slice($user->user_skills, 0, 3) as $user_skill): ?>
                    <li class="itms_list">
                        <div class="items flex flex_justify">
                            <span class="items_name">
                                <i class="iconfont color_y">&#xe631;</i>
                                <?= $user_skill->skill->name ?>
                            </span>
                            <div>
                                <span class="price"><i><?= $user_skill->cost->money ?></i>美币/h</span>
                                <a href="/date-order/order-skill/<?= $user_skill->id; ?>" class="date">约TA</a>
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
            <a id="showWx" class="items flex flex_justify" >
                <span class="seach_name">查看Ta的微信</span>
                <span class="golook">点击查看<i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a class="items flex flex_justify">
                <span class="seach_name">Ta的约会/派对</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <li>
            <a class="items flex flex_justify" href="/user/voted/<?=$user->id?>">
                <span class="seach_name">Ta的评选</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
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
<div class="togift flex flex_center"
     onclick="window.location.href='/gift/index/<?= $user->id; ?>';event.stopPropagation(); ">
    <i class="iconfont">&#xe614;</i>
</div>
<div style="height:1.6rem"></div>
<!--底部-->
<div class="home_page_footer">
    <ul class="clearfix flex flex_justify
        <?= (count($user->user_skills) == 0)?'changeli':''; ?>">
        <?php if ($isFollow): ?>
            <li>
                <a id="focusIt">
                    <i class="iconfont">&#xe63d;</i><i class="status-txt">已关注</i>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a id="focusIt" class="active">
                    <i class="iconfont">&#xe63d;</i><i class="status-txt">关注</i>
                </a>
            </li>
        <?php endif; ?>
        <?php if (count($user->user_skills) > 0): ?>
        <li>
            <a id="dateit">
                <i class="iconfont">&#xe632;</i>约Ta
            </a>
        </li>
        <?php endif; ?>
        <li>
            <a href="#this">
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
    <p class="wx_care_tips smallarea">若微信号为空假号，点击此处<a href="#this" class="color_ts">举报</a></p>
</div>
<span class="closed"><i class="iconfont">&#xe644;</i></span>
</script>

<?php $this->start('script'); ?>
<script src="/mobile/js/mustache.min.js"></script>
<script>
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
                if(obj.hasClass('active')){
                    obj.find('.status-txt').first().text('已关注');
                }else{
                    obj.find('.status-txt').first().text('关注');
                }
                obj.toggleClass('active');
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


    $('#see-movements').on('click', function() {
        $.util.ajax({
            url:'/tracle/browse/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                switch(res.right) {
                    case <?= SerRight::OK_CONSUMED; ?>:
                        window.location.href = '/tracle/ta-tracle/<?=$user->id?>';
                        break;
                    case <?= SerRight::NO_HAVENUM; ?>:
                        $.util.confirm(
                            '查看美女动态',
                            '将会消耗一个查看名额',
                            function() {
                                window.location.href = '/tracle/ta-tracle/<?=$user->id?>';
                            },
                            null
                        );
                        break;
                    case <?= SerRight::NO_HAVENONUM; ?>:
                        $.util.confirm(
                            '查看美女动态',
                            '需要成为会员才能查看人家的动态哦~',
                            function() {
                                window.location.href = '/userc/vip-buy';
                            },
                            null,
                            null,
                            '购买会员'
                        );
                        break;
                }
            }
        })
    });


    $('#showWx').on('tap', function() {
        $.util.ajax({
            url:'/index/check-wx-rig/<?=$user->id?>',
            method: 'POST',
            func:function(res){
                console.log(res);
                if(res.status) {
                    showx();
                } else {
                    showxpay();
                }

            }
        })
    });


    /**
     * 显示微信查看微信支付提示
     */
    function showxpay() {
        $('.raper').removeClass('hide');
        $('.raper .showxpay').show();
        $('.raper .cancel').on('click', function() {
            $('.raper').addClass('hide');
            $('.raper .showxpay').hide();
        });
        $('.raper .gopay').on('click', function() {
            $.util.ajax({
                url:'/index/pay4wx/<?= $user->id;?>',
                method: 'POST',
                func:function(res){
                    if(res.status) {
                        $('.raper').addClass('hide');
                        $('.raper .showxpay').hide();
                        showx();
                    } else {
                        $.util.alert('支付失败');
                        $('.raper').addClass('hide');
                        $('.raper .showxpay').hide();
                    }
                }
            })
        });
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
                        window.clipboardData.setData("Text", $('.raper .wxidtxt i').text());
                        $.util.alert('复制成功');
                    });
                    $('.raper .copyanhao').on('click', function() {
                        window.clipboardData.setData("Text", $('.raper .anhaotxt i').text());
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

    LEMON.sys.back('/index/index');
    LEMON.event.unrefresh();
    LEMON.sys.setTopRight('分享')
    window.onTopRight = function () {
        $.util.alert('点击了分享');
    }
</script>
<?php $this->end('script'); ?>
