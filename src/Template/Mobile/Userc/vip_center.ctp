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
                        剩余
                        <i class="lagernum color_y">
                            <?php
                            use Cake\I18n\Time;
                            if(isset($counter->browse_rest)){
                                echo checkIsEndless($counter->browse_rest)?'无限':$counter->browse_rest;
                            } else {
                                echo '0';
                            }
                            ?>
                        </i>
                        人
                    </h3>
                    <h3 class="smalldes">
                        <span>
                            共
                            <?php
                                if(isset($counter->browse_count)){
                                    echo checkIsEndless($counter->browse_count)?'无限':$counter->browse_count;
                                } else {
                                    echo '0';
                                }
                            ?>
                            人</span>|
                        <time>
                            <?php
                                if(isset($counter->deadline)){
                                    echo getYMD($counter->deadline);
                                } else {
                                    echo getYMD(new Time());
                                }
                            ?>
                            到期
                        </time>
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
                        剩余
                        <i class="lagernum color_y">
                            <?php
                                if(isset($counter->chat_rest)){
                                    echo checkIsEndless($counter->chat_rest)?'无限':$counter->chat_rest;
                                } else {
                                    echo '0';
                                }
                            ?>
                        </i>人
                    </h3>
                    <h3 class="smalldes">
                        <span>共
                            <?php
                            if(isset($counter->chat_count)){
                                echo checkIsEndless($counter->chat_count)?'无限':$counter->chat_count;
                            } else {
                                echo '0';
                            }
                            ?>人
                        </span>|
                        <time>
                            <?php
                            if(isset($counter->deadline)){
                                echo getYMD($counter->deadline);
                            } else {
                                echo getYMD(new Time());
                            }
                            ?>
                            到期
                        </time>
                    </h3>
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
                            <?= ($item->chat_num)?>
                        </span>
                        |
                        <span>
                            聊天
                            <?= ($item->browse_num) ?>
                        </span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
<div style="height:62px;"></div>
<a href="/userc/vip-buy" class="identify_footer_potion">购买套餐</a>

<script>
    LEMON.sys.back('/user/index');
</script>