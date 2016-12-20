<header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1><?= $pageTitle; ?></h1>
    </div>
</header>
<div class="wraper">
    <div class="inner mt40">
        <?php if($isme && $user->gender == 2): ?>
        <a href="/user/share" class="btn btn_t_border">邀请好友支持我</a>
        <?php endif; ?>
        <ul class="voted_list voted-line">
            <?php if($wektop): ?>
            <li>
                <a href="/activity/index/top" class="title ablock flex flex_justify">
                    <span class="rank color_y">
                        <i class="iconfont">&#xe645;</i>
                        周榜头牌
                    </span>
                    <span class="iconfont color_gray r_con">&#xe605;</span>
                </a>
                <div class="voted_con voted-content flex flex_justify">
                    <div class="voted_l_info">
                        <span class="voted_place"><?= $wektop->index?></span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="<?= $wektop->user->avatar;?>"/></span>
                            <h3>
                                <span class="voted_name"><?= $wektop->user->nick?></span>
                                <span class="voted_number color_gray">
                                    <i class="iconfont color_y">&#xe61e;</i>
                                    <i class="color_y"><?= $wektop->total; ?></i>
                                    魅力值
                                </span>
                            </h3>
                        </div>
                    </div>
                    <?php if(!$isme && $user->gender == 1):?>
                    <span class="button btn_dark"
                          onclick="window.location.href='/gift/index/<?= $herid; ?>';
                              event.stopPropagation(); ">
                        支持她
                    </span>
                    <?php else: ?>
                        <span class="button btn_active"
                              onclick="window.location.href='/user/support'"
                              event.stopPropagation(); ">谁支持我
                        </span>
                    <?php endif;?>
                </div>
            </li>
            <?php endif; ?>
            <?php if($montop): ?>
            <li>
                <a href="/activity/index" class="title ablock flex flex_justify">
                    <span class="rank color_y">
                        <i class="iconfont">&#xe645;</i>
                        月榜头牌
                    </span>
                    <span class="iconfont color_gray r_con">&#xe605;</span>
                </a>
                <div class="voted_con  voted-content  flex flex_justify">
                    <div class="voted_l_info">
                        <span class="voted_place"><?= $montop->index?></span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="<?= $montop->user->avatar; ?>"/></span>
                            <h3>
                                <span class="voted_name"><?= $montop->user->nick; ?></span>
                                <span class="voted_number color_gray">
                                    <i class="iconfont color_y">&#xe61e;</i>
                                    <i class="color_y"><?= $montop->total; ?></i>
                                    魅力值
                                </span>
                            </h3>
                        </div>
                    </div>
                    <?php if(!$isme && $user->gender == 1):?>
                    <span class="button btn_dark"
                          onclick="window.location.href='/gift/index/<?= $herid; ?>';
                              event.stopPropagation(); ">
                        支持她
                    </span>
                    <?php else: ?>
                        <span class="button btn_active"
                              onclick="window.location.href='/user/support'"
                              event.stopPropagation(); ">谁支持我
                        </span>
                    <?php endif;?>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>