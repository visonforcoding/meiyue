<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>我的钱包</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="purse_list">
        <div class="purse_list_top">
            <div class="flex flex_center">
						<span class="purse_ico">
							<img src="/mobile/images/cash1.png"/>
						</span>
                <h3 class="purse_list_tright">
                    <span class="balance">钱包余额</span>
                    <span class="numbers"><i><?= $user->money ?></i>美币</span>
                </h3>
            </div>
            <div><p class="smallarea aligncenter moneycharge">可兑换余额<?= ($user->gender == 1)?$canTixian: $user->money;?>美币</p></div>
        </div>

        <div class="purse_list_bottom">
            <?php if ($user->gender == 1): ?>
                <?php if($canTixian): ?>
                    <div class="flex flex_justify inner">
                        <div class="wid50" onclick="duihuan();"><span class="btn btn_bg_t">兑换美币</span></div>
                        <div class="wid50" onclick="window.location.href='/purse/recharge'">
                            <span class="btn btn_bg_active">充值</span>
                        </div>
                    </div>
                    <p><a href="/activity/index/3#3" class="undertext color_tencent smallarea">查看在土豪榜中的位置</a></p>
                <?php else: ?>
                    <div class="flex flex_justify inner" onclick="window.location.href='/purse/recharge'">
                        <span class="btn btn_bg_active">充值</span>
                    </div>
                    <p><a href="/activity/index/3#3" class="undertext color_tencent smallarea">查看在土豪榜中的位置</a></p>
                <?php endif; ?>
            <?php else: ?>
                <div class="flex flex_justify inner" onclick="duihuan();"><span class="btn btn_bg_t">兑换美币</span></div>
            <?php endif; ?>
            <?php if(isset($withdraw->viramount)): ?>
                <p class="tips">正在申请提现 <?= $withdraw->viramount; ?> 美币</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if(count($top5flows)): ?>
        <div class="puse_bills mt20">
            <div class="commontitle inner">
                <h3>账单明细</h3>
            </div>
            <ul class="puse_bills_con">
                <?php foreach ($top5flows as $flow): ?>
                    <li>
                        <div class="puse_bills_left">
                            <h3><?= $flow->type_msg ?></h3>
                            <time><?= $flow->create_time->format('Y-m-d') ?></time>
                        </div>
                    <span class="puse_bills_right">
                        <?php if ($flow->user_id == $user->id): ?>
                        +
                        <?php else: ?>
                        -
                        <?php endif; ?>
                        <?= $flow->amount ?>
                    </span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if(count($top5flows) >= 10): ?>
            <div class="loader-more">
                <p>查看更多明细<i class="iconfont">&#xe605;</i></p>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<!--支付弹出层-->
<div class="choose-type raper hide">
    <div class="choose_account">
        <div class="title">
            <h1>选择账户</h1>
            <span class="choose-type-close closed">取消</span>
        </div>
        <ul class="inner outerblock">
            <li class="pay-type-choose" onclick="toAlipage();">
                <div class="paytype">
                    <i class="iconfont payico alipay">&#xe625;</i>
                    <h3 class="paydes">
                        <span class="impordes">支付宝</span>
                        <em class="small">推荐使用</em>
                    </h3>
                </div>
                <span class="pay-type-choose-span iconfont choose">&#xe615;</span>
            </li>
            <li class="pay-type-choose" onclick="toYinlianpage();">
                <div class="paytype">
                    <i class="iconfont payico cardpay">&#xe621;</i>
                    <h3 class="paydes">
                        <span class="impordes">银联</span>
                        <em class="small">银联账户使用</em>
                    </h3>
                </div>
                <span class="pay-type-choose-span iconfont choose">&#xe615;</span>
            </li>
        </ul>
    </div>
</div>

<script>

    $('.loader-more').on('tap', function() {
        window.location.href='/userc/purse-detail';
    });

    function duihuan() {
        <?php if($status[0] == 1): ?>
        $('.choose-type').toggleClass('hide');
        <?php else: ?>
        $.util.alert('<?= $status[1]; ?>');
        <?php endif; ?>
    }

    $.util.tap($('.choose-type-close'), function() {
        $('.choose-type').toggleClass('hide');
    });

    $('.pay-type-choose').on('tap', function(event) {
        event.stopPropagation();
        $('.pay-type-choose').removeClass('choosed');
        $('.pay-type-choose .pay-type-choose-span').html("&#xe615;");
        $('.pay-type-choose .pay-type-choose-span').removeClass('color_y');
        $(this).addClass('choosed');
        $(this).find('.pay-type-choose-span').first().html('&#xe635;');
        $(this).find('.pay-type-choose-span').first().addClass('color_y');
    });

    function toAlipage() {
        window.location.href = '/userc/exchange-view/1';
    }

    function toYinlianpage() {
        window.location.href = '/userc/exchange-view/2';
    }
    LEMON.sys.back('/user/index');
</script>