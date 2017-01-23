<div>
    <div class="homepage mhomepage flex">
        <div class="home_cover_info flex">
					<span class="avatar">
						<img src="<?= generateImgUrl($user->avatar); ?>" class="avatar-pic"/>
					</span>
            <div class="cover_left_info">
                <ul class="opci">
                    <li class="userinfo blight">
                        <a href="#this" class="cover_block">
                            <h3>
                                <span><?= $user->nick; ?>
                                    <?php if($shown['isActive']): ?>
                                        <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
                                    <?php endif; ?>
                                    <?php if($shown['isTuHao']): ?>
                                        <span class="diamonds"><img src="/mobile/images/zs.png" class="responseimg"/></span>
                                    <?php endif; ?>
                                    <?php if ($shown['vipLevel']): ?>
                                        <span class="highter-vip <?= VIPlevel::getStyle($shown['vipLevel']); ?>"><?= VIPlevel::getStr($shown['vipLevel']) ?></span>
                                    <?php endif; ?>
                                </span>
                                <div class="bottom-btn">
                                    <?php if ($user->id_status): ?>
                                        <span class="identify-info id-btn">身份已认证</span>
                                    <?php endif; ?>
                                </div>
                            </h3>
                        </a>
                    </li>
                    <li class="follow flex flex_justify">
                        <div>赞赏我 <i><?= $user->facount; ?></i></div>
                        <div>关注 <i><?= $user->focount; ?></i></div>
                        <div>访客 <i><?= $user->visitnum; ?></i></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="wraper">
    <div class="m-page-box">
        <ul class="outerblock mpage-content">
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">出生日期：</div>
                    <div class="r-info"><?= $user->birthday; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">星 座：</div>
                    <div class="r-info"><?= Zodiac::getStr($user->zodiac); ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">体 重</div>
                    <div class="r-info"><?= $user->weight; ?> KG</div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">身 高：</div>
                    <div class="r-info"><?= $user->height; ?> CM</div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">职 业：</div>
                    <div class="r-info"><?= $user->profession; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">家乡：</div>
                    <div class="r-info"><?= $user->hometown; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">所在地区：</div>
                    <div class="r-info"><?= $user->city; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">情感状态：</div>
                    <div class="r-info"><?= UserState::getStatus($user->state) ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">工作经历：</div>
                    <div class="r-info"><?= $user->career; ?></div>
                </div>
            </li>
        </ul>
        <ul class="outerblock mpage-content mt40">
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">常出没地点：</div>
                    <div class="r-info"><?= $user->place; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">喜欢的美食：</div>
                    <div class="r-info"><?= $user->food; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">喜欢的音乐：</div>
                    <div class="r-info"><?= $user->music; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">喜欢的电影：</div>
                    <div class="r-info"><?= $user->movie; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">喜欢的运动/娱乐：</div>
                    <div class="r-info"><?= $user->sport; ?></div>
                </div>
            </li>
            <li>
                <div class="mheight flex flex_justify">
                    <div class="l-info">个性签名：</div>
                    <div class="r-info"><?= $user->sign; ?></div>
                </div>
            </li>
        </ul>
    </div>
</div>