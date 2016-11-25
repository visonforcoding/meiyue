<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>购买套餐</h1>
    </div>
</header>
<div class="wraper">
    <div class="package_list mt20">
        <h3 class="commontitle inner">套餐类别</h3>
        <div class="charge_container_con">
            <ul id="changed">
                <?php foreach($packs as $item): ?>
                    <!-- VIP套餐 -->
                    <?php if($item->type == 1): ?>
                    <li>
                        <div class="items flex flex_justify inner">
                            <h3 class="bright color_friends">
                                <span class="lagernum">

                                </span>
                                <i class="unit"><?= $item->vali_time; ?>天</i>
                            </h3>
                            <div class="smalldes closed" data-type = "0">
                                <i class="iconfont color_y">&#xe62f;</i>
                                点击关闭详情
                            </div>
                            <div class="color_y" onclick="payView(<?= $item->id; ?>)">
                                <i class="smalldes">￥</i>
                                <span class="lagernum"><?= $item->price; ?></span>
                            </div>
                        </div>
                        <div class="content hidecon inner">
                            <div class="innerblock">
                                <h1>享受的特权
                                    <i class="color_friends">
                                        <?= $item->vali_time; ?>
                                        天
                                    </i>
                                </h1>
                                <?php if($item->browse_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        查看
                                        <?= (checkIsEndless($item->browse_num))?'无限':$item->browse_num; ?>
                                        个美女所发布的全部动态
                                    </p>
                                <?php endif; ?>
                                <?php if($item->chat_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        和<?= checkIsEndless($item->chat_num)?'无限':$item->chat_num; ?>
                                        个美女聊天
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="package_list mt20">
        <h3 class="commontitle inner">您还可以充值享受套餐</h3>
        <div class="charge_container_con">
            <ul id="changed">
                <?php foreach($packs as $item): ?>
                    <!-- 充值套餐 -->
                    <?php if($item->type == 2): ?>
                        <li>
                            <div class="items flex flex_justify inner">
                                <h3 class="bright color_friends">
                                <span class="lagernum">

                                </span>
                                    <i class="unit"><?= $item->vali_time; ?>天</i>
                                </h3>
                                <div class="smalldes closed" data-type = "0">
                                    <i class="iconfont color_y">&#xe62f;</i>
                                    点击关闭详情
                                </div>
                                <div class="color_y" onclick="payView(<?= $item->id; ?>)">
                                    <i class="smalldes">￥</i>
                                    <span class="lagernum"><?= $item->price; ?></span>
                                </div>
                            </div>
                            <div class="content hidecon inner">
                                <div class="innerblock">
                                    <h1>享受的特权
                                        <i class="color_friends">
                                            <?= $item->vali_time; ?>
                                            天
                                        </i>
                                    </h1>
                                    <?php if($item->browse_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        查看
                                        <?= checkIsEndless($item->browse_num)?'无限':$item->browse_num; ?>
                                        个美女所发布的全部动态
                                    </p>
                                    <?php endif; ?>
                                    <?php if($item->chat_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        和<?= checkIsEndless($item->chat_num)?'无限':$item->chat_num; ?>个美女聊天
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#changed .closed').on('tap',function(){
        var data = $(this).data('type');
        var ele = $(this).parent('.items').siblings();
        switch(data){
            case '0':
                ele.removeClass('hidecon').addClass('showcon');
                $(this).attr('data-type','1');
                break;
            case '1':
                ele.removeClass('showcon').addClass('hidecon');
                $(this).attr('data-type','0');
                break;
            default:break;
        }
    })

    //支付
    function payView($packid)
    {
        window.location.href = "/userc/packpay/" + $packid;
    }
</script>