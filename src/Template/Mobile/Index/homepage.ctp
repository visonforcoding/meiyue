<header>
    <div class="home_page" style='display:none;'>
        <div class="header">
            <span class="l_btn iconfont">&#xe602;</span>
            <span class="r_btn iconfont">&#xe62d;</span>
        </div>
    </div>
</header>
<div class="wraper">
    <div class="home_page">
        <div class="header">
            <span class="identify-info video-btn">视频已认证</span>
            <span class="identify-info  id-btn">身份已认证</span>
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
            <i class="iconfont color_y">&#xe61d;</i> <?= $age ?> <i class="job"><?= $user->profession ?></i> <i class="address"><?= $user->city ?> <i class="iconfont">&#xe623;</i> <?= $distance ?></i>
        </div>
        <div class="commend aligncenter">
            <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_light">&#xe62a;</i>
            <span class="total">4.2分</span>
        </div>
        <ul class="otherinfo flex flex_justify bdbottom">
            <li><span class="t_desc"><?= ($user->height)?$user->height.'cm':'--' ?></span><span class="b_desc">身高</span></li>
            <li><span class="t_desc"><?= ($user->weight)?$user->weight.'kg':'--' ?></span><span class="b_desc">体重</span></li>
            <li><span class="t_desc"><?= ($user->bwh)?$user->bwh:'--' ?></span><span class="b_desc">三围</span></li>
            <li><span class="t_desc"><?= ($birthday)?$birthday:'--' ?></span><span class="b_desc">生日</span></li>
        </ul>
    </div>
    <!--图片 && 视频展示-->
    <div class="home_pic_info mt40">
        <ul class="inner flex">
            <?php if (@unserialize($user->images)): ?>
                <?php
                    $imgs = unserialize($user->images);
                    $lg = count($imgs);
                    $max = 3;
                    if($lg < 3) {
                        $max = $lg;
                    }
                ?>
                <?php for ($i=1; $i <= $max; $i++): ?>
                    <li><img src="<?= createImg($imgs[$i]) ?>"/></li>
                <?php endfor; ?>
                <li id="see-movements">
                    <a class='ablock' >
                        <img src="/mobile/images/avatar.jpg"/>
                        <span>更 多 私 房</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="inner home_video mt20">

           <video width="100%" height="auto" controls="controls" autoplay="autoplay" src="/upload/user/video/58457261d9674.mp4">
            </video>
            <!-- <video src="<?= $user->video ?>" controls="controls" height="auto" width="auto"></video> -->
        </div>
    </div>
    <!--Ta的资料-->
    <div class="home_basic_mark mt40">
        <div class="inner">
            <div class="title">
                <h3>Ta的资料</h3>
            </div>
            <div class="con">
                <a href="#this">处女座</a>
                <a href="#this">生日 1994/02/09</a>
            </div>
            <div class="bottom">
                <div class="title">工作经验:</div>
                <p><?= $user->career ?></p>
            </div>
        </div>
    </div>
    <!--Ta的技能-->
    <div class="home_basic_ability mt40">
        <div class="">
            <div class="title inner">
                <h3>Ta的技能</h3>
            </div>
            <ul class="outerblock">
                <?php foreach ($user->user_skills as $user_skill): ?>
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
                <li class="itms_list">
                    <div class="items flex flex_center more">
                        <i class="iconfont more color_y">&#xe62f;</i>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!--查看Ta的微信-->
    <ul class="home_seach_info outerblock mt40">
        <li>
            <a id="showWx" class="items flex flex_justify" >
                <span class="seach_name">查看Ta的微信</span>
                <span class="golook">点击查看<i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <li>
            <a class="items flex flex_justify">
                <span class="seach_name">Ta的约会/排队</span>
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
        <li>
            <div class="items flex">
                <span class="seach_name">情感状态</span>
                <span class="golook">单身中</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">TA的家乡</span>
                <span class="golook"><?= $user->hometown ?></span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的美食</span>
                <span class="golook"><?= $user->food ?></span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的音乐</span>
                <span class="golook"><?= $user->music ?></span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的电影</span>
                <span class="golook"><?= $user->movie ?></span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name sport_items">喜欢的运动/娱乐</span>
                <span class="golook"><?= $user->sport ?></span>
            </div>
        </li>
        <li>
            <div class="items items-con flex">
                <span class="seach_name">个人签名</span>
                <span class="golook"><?= $user->sign ?></span>
            </div>
        </li>
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
                    <i class="iconfont">&#xe63d;</i>已关注
                </a>
            </li>
        <?php else: ?>
            <li class="active">
                <a id="focusIt" class="active">
                    <i class="iconfont">&#xe63d;</i>关注
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
    <div class="popup" id="showPay" style="display: none;">
        <div class="popup_con">
            <h3 class="aligncenter">需支付100美币才能看到她的微信需支付100美币才能看到她的微信需支付100美币才能看到她的微信</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn cancel">取消</span>
            <span class="footerbtn gopay">立即支付</span>
        </div>
    </div>
    <!--查看微信弹出层-->
    <div class="popup wx_popup" hidden>
        <div class="popup_con">
            <h3 class="aligncenter"><span class="wx_user">范冰冰微信<i class="iconfont color_wx">&#xe641;</i></span></h3>
            <ul class="wx_copy_con">
                <li class="flex flex_justify">
                    <span class="wx_l_con">微信号：fangmeimei</span>
                    <span class="wx_r_copy">复制</span>
                </li>
                <li class="flex flex_justify">
                    <span class="wx_l_con">暗号：明天下雨吗？</span>
                    <span class="wx_r_copy">复制</span>
                </li>
            </ul>
            <h3 class="wx_tips smallarea">添加微信时，注意一定要填写暗号</h3>
            <p class="wx_care_tips smallarea">若微信号为空假号，点击此处<a href="#this" class="color_ts">举报</a></p>
        </div>
        <span class="closed"><i class="iconfont">&#xe644;</i></span>
    </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
    $('#showWx').on('tap', function () {
        console.log($(this));
        $('.show.flex').attr('style', 'display:block');
        $('#showPay').attr('style', 'display:block');
        //$('.wx_popup').attr('style','display:block');
    });
    $('#focusIt').on('tap', function () {
        //加关注
        var id = <?= $user->id ?>;  //该对象
        var $obj = $(this);
        if (!$obj.hasClass('active')) {
            //取消关注
            $.util.confirm('取消关注', '你确定取消关注她吗?', function () {
                followIt(id,$obj);
            });
        } else {
            followIt(id,$obj);
        }

    });
    function followIt(id,$obj) {
        $.util.ajax({
            url: '/user/follow',
            data: {id: id},
            func: function (res) {
                if($obj.hasClass('active')){
                    $obj.html('<i class="iconfont">&#xe63d;</i>已关注');
                }else{
                    $obj.html('<i class="iconfont">&#xe63d;</i>关注');
                }
                $obj.toggleClass('active');
                $.util.alert(res.msg);
            }
        })
    }
    $('#dateit').on('tap',function(){
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
</script>
<?php $this->end('script'); ?>
