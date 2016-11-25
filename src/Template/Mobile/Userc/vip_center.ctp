<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>会员中心</h1>
    </div>
</header>
<div class="wraper">
    <div class="center__container">
        <ul class="outerblock">
            <li class="flex flex_justify inner">
                <div class="l_info">
                    <div class="linear">
                        <i class="iconfont ft32">&#xe627;</i>
                    </div>
                    <h3>查看动态</h3>
                </div>
                <div class="r_info">
                    <h3 class="topinfo">
                        还可以看
                        <i class="lagernum color_y">
                            <?= checkIsEndless($counter->browse_rest)?'无限':$counter->browse_rest; ?>
                        </i>
                        人
                    </h3>
                    <h3 class="smalldes">
                        <span>
                            共可以看<?= checkIsEndless($counter->browse_count)?'无限':$counter->browse_count; ?>人</span>|<time><?= getYMD($counter->deadline); ?>到期</time>
                    </h3>
                </div>
            </li>
            <li class="flex flex_justify inner">
                <div class="l_info">
                    <div class="linear">
                        <i class="iconfont">&#xe655;</i>
                    </div>
                    <h3>聊天人数</h3>
                </div>
                <div class="r_info">
                    <h3 class="topinfo">
                        还可以和
                        <i class="lagernum color_y">
                            <?= checkIsEndless($counter->chat_rest)?'无限':$counter->chat_rest; ?>
                        </i>
                        人聊天
                    </h3>
                    <h3 class="smalldes">
                        <span>共可以和<?= checkIsEndless($counter->chat_count)?'无限':$counter->chat_count; ?>人聊天</span>|<time><?= getYMD($counter->deadline) ?>到期</time></h3>
                </div>
            </li>
        </ul>
    </div>
    <div class="center_detail_list mt60">
        <h3 class="inner commontitle">购买记录</h3>
        <ul class="outerblock bdbottom btop inner">
            <?php foreach($userPacks as $item): ?>
                <li class="flex flex_justify">
                    <div class="l_info">
                        <h3><?= $item->title; ?></h3>
                        <time class="smalldes">
                            <?= getYMD($item->create_time) ?>
                        </time>
                    </div>
                    <div class="r_info smalldes">
                        <span>
                            查看
                            <?= ($item->chat_num - $item->rest_chat)?>
                        </span>
                        |
                        <span>
                            聊天
                            <?= ($item->browse_num - $item->rest_browse) ?>
                        </span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
<div style="height:62px;"></div>
<a href="/userc/vip-buy" class="identify_footer_potion">继续购买</a>