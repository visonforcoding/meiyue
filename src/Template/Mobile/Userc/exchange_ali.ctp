<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>兑换美币申请</h1>
    </div>
</header>
<div class="wraper">
    <div class="exchange_dollar">
        <div class="commontitle inner mt20">
            <h3>为了账户资金安全，只能使用您本人的银行卡</h3>
        </div>
        <ul class="outerblock bgff">
            <li class="flex">
                <span class="accountname">真 实 姓 名</span>
                <div class="input_exchange">
                    <input id="truename-input" name="truename" type="text" value="" />
                </div>
            </li>
            <li class="flex">
                <span class="accountname">支付宝账号</span>
                <div class="input_exchange">
                    <input id="cardno-input" type="text" name="cardno" value=""/>
                </div>
            </li>
        </ul>
        <p class="commontips inner mt20">为了保障财产安全，每周只能在周三、周日兑换各一次，且每次不超过 20,000 美币。</p>
        <div class="commontitle inner mt20">
            <h3>当前虚拟币：<?= $user->money; ?> 美币</h3>
        </div>
        <ul class="outerblock bgff">
            <li class="flex">
                <span class="accountname">提现金额</span>
                <div class="input_exchange">
                    <input  id="amount-input" name="amount" type="number" value="1.00" />
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
</div>
<div class="bottomblock">
    <div class="flex flex_end">
        <span class="total">所兑换人民币：<i class="color_y">￥</i> <i class="color_y numbers" id="show-true-amount">0.80元</i></span>
        <a href="javascript:void(0);" class="nowpay">立即支付</a>
    </div>
</div>

<script>
    $("#amount-input").keyup(function(){
        var curamount = parseFloat($(this).val());
        var trueamount = curamount * 0.8;
        console.log(trueamount);
        $('#show-true-amount').text(trueamount);
    });
    LEMON.sys.back('/userc/my-purse');
</script>