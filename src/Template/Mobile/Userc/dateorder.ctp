<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="order-list-tpl" type="text/html">
    {{#orders}}
    <li>
        <div class="date_item_des">
            <div class="flex flex_justify bdbottom">
                <h3 class='maxwid70'><i class="itemsname color_y">[{{user_skill.skill.name}}]</i>{{user_skill.description}}</h3>
                <span class="customer color_y">{{consumer}}</span>
            </div>
            <a style="display:block" href="/userc/order-detail/{{id}}">
                <div class="place_pic flex flex_justify bdbottom">
                    <div  class="place_info_desc">
                        <span class="place">
                            <img src="{{dater.avatar}}"/>
                        </span>
                        <div class="place_info">
                            <h3 class="userinfo">{{dater_name}}</h3>
                            <h3 class="otherinfo">
                                <time><i class="iconfont color_y">&#xe622;</i>今日 · 12:00-15:00</time>
                                <address><i class="iconfont color_y">&#xe623;</i>{{site}} </address>
                            </h3>
                        </div>
                    </div>
                    <span class="price">{{amount}}美币</span>
                </div>
            </a>
            <div class="flex flex_justify">
                {{#finish_prepay}}
                <h3 class="pay_desc color_y">已预付：{{pre_pay}}美币</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                        <span data-orderid="{{id}}" id="refuse_status_3" class="refuse">取消约单</span>
                        <?php else:?>
                        <span data-orderid="{{id}}" id="refuse_status_3" class="refuse">拒绝</span>
                        <span data-orderid="{{id}}"  class="receive_order">接单</span>
                    <?php endif; ?>
                </div>
                {{/finish_prepay}}
                {{#finish_receive}}
                <h3 class="pay_desc color_y">待付尾款</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                    <span data-orderid="{{id}}" ><a href="/userc/order-detail/{{id}}">立即支付</a></span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" id="refuse_status_7" class="cancel_order">取消订单</span>
                    <?php endif; ?>
                </div>
                {{/finish_receive}}
            </div>
        </div>
    </li>
    {{/orders}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>我的订单</h1>
    </div>
</header>
<div class="wraper">
    <div class="date_list">
        <div class="date_list_header order_header">
            <div data-query="1" class="alldate cur">
                <span class="headertab">全部</span>
            </div> | 
            <div data-query="2" class="todate">
                <span class="headertab">等待确认<i class="tips_ico"></i></span>
            </div> | 
            <div data-query="3" class="todate">
                <span class="headertab">进行中<i class="tips_ico"></i></span>
            </div>
        </div>
        <div class="date_list_con">
            <!--
            全部订单
            -->
            <section style="display:block">
                <ul id="order-list">

                </ul>
            </section>

        </div>
    </div>
</div>
<!--发布约会-->
<?php if ($user->gender == '2'): ?>
    <div class="fixed_r_submit">
        <span>发布<br />约会</span>
    </div>
<?php endif; ?>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/userc/getDateorders/', page: curpage, tpl: '#order-list-tpl', id: '#order-list',
    key: 'orders', func: calFunc});
setTimeout(function () {
    //滚动加载
    $(window).on("scroll", function () {
        $.util.listScroll('order-list', function () {
            $.util.asyLoadData({gurl: '/userc/getDateorders/', page: curpage,
                tpl: '#order-list-tpl', id: '#order-list', more: true, key: 'orders', func: calFunc});
        })
    });
}, 2000);
$(document).on('tap', '.receive_order', function () {
    //美女接收订单
    var orderid = $(this).data('orderid');
    $.util.ajax({
        url: '/userc/receive-order',
        data: {orderid: orderid},
        func: function (res) {
            $.util.alert(res.msg);
        }
    })
});
$(document).on('tap', '#refuse_status_3', function () {
    //状态3时的拒绝接单 和 取消订单
    var orderid = $(this).data('orderid');
    $.util.ajax({
        url: '/date-order/cancel-date-order-3',
        data: {order_id: orderid},
        func: function (res) {
            $.util.alert(res.msg);
        }
    })
});
$(document).on('tap', '#refuse_status_7', function () {
    //状态7时 女方取消订单
    var orderid = $(this).data('orderid');
    $.util.confirm('确定要取消订单吗?','将会扣除10%的约单金额作为惩罚。',function(){
        $.util.ajax({
            url: '/date-order/cancel-date-order-7',
            data: {order_id: orderid},
            func: function (res) {
                $.util.alert(res.msg);
            }
        })
    })
});
$('.date_list_header div').on('tap', function () {
    //tap切换
    curpage = 1;
    var query = $(this).data('query');
    $('.date_list_header div').removeClass('cur current');
    $(this).addClass('cur current');
    $.util.asyLoadData({
        gurl: '/userc/getDateorders/',
        page: curpage,
        tpl: '#order-list-tpl',
        id: '#order-list',
        key: 'orders',
        query: '?query=' + query,
        func: calFunc
    });
});
function calFunc(data) {
    //返回格式化回调
    if (data.orders.length) {
        $.each(data.orders, function (i, n) {
            if ($.inArray(n.status, [3]) !== -1) {
                data.orders[i]['finish_prepay'] = true;  //男方支付完预约金 等待女方确认
            }
            if ($.inArray(n.status, [7]) !== -1) {
                data.orders[i]['finish_receive'] = true;  //女方确认接单 等待支付尾款
            }
        });
    }
    console.log(data);
    return data;
}
</script>
<?php $this->end('script'); ?>