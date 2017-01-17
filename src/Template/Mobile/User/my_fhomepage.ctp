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
            <?php if($shown['isActive']): ?>
            <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
            <?php endif; ?>
            <?php if($shown['isHongRen']): ?>
            <span class="vip"><img src="/mobile/images/my-hot.png" class="responseimg"/></span>
            <?php endif; ?>
        </h3>
        <div class="home_name_info aligncenter">
            <i class="iconfont color_y"><?= ($user->gender)?'&#xe61d;':'&#xe61c;'; ?></i> <?= $user->age ?> <i class="job"><?= $user->profession ?></i> <i class="address"><?= $user->city ?> </i>
        </div>
        <!--<div class="commend aligncenter">
            <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_light">&#xe62a;</i>
            <span class="total">4.2分</span>
        </div>-->
        <ul class="otherinfo flex flex_justify bdbottom">
            <li><span class="t_desc"><?= ($user->height)?$user->height.$user->cup:'--' ?></span><span class="b_desc">身高</span></li>
            <li><span class="t_desc"><?= ($user->weight)?$user->weight.'kg':'--' ?></span><span class="b_desc">体重</span></li>
            <li><span class="t_desc"><?= ($user->bwh)?$user->bwh:'--' ?></span><span class="b_desc">三围</span></li>
            <li><span class="t_desc"><?= ($user->birthday)?$user->birthday:'--' ?></span><span class="b_desc">生日</span></li>
        </ul>
    </div>

    <!--图片 && 视频展示-->
    <?php if (($user->status == 3) && (@unserialize($user->images) || $user->video)): ?>
        <div class="home_pic_info mt40">
            <ul class="inner flex">
                <?php if (@unserialize($user->images)): ?>
                    <?php foreach(array_slice(unserialize($user->images), 0, 4) as $img): ?>
                        <li class="img-item"><img src="<?= createImg($img) ?>?w=160" onload="$.util.setWH(this);"/></li>
                    <?php endforeach; ?>
                   <!-- <li>
                        <a class='ablock' >
                            <img src="<?/*= unserialize($user->images)[3]; */?>?w=160" onload="$.util.setWH(this);"/>
                            <span>更多私房</span>
                        </a>
                    </li>-->
                <?php endif; ?>
            </ul>
            <?php if($user->video): ?>
                <div id="see-basic-mv" class="inner home_video mt20  flex flex_center  relpotion init">
                        <video preload="preload" poster="<?= $user->video_cover; ?>"><source src="<?= $user->video; ?>" type="video/mp4"></video>
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
                    <span id="showWx" class="golook" style="color: #dadada;">点击查看</span>
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
<script>
    LEMON.sys.back('/index/index');
    LEMON.sys.setTopRight('分享')
    window.onTopRight = function () {
        shareBanner();
    }


    $(document).on('click', '.img-item', function() {
        var imgs = [];
        $('.img-item img').each(function() {
            imgs.push((this.src).replace(/\?.*/, ''));
        });
        LEMON.event.viewImg(imgpath.replace(/\?.*/, ''), imgs);
    });


    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/index/homepage/'.$user->id; ?><?= isset($user)?'?ivc='.$user->invit_code:'';?>';
        window.shareConfig.title = '一人宅家好无聊，想去疯玩没人陪？';
        window.shareConfig.imgUrl = '<?= getHost().(isset($user)?$user->avatar:'/upload/ico/meiyue.png');?>';
        var share_desc = '上美约APP，约K歌、美食、运动、工作，同城上万高颜值美女在线';
        share_desc && (window.shareConfig.desc = share_desc);
        LEMON.show.shareBanner();
    }
    $.util.checkShare();
</script>

