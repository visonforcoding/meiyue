<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="order-list-tpl" type="text/html">
    {{#orders}}
    <li>
        <div class="date_item_des">
            <div class="flex flex_justify bdbottom">
                <h3 class='maxwid70'><i class="itemsname color_y">[{{user_skill.skill.name}}]</i></h3>
                <span class="customer color_y">{{buyer.nick}}</span>
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
                                <time><i class="iconfont color_y">&#xe622;</i>{{time}}</time>
                                <address><i class="iconfont color_y">&#xe623;</i>{{site}} </address>
                            </h3>
                        </div>
                    </div>
                    <span class="price">{{amount}}美币</span>
                </div>
            </a>
            <div class="flex flex_justify">
                {{#wait_prepay}}
                <h3 class="pay_desc color_y">待支付预约金</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                        <span data-orderid="{{id}}"  class="refuse pay_status_1">付款</span>
                    <?php endif; ?>
                </div>
                {{/wait_prepay}}
                {{#finish_prepay}}
                <h3 class="pay_desc color_y">已预付：{{pre_pay}}美币</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                        <span data-orderid="{{id}}"  class="refuse refuse_status_3">取消约单</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}"  class="refuse refuse_status_3">拒绝</span>
                        <span data-orderid="{{id}}"  class="refuse receive_order">接单</span>
                    <?php endif; ?>
                </div>
                {{/finish_prepay}}
                {{#cancel_status_4}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                        <span data-orderid="{{id}}"  class="receive_order">退款成功</span>
                    <?php endif; ?>
                </div>
                {{/cancel_status_4}}
                {{#finish_receive}}
                <h3 class="pay_desc color_y">待付尾款</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                        <span data-orderid="{{id}}" class="refuse pay_status_7" >付尾款</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}"  class="refuse cancel_order refuse_status_7">取消订单</span>
                    <?php endif; ?>
                </div>
                {{/finish_receive}}
                {{#cancel_status_8}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 1): ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >退款成功</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >惩罚成功</span>
                    <?php endif; ?>
                </div>
                {{/cancel_status_8}}
                {{#m_timeout_payall}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >补偿成功</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >惩罚成功</span>
                    <?php endif; ?>
                </div>
                {{/m_timeout_payall}}
                {{#finsh_payall}}
                <h3 class="pay_desc color_y">等待赴约中</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}" class="refuse w_refuse_status_10" >取消订单</span>
                        <span data-orderid="{{id}}" class="refuse go_order" >确认到达</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse m_refuse_status_10" >取消订单</span>
                        <span data-orderid="{{id}}" data-stime="{{start_time}}" class="refuse go_order" >赴约成功</span>
                    <?php endif; ?>
                </div>
                {{/finsh_payall}}
                {{#finsh_payall_begin}}
                <h3 class="pay_desc color_y">赴约中</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}" class="refuse go_order" >确认到达</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse complain" >投诉</span>
                        <span data-orderid="{{id}}" data-stime="{{start_time}}" class="refuse go_order" >赴约成功</span>
                    <?php endif; ?>
                </div>
                {{/finsh_payall_begin}}
                {{#cancel_status_11}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >补偿成功</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >惩罚成功</span>
                    <?php endif; ?>
                </div>
                {{/cancel_status_11}}
                {{#cancel_status_12}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >惩罚成功</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                        <span data-orderid="{{id}}" class="refuse" >补偿成功</span>
                    <?php endif; ?>
                </div>
                {{/cancel_status_12}}
            </div>
        </div>
    </li>
    {{/orders}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
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
<?php $this->start('script'); ?>
<script>
    var curpage = 1;
    var query = 0;
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

    $(document).on('tap', '.pay_status_1', function () {
        //支付预约金
        var orderid = $(this).data('orderid');
        $.util.confirm('确定支付？', '将扣除美币作为预约金', function () {
            $.util.ajax({
                url: '/date-order/order-pay/' + orderid,
                func: function (resp) {
                    if (resp.status) {
                        //聊天框
                        $.util.alert(resp.msg);
                        //LEMON.event.imTalk();
                    } else {
                        if (resp.code == '201') {
                            //余额不足
                            $.util.alert(res.msg);
                            setTimeout(function () {
                                window.location.href = res.redirect_url;
                            }, 300);
                        }
                    }
                }
            });
        })
    });
    $(document).on('tap', '.remove_order', function () {
        //删除订单
        var orderid = $(this).data('orderid');
        var obj = $(this);
        $.util.confirm('提示', '确定删除订单么', function () {
            $.util.ajax({
                url: '/date-order/remove-order',
                data: {order_id: orderid},
                func: function (res) {
                    $.util.alert(res.msg);
                    if (res.status) {
                        setTimeout(function () {
                            obj.parents('li').remove();
                        }, 600)
                    }
                }
            });
        })

    });
    $(document).on('tap', '.pay_status_7', function () {
        //支付尾款
        var orderid = $(this).data('orderid');
        $.util.confirm('确定支付？', '将扣除美币支付尾款', function () {
            $.util.ajax({
                url: '/userc/orderPayall',
                data: {order: orderid},
                func: function (resp) {
                    if (resp.status) {
                        //聊天框
                        $.util.alert(resp.msg);
                        //LEMON.event.imTalk();
                    } else {
                        if (resp.code == '201') {
                            //余额不足
                            $.util.alert(res.msg);
                            setTimeout(function () {
                                window.location.href = res.redirect_url;
                            }, 300);
                        }
                    }
                }
            });
        })
    });
    $(document).on('tap', '.receive_order', function () {
        //美女接收订单
        var orderid = $(this).data('orderid');
        $.util.ajax({
            url: '/userc/receive-order',
            data: {orderid: orderid},
            func: function (res) {
                $.util.alert(res.msg);
                setTimeout(function () {
                    refresh();
                }, 300);
            }
        })
    });
    $(document).on('tap', '.refuse_status_3', function () {
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
    $(document).on('tap', '.refuse_status_7', function () {
        //状态7时 女方取消订单
        var orderid = $(this).data('orderid');
        $.util.confirm('确定要取消订单吗?', '将会扣除20%的约单金额作为惩罚。', function () {
            $.util.ajax({
                url: '/date-order/cancel-date-order-7',
                data: {order_id: orderid},
                func: function (res) {
                    $.util.alert(res.msg);
                    setTimeout(function () {
                        refresh();
                    }, 300);
                }
            })
        })
    });
    $(document).on('tap', '.m_refuse_status_10', function () {
        //状态10时 男方取消订单
        var orderid = $(this).data('orderid');
        var stime = $(this).data('stime');
        var text;
        if ((new Date(stime) - new Date()) > 2 * 60 * 60) {
            text = '平台将只退回约单金额的70%,剩余的30%将打至美女账户';
        } else {
            text = '平台将只退回约单金额的30%,剩余的70%将打至美女账户';
        }
        $.util.confirm('确定要取消订单吗?', text, function () {
            $.util.ajax({
                url: '/date-order/cancel-date-order-10',
                data: {order_id: orderid},
                func: function (res) {
                    $.util.alert(res.msg);
                    setTimeout(function () {
                        refresh();
                    }, 300);
                }
            });
        });
    });
    $(document).on('tap', '.w_refuse_status_10', function () {
        //状态10时 女方取消订单
        var orderid = $(this).data('orderid');
        $.util.confirm('确定要取消订单吗?', '将会扣除20%的约单金额作为惩罚。', function () {
            $.util.ajax({
                url: '/date-order/cancel-date-order-10',
                data: {order_id: orderid},
                func: function (res) {
                    $.util.alert(res.msg);
                    setTimeout(function () {
                        refresh();
                    }, 300);
                }
            })
        })
    });
    $(document).on('tap', '.go_order', function () {
        //状态10时 女方取消订单
        var orderid = $(this).data('orderid');
        $.util.ajax({
            url: '/date-order/go-order',
            data: {order_id: orderid},
            func: function (res) {
                $.util.alert(res.msg);
                setTimeout(function () {
                    refresh();
                }, 300);
            }
        })
    });
    $('.date_list_header div').on('tap', function () {
        //tap切换
        curpage = 1;
        query = $(this).data('query');
        $('.date_list_header div').removeClass('cur current');
        $(this).addClass('cur current');
        $(this).find('i').first().hide();
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
                console.log(n.status);
                if ($.inArray(n.status, [1]) !== -1) {
                    data.orders[i]['wait_prepay'] = true;  //订单生成 未支付预约金
                }
                if ($.inArray(n.status, [3]) !== -1) {
                    data.orders[i]['finish_prepay'] = true;  //男方支付完预约金 等待女方确认
                }
                if ($.inArray(n.status, [4]) !== -1) {
                    data.orders[i]['cancel_status_4'] = true;  //男性取消订单
                }
                if ($.inArray(n.status, [7]) !== -1) {
                    data.orders[i]['finish_receive'] = true;  //女方确认接单 等待支付尾款
                }
                if ($.inArray(n.status, [8]) !== -1) {
                    data.orders[i]['cancel_status_8'] = true;  //女方确认接单 等待支付尾款
                }
                if ($.inArray(n.status, [9]) !== -1) {
                    data.orders[i]['m_timeout_payall'] = true;  //受邀者超时未付尾款
                }
                if ($.inArray(n.status, [10]) !== -1) {
                    if (new Date() > new Date(n.start_time)) {
                        data.orders[i]['finsh_payall_begin'] = true;  //付了尾款并且到了约会时间
                    } else {
                        data.orders[i]['finsh_payall'] = true;  //受邀者付尾款
                    }
                }
                if ($.inArray(n.status, [11]) !== -1) {
                    data.orders[i]['cancel_status_11'] = true;  //受邀者超时未付尾款
                }
                if ($.inArray(n.status, [12]) !== -1) {
                    data.orders[i]['cancel_status_12'] = true;  //受邀者超时未付尾款
                }
                if ($.inArray(n.status, [12]) !== -1) {
                    data.orders[i]['cancel_status_12'] = true;  //受邀者超时未付尾款
                }
            });
        }
        return data;
    }

    LEMON.sys.back('/user/index');
    function refresh() {
        $.util.asyLoadData({
            gurl: '/userc/getDateorders/',
            page: curpage,
            tpl: '#order-list-tpl',
            id: '#order-list',
            key: 'orders',
            query: '?query=' + query,
            func: calFunc
        });
    }
</script>
<?php $this->end('script'); ?>