<div class="wraper">
    <div class="recharge_pay_list mt20">
        <h3 class="commontitle inner">支付方式</h3>
        <div class="choose_account choose_potion">
            <ul class="inner outerblock">
                <li class="choosed paytypebtn" data-type="1">
                    <div class="paytype">
                        <i class="iconfont payico color_wx">&#xe638;</i>
                        <h3 class="paydes">
                            <span class="impordes">微信支付</span>
                        </h3>
                    </div>
                    <span class="ico iconfont choose color_y">&#xe635;</span>
                </li>
                <li class="choosed paytypebtn" data-type="2">
                    <div class="paytype">
                        <i class="iconfont payico alipay">&#xe625;</i>
                        <h3 class="paydes">
                            <span class="impordes">支付宝支付</span>
                        </h3>
                    </div>
                    <span class="ico iconfont choose">&#xe615;</span>
                </li>
                <li class="choosed paytypebtn" data-type="3">
                    <div class="paytype">
                        <i class="iconfont payico cardpay">&#xe621;</i>
                        <h3 class="paydes">
                            <span class="impordes">银联支付</span>
                        </h3>
                    </div>
                    <span class="ico iconfont choose">&#xe615;</span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div style="height:62px;"></div>
<a id="payact" class="identify_footer_potion">立即支付</a>

<script>
    var payobj = function(o) {

        var opt = {
            typewx: 1,
            typeal: 2,
            typeyl: 3,
            func: null,  //回调
            curtype: 1, //默认是微信支付
        }
        $.extend(this, this.opt, o);

    };

    $.extend(
        payobj.prototype,
        {
            init: function(func) {
                this.func = func;
                this.addEvent();
            },
            addEvent: function() {
                var obj = this;
                $('.paytypebtn').on('tap', function() {
                    $('.paytypebtn').each(function() {
                        $(this).find('.ico').removeClass('color_y');
                        $(this).find('.ico').html('&#xe615;');
                    });
                    $(this).find('.ico').toggleClass('color_y');
                    $(this).find('.ico').html('&#xe635;');
                    var type = $(this).data('type');
                    obj.curtype = parseInt(type);
                });

                $('#payact').on('tap', function() {
                    var option = {
                        paytype: obj.curtype
                    };
                    if(obj.func) {
                        obj.func(option);
                    }
                });
            }
        }
    );
</script>