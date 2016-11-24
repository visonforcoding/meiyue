<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>支付</h1>
    </div>
</header>

<div class="recharge_pay_container flex flex_justify inner mt20">
    <div class="l_info">
        <i class="iconfont">&#xe636;</i>
        <span>购买<?= $pack->title; ?>套餐 送大礼包</span>
    </div>
    <div class="r_info color_y">
        <i>￥</i>
        <span class="lagernum"><?= $pack->price ?></span>
    </div>
</div>
<?= $this->element('paymenu'); ?>

<script>

    var func = function(option) {
        if(confirm('输入密码')) {
            $.ajax({
                type: 'POST',
                url: '/userc/lmpay/<?= $pack->id; ?>',
                dataType: 'json',
                success: function (res) {
                    if (typeof res === 'object') {
                        if (res.status) {
                            window.location.href = '/userc/vip-center/<?= $user->id ?>';
                        } else {
                            alert(res.msg);
                        }
                    }
                }
            });
        }
    }

    var lmpay = new payobj();
    lmpay.init(func);

</script>