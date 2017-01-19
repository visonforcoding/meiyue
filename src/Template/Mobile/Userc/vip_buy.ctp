<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>购买套餐</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="package_list mt20">
        <h3 class="commontitle inner">套餐类别</h3>
        <div class="charge_container_con">
            <ul id="changed">
                <?php foreach($packs as $item): ?>
                    <!-- VIP套餐 -->
                    <?php if($item->type == 1): ?>
                    <li>
                        <div class="items flex flex_justify"  onclick="toPay(<?= $item->id; ?>, <?= $item->price; ?>)">
                            <h3 class="commontext bright color_friends">
                                <span class="lagernum">
                                    <!--<img src="/mobile/images/higther-vip.png" class="responseimg"/>-->
                                    <?= $item->title; ?>
                                </span>
                                <i class="unit"><?= $item->vali_time; ?>天</i>
                            </h3>
                            <div class="smalldes closed" data-type = "0">
                                <i class="iconfont color_y">&#xe62f;</i>
                                <i class="slide-btn-name">点击展开详情</i>
                            </div>
                            <div class="color_y">
                                <i class="smalldes">￥</i>
                                <span class="lagernum"><?= $item->price; ?></span>
                                <i class="iconfont rco">&#xe605;</i>  
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
                                        个美女发布的全部私房写真以及视频专辑
                                    </p>
                                <?php endif; ?>
                                <?php if($item->chat_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        和<?= checkIsEndless($item->chat_num)?'无限':$item->chat_num; ?>
                                        个美女聊天
                                    </p>
                                <?php endif; ?>
                                <?php if($item->act_dct < 10 && $item->act_dct > 0): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        参加<?= ActType::getWorkType($item->dct4act_type); ?>尊享<?= $item->act_dct; ?>折
                                    </p>
                                <?php endif; ?>
                                <?php if($item->act_send_num > 0): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        赠送<?= $item->act_send_num ?>场<?= ActType::getWorkType($item->send4act_type); ?>
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
                            <div class="items flex flex_justify" onclick="payView(<?= $item->id; ?>)">
                                <h3 class="commontext bright color_friends">
                                <span class="lagernum">
                                    <?= $item->title; ?>
                                </span>
                                    <i class="unit"><?= $item->vali_time; ?>天</i>
                                </h3>
                                <div class="smalldes closed" data-type = "0">
                                    <i class="iconfont color_y">&#xe62f;</i>
                                    <i class="slide-btn-name">点击展开详情</i>
                                </div>
                                <div class="color_y">
                                    <i class="smalldes">￥</i>
                                    <span class="lagernum"><?= $item->price; ?></span>
                                    <i class="iconfont rco">&#xe605;</i>  
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
                                        个美女发布的全部私房写真以及视频专辑
                                    </p>
                                    <?php endif; ?>
                                    <?php if($item->chat_num): ?>
                                    <p>
                                        <i class="iconfont color_y">&#xe654;</i>
                                        和<?= checkIsEndless($item->chat_num)?'无限':$item->chat_num; ?>个美女聊天
                                    </p>
                                    <?php endif; ?>
                                    <?php if($item->act_dct < 10 && $item->act_dct > 0): ?>
                                        <p>
                                            <i class="iconfont color_y">&#xe654;</i>
                                            参加<?= ActType::getWorkType($item->dct4act_type); ?>尊享<?= $item->act_dct; ?>折
                                        </p>
                                    <?php endif; ?>
                                    <?php if($item->act_send_num > 0): ?>
                                        <p>
                                            <i class="iconfont color_y">&#xe654;</i>
                                            赠送<?= $item->act_send_num ?>场<?= ActType::getWorkType($item->send4act_type); ?>
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
    $.util.tap($('#changed .closed'), function(e){
        var target = e.srcElement;
        if(target.tagName == 'I') target = target.parentNode;
        var data = $(target).data('type');
        var ele = $(target).parent('.items').siblings();
        switch(data){
            case '0':
                ele.removeClass('hidecon').addClass('showcon');
                $(target).attr('data-type','1');
                $(target).find('.slide-btn-name').text('点击关闭详情');
                break;
            case '1':
                ele.removeClass('showcon').addClass('hidecon');
                $(target).attr('data-type','0');
                $(target).find('.slide-btn-name').text('点击展开详情');
                break;
            default:break;
        }
        return false;
    });


    /**
     * 购买vip套餐
     */
    var usermoney = <?= isset($user->money)?$user->money:0;?>;
    function toPay($packid, $price) {
        if(usermoney < $price) {
            $.util.confirm(
                '余额不足',
                '您的美币不足，是否进行充值支付？',
                function() {
                    payView($packid);
                },
                null
            );
            return;
        }
        $.util.confirm(
            '确认购买',
            '确定支付'+$price+'美币购买？',
            function() {
                $.util.showPreloader();
                $.ajax({
                    type: 'POST',
                    url: '/userc/taocan-pay',
                    dataType: 'json',
                    data: {pid: $packid},
                    success: function (res) {
                        $.util.hidePreloader();
                        if (typeof res === 'object') {
                            $.util.alert(res.msg);
                            if (res.status) {
                                setTimeout(function() {
                                    location.href='/userc/vip-center';
                                }, 1000);
                            }
                        }
                    }
                });
            },
            null
        );
    }


    /**
     * 购买充值套餐
     */
    function payView($packid)
    {
        $.util.showPreloader();
        $.ajax({
            type: 'POST',
            url: '/userc/create-payorder/' + $packid + '<?= isset($reurl)?"?redurl=".$reurl:""; ?>',
            dataType: 'json',
            success: function (res) {
                $.util.hidePreloader();
                if (typeof res === 'object') {
                    if (res.status) {
                        document.location.href = res.redirect_url;
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });
    }
</script>