<div>
    <div class="homepage mhomepage">
        <!--        <div class="header">
                    <h1>我的</h1>
                    <i class="iconfont install">&#xe661;</i>
                </div>-->
        <div class="home_cover_info">
            <span class="avatar">
                <img src="<?= createImg($user->avatar) . '?w=150' ?>"  class="avatar-pic"/>
            </span>
            <div class="cover_left_info">
                <ul class='opci'>
                    <li class="blight userinfo">
                        <a href="/userc/edit-info" class="cover_block">

                        <h3>
                            <span>
                                <?= $user->nick ?><span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span><?php if($user->recharge): ?><span class="diamonds"><img src="/mobile/images/zs.png" class="responseimg"/></span><?php endif; ?><?php if($pack): ?><span class="highter-vip">VIP 普通</span><?php endif; ?></span>
                            <?php if($user->id_status == UserStatus::PASS): ?>
                                <div class="bottom-btn">
                                    <span class="identify-info id-btn">身份已认证</span>
                                </div>
                            <?php endif; ?>
                        </h3>
                           <!--  <h3>
                                <span><i class="iconfont">&#xe628;</i></span>
                                <span class="flag price"><?= $this->Number->format($user->money) ?>美币</span>
                            </h3> -->

                            <span class="cover_r_ico">
                                <i class="iconfont">&#xe605;</i>
                            </span>
                        </a>
                    </li>
                    <li class="follow flex flex_justify">
                        <div><a href="/userc/fans">赞赏我 <i><?= $facount ?></i></a></div>
                        <div><a href="/userc/likes"> 关注 <i><?= $focount ?></i></a></div>
                        <div><a href="/userc/likes">访客 <i>122</i></a></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="wraper">
    <div class="home_items_list mt40">
        <ul>
            <li>
                <a href="/userc/my-purse"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span></div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png" alt="" /><?= $this->Number->format($user->money) ?></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/dateorder"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60a;</i><span class="itemsname">我的约单</span></div>
                    <div class="home_list_r_info">
                        <!--<span class="color_y">3</span>-->
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-activitys"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60b;</i><span class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <!--<span class="color_y">3</span>-->
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>

        </ul>
    </div>
    <div class="home_items_list mt40">
        <ul>
            <li>
                <a href="<?= ($pack)?'/userc/vip-center':'/userc/vip_buy'?>"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe658;</i><span class="itemsname">会员中心</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/user/used-pack"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe657;</i><span class="itemsname">付费查看记录</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--<div class="home_items_list mt40">
        <ul>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe659;</i><span class="itemsname">做任务赢特权</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>-->
    <div class="home_items_list items_basic_list mt40">
        <ul>
            <li>
                <a onclick="tel();"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe611;</i><span class="itemsname">联系客服</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe612;</i><span class="itemsname">分享</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/install"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe612;</i><span class="itemsname">设置</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="height:1.6rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'me']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    function tel() {
        $.util.confirm(
            '联系客服',
            '拨打客服电话',
            function() {
                LEMON.event.tel('13763053901');
            },
            null,
            null,
            '拨打'
        )
    }
</script>
<?php $this->end('script'); ?>