<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>我的钱包</h1>
    </div>
</header>
<div class="wraper">
    <div class="purse_list">
        <div class="purse_list_top">
            <span class="purse_ico">
                <img src="/mobile/images/cash1.png"/>
            </span>
            <h3 class="purse_list_tright">
                <span class="balance">钱包余额</span>
                <span class="numbers"><i><?= $user->money ?></i>美币</span>
            </h3>
        </div>
        <div class="purse_list_bottom">
            <?php if ($user->gender == 1): ?>
            <span onclick="window.location.href='/purse/recharge'" class="btn btn_bg_t"><a>充值</a></span>
                <p><a href="/activity/index#3" class="undertext color_tencent smallarea">查看在土豪榜中的位置</a></p>
            <?php else: ?>
                <span class="btn btn_bg_t" onclick="window.location.href='/userc/exchange-ali'">兑换美币</span>
                <p class="tips">正在申请提现 20,000 美币</p>
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
                        <?php if ($flow->income == 1): ?>
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
<div class="raper hide">
    <div class="choose_account">
        <div class="title">
            <h1>选择账户</h1>
            <span class="closed">取消</span>
        </div>
        <ul class="inner outerblock">
            <li class="choosed">
                <div class="paytype">
                    <i class="iconfont payico alipay">&#xe625;</i>
                    <h3 class="paydes">
                        <span class="impordes">支付宝支付</span>
                        <em class="small">推荐使用</em>
                    </h3>
                </div>
                <span class="iconfont choose color_y">&#xe635;</span>
            </li>
            <li>
                <div class="paytype">
                    <i class="iconfont payico cardpay">&#xe621;</i>
                    <h3 class="paydes">
                        <span class="impordes">银联支付</span>
                        <em class="small">银联账户使用</em>
                    </h3>
                </div>
                <span class="iconfont choose">&#xe615;</span>
            </li>
        </ul>
    </div>
</div>

<script>

    $('.loader-more').on('tap', function() {
        window.location.href='/userc/purse-detail';
    });
    LEMON.sys.back('/user/index');
</script>