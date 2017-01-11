<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>兑换美币申请</h1>
    </div>
</header> -->
<div class="wraper">
    <form>
        <div class="exchange_dollar">
            <div class="commontitle inner mt20">
                <?php if($type == 1)://支付宝 ?>
                    <h3>为了账户资金安全，只能使用您本人的支付宝账号</h3>
                <?php elseif($type == 2): //银联?>
                    <h3>为了账户资金安全，只能使用您本人银行卡</h3>
                <?php endif; ?>
            </div>
            <ul class="outerblock bgff">
                <li class="flex">
                    <span class="accountname">真 实 姓 名</span>
                    <div class="input_exchange">
                        <input id="truename-input" name="truename" type="text" value="" />
                    </div>
                </li>
                <?php if($type == 1)://支付宝 ?>
                    <li class="flex">
                        <span class="accountname">支付宝账号</span>
                        <div class="input_exchange">
                            <input id="cardno-input" type="text" name="cardno" value=""/>
                        </div>
                    </li>
                <?php elseif($type == 2): //银联?>
                    <li class="flex">
                        <span class="accountname">银行卡账号</span>
                        <div class="input_exchange">
                            <input id="cardno-input" type="text" name="cardno" value=""/>
                        </div>
                    </li>
                    <li class="flex">
                        <span class="accountname">银行</span>
                        <div class="input_exchange">
                            <input id="bank-input" type="text" name="bank" value=""/>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <p class="commontips inner mt20">为了保障财产安全，每周只能在周三、周日兑换各一次，且每次不超过 20,000 美币。</p>
            <div class="commontitle inner mt20">
                <h3>当前虚拟币：<?= $user->money; ?> 美币</h3>
            </div>
            <ul class="outerblock bgff">
                <li class="flex">
                    <span class="accountname">提现美币</span>
                    <div class="input_exchange">
                        <input  id="amount-input" name="amount" type="number" value="500" />
                    </div>
                </li>
                <li class="flex">
                    <span class="accountname">登录密码</span>
                    <div class="input_exchange">
                        <input id="pw-input" name="passwd" type="password" value="" />
                    </div>
                </li>
            </ul>
            <p class="commontips inner mt20">注:兑换申请成功后平台将会在24小时之内把钱打入所提现的账户中。</p>
        </div>
    </form>
</div>
<div class="bottomblock">
    <div class="flex flex_end">
        <span class="total">所兑换人民币：<i class="color_y">￥</i> <i class="color_y numbers" id="show-true-amount"></i></span>
        <a class="nowpay">立即申请</a>
    </div>
</div>

<script>
    $("#amount-input").keyup(function(){
        var curamountstr = $(this).val();
        var curamount = 0;
        if(!curamountstr) {
            curamountstr = '0';
        }
        curamount = parseFloat(curamountstr);

        if(curamount > <?= $user->money; ?>) {
            $(this).val(<?= $user->money; ?>);
            curamount = <?= $user->money; ?>;
        }
        var trueamount = curamount * 0.8;
        $('#show-true-amount').text(trueamount);
    });

    $('.nowpay').on('tap', function() {
        var truename = $('#truename-input').val();
        var cardno = $('#cardno-input').val();
        var amount = $('#amount-input').val();
        var passwd = $('#pw-input').val();
        var bank = '';
        <?php if($type == 1)://支付宝 ?>
        if(!cardno) {
            $.util.alert('请填写支付宝账号');
            return;
        }
        <?php elseif($type == 2): //银联?>
        bank = $('#bank-input').val();
        if(!bank) {
            $.util.alert('请填写银行');
            return;
        }
        if(!cardno) {
            $.util.alert('请填写银行卡账号');
            return;
        }
        <?php endif; ?>

        if(!truename) {
            $.util.alert('请填写真实姓名');
            return;
        }
        if(!amount) {
            $.util.alert('请填写提现金额');
            return;
        }
        if(!passwd) {
            $.util.alert('请输入登录密码');
            return;
        }
        if(20000 < parseFloat(amount)) {
            $.util.alert('兑换金额超过20,000，请重新输入');
            return;
        }
        if(500 > parseFloat(amount)) {
            $.util.alert('兑换金额低于500，请重新输入');
            return;
        }
        $.ajax({
            url: '/userc/exchange-apply',
            type: "POST",
            dataType: "json",
            data: {truename:truename, bank: bank, cardno: cardno, amount: amount, passwd: passwd, type: <?= $type; ?>},
            success: function (res) {
                $.util.alert(res.msg);
                if(res.status) {
                    location.href='/userc/my-purse';
                }
            }
        })
    });
</script>