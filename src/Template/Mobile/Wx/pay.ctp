<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>支付</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="recharge_pay_container flex flex_justify inner mt20">
        <div class="l_info">
            <i class="iconfont">&#xe636;</i>
            <span><?= $title; ?></span>
        </div>
        <div class="r_info color_y">
            <i>￥</i>
            <span class="lagernum"><?= $payorder->price ?></span>
        </div>
    </div>
    <div class="recharge_pay_list mt20">
        <h3 class="commontitle inner">支付方式</h3>
        <div class="choose_account choose_potion">
            <ul class="inner outerblock">
                <li class="choosed">
                    <div class="paytype">
                        <i class="iconfont payico color_wx">&#xe638;</i>
                        <h3 class="paydes">
                            <span class="impordes">微信支付</span>
                        </h3>
                    </div>
                    <span data-pay="wx" class="iconfont choose color_y">&#xe635;</span>
                </li>
                <li class="choosed">
                    <div class="paytype">
                        <i class="iconfont payico alipay">&#xe625;</i>
                        <h3 class="paydes">
                            <span class="impordes">支付宝支付</span>
                        </h3>
                    </div>
                    <span data-pay="ali" class="iconfont choose">&#xe615;</span>
                </li>
                <!--<li class="choosed">
                    <div class="paytype">
                        <i class="iconfont payico cardpay">&#xe621;</i>
                        <h3 class="paydes">
                            <span class="impordes">银联支付</span>
                        </h3>
                    </div>
                    <span data-pay="bank" class="iconfont choose">&#xe615;</span>
                </li>-->
            </ul>
        </div>
    </div>
</div>
<div style="height:62px;"></div>
<a id="pay" class="identify_footer_potion">立即支付</a>
<?php $this->start('script'); ?>
<script type="text/javascript">
    var payMethod = 'wx';
    $('.choosed').on('tap', function () {
        //选择支付
        payMethod = $(this).find('.choose').data('pay');
        $('.choose').html('&#xe615;');
        $('.choose').removeClass('color_y');
        $(this).find('.choose').html('&#xe635;');
        $(this).find('.choose').addClass('color_y');
    });
    $('#pay').on('tap', function () {
        if (payMethod == 'wx') {
            var wxConfig = '<?= json_encode($jsApiParameters) ?>';
            if ($.util.isAPP) {
                if (wxConfig) {
                    LEMON.pay.wx(<?= json_encode($jsApiParameters) ?>, function (res) {
                        if (res == '0') {
                            $.util.alert('支付成功');
                            setTimeout(function () {
                                <?php if($redurl): ?>
                                window.location.href = '<?= $redurl; ?>';
                                <?php else: ?>
                                window.location.href = '/wx/pay-success/<?= $payorder->id ?>';
                                <?php endif; ?>
                            }, 1000);
                        } else {
                            $.util.alert('支付未成功');
                        }
                    });
                }
                return false;
            }
            callpay();
        }
        if (payMethod == 'ali') {
            if ($.util.isAPP) {
                LEMON.pay.ali('<?= $aliPayParameters ?>', function (res) {
                    if (res == '9000') {
                        $.util.alert('支付成功');
                        setTimeout(function () {
                            <?php if($redurl): ?>
                            window.location.href = '<?= $redurl; ?>';
                            <?php else: ?>
                            window.location.href = '/wx/pay-success/<?= $payorder->id ?>';
                            <?php endif; ?>
                        }, 2000);
                    } else {
                        $.util.alert('支付未成功');
                    }
                });
            }
        }
    });

    LEMON.event.unrefresh();
</script>
<?php $this->end('script'); ?>