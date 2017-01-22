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
            <div class="commontitle inner mt20">
                <h3>当前可提现金额：<?= $user->money; ?> 元</h3>
            </div>
            <ul class="outerblock bgff">
                <li class="flex">
                    <span class="accountname">提现金额</span>
                    <div class="input_exchange">
                        <input  id="amount-input" name="amount" type="number" value="" />
                    </div>
                </li>
                <li class="flex">
                    <span class="accountname">登录密码</span>
                    <div class="input_exchange">
                        <input id="pw-input" name="passwd" type="password" value="" />
                    </div>
                </li>
            </ul>
            <div class="commontips inner mt20">
                <div>
                    <p>*1）为保障财产安全，只能每周三、日兑换各一次，每次不少于100元；</p>
                    <p>2）兑换申请成功后，平台将在24小时内把钱打入所提现账户。</p>
                     <!--<p>3）兑换美币将会收取20%的平台管理费。</p>-->
                </div>
            </div>
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