<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="order-list-tpl" type="text/html">
    {{#orders}}
    <li>
        <div class="date_item_des">
            <div class="flex flex_justify bdbottom">
                <h3 class='maxwid70'><i class="itemsname">[{{user_skill.skill.name}}]</i></h3>
                <span class="customer">{{buyer.nick}}</span>
            </div>
            <a style="display:block" href="/date-order/order-detail/{{id}}">
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
                        <span data-orderid="{{id}}"  class="refuse">退款成功</span>
                    <?php endif; ?>
                </div>
                {{/cancel_status_4}}
                {{#refuse_status_5}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                        <span data-orderid="{{id}}"  class="receive_order">退款成功</span>
                    <?php endif; ?>
                </div>
                {{/refuse_status_5}}
                {{#w_timeout_receive}}
                <h3 class="pay_desc color_y">订单关闭</h3>
                <div class="groupbtn">
                    <?php if ($user->gender == 2): ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                        <span data-orderid="{{id}}"  class="refuse">惩罚成功</span>
                    <?php else: ?>
                        <span data-orderid="{{id}}"  class="refuse remove_order">删除订单</span>
                        <span data-orderid="{{id}}"  class="refuse">退款成功</span>
                    <?php endif; ?>
                </div>
                {{/w_timeout_receive}}
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
                {{#confirm_go}}
                <?php if ($user->gender == 2): ?>
                    <h3 class="pay_desc color_y">等待对方确认</h3>
                    <div class="groupbtn">
                        <span data-orderid="{{id}}" class="refuse" >我已到达</span>
                    </div>
                <?php else: ?>
                    <h3 class="pay_desc color_y">对方已到达</h3>
                    <div class="groupbtn">
                        <span data-orderid="{{id}}" class="refuse complain" >投诉</span>
                        <span data-orderid="{{id}}" class="refuse go_order" >赴约成功</span>
                    </div>
                <?php endif; ?>
                {{/confirm_go}}
                {{#finish_order}}
                <?php if ($user->gender == 2): ?>
                    <h3 class="pay_desc color_y">交易成功</h3>
                    <div class="groupbtn">
                        <span data-orderid="{{id}}" class="refuse" >查看评价</span>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                    </div>
                <?php else: ?>
                    <h3 class="pay_desc color_y">交易成功</h3>
                    <div class="groupbtn">
                        <a href="/date-order/appraise/{{id}}"><span data-orderid="{{id}}" class="refuse appraise" >评价</span></a>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                    </div>
                <?php endif; ?>
                {{/finish_order}}
                {{#finish_appraise}}
                <?php if ($user->gender == 2): ?>
                    <h3 class="pay_desc color_y">交易成功</h3>
                    <div class="groupbtn">
                        <a href="/date-order/view-appraise/{{id}}"><span data-orderid="{{id}}" class="refuse" >查看评价</span></a>
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                    </div>
                <?php else: ?>
                    <h3 class="pay_desc color_y">交易成功</h3>
                    <div class="groupbtn">
                        <span data-orderid="{{id}}" class="refuse remove_order" >删除订单</span>
                    </div>
                <?php endif; ?>
                {{/finish_appraise}}
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
                        $.util.openTalk(resp);
                    } else {
                        if (resp.code == '201') {
                            //余额不足
                            $.util.alert(resp.msg);
                            setTimeout(function () {
                                window.location.href = resp.redirect_url;
                            }, 500);
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
                url: '/date-order/orderPayall',
                data: {order: orderid},
                func: function (resp) {
                    if (resp.status) {
                        //聊天框
                        $.util.alert(resp.msg);
                        $.util.openTalk(resp);
                    } else {
                        if (resp.code == '201') {
                            //余额不足
                            $.util.alert(resp.msg);
                            setTimeout(function () {
                                window.location.href = resp.redirect_url;
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
            url: '/date-order/receive-order',
            data: {orderid: orderid},
            func: function (res) {
                $.util.alert(res.msg);
                setTimeout(function () {
                    $.util.openTalk(res);
                    //refresh();
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
                setTimeout(function () {
                    refresh();
                }, 300);
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
            text = '平台将只退回约单金额的70%,剩余的30%将打至美女账户作为补偿，是否继续？';
        } else {
            text = '平台将只退回约单金额的30%,剩余的70%将打至美女账户作为补偿，是否继续？';
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
            data: {order: orderid},
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
                switch (n.status) {
                    case 1:
                        data.orders[i]['wait_prepay'] = true;  //订单生成 未支付预约金
                        break;
                    case 3:
                        data.orders[i]['finish_prepay'] = true;  //男方支付完预约金 等待女方确认
                        break;
                    case 4:
                        data.orders[i]['cancel_status_4'] = true;  //男性取消订单
                        break;
                    case 5:
                        data.orders[i]['refuse_status_5'] = true;  //5状态  女性拒绝接单
                        break;
                    case 6:
                        data.orders[i]['w_timeout_receive'] = true;  //6状态  女性超时未接受
                        break;
                    case 7:
                        data.orders[i]['finish_receive'] = true;  //女方确认接单 等待支付尾款
                        break;
                    case 8:
                        data.orders[i]['cancel_status_8'] = true;  //女方确认接单 等待支付尾款
                        break;
                    case 9:
                        data.orders[i]['m_timeout_payall'] = true;  //受邀者超时未付尾款
                        break;
                    case 10:
                        if (new Date() > new Date(n.start_time)) {
                            data.orders[i]['finsh_payall_begin'] = true;  //付了尾款并且到了约会时间
                        } else {
                            data.orders[i]['finsh_payall'] = true;  //受邀者付尾款
                        }
                        break;
                    case 11:
                        data.orders[i]['cancel_status_11'] = true;  //受邀者超时未付尾款
                        break;
                    case 12:
                        data.orders[i]['cancel_status_12'] = true;  //受邀者超时未付尾款
                        break;
                    case 13:
                        data.orders[i]['confirm_go'] = true;  //女性用户确认到达
                        break;
                    case 15:
                        data.orders[i]['finish_order'] = true;  //女性用户确认到达
                        break;
                    case 16:
                        data.orders[i]['finish_appraise'] = true;  //男性已评价
                        break;
                }
            });
        }
        return data;
    }

    LEMON.sys.back('/user/index');
    function refresh() {
        var page = curpage-1;
        $.util.asyLoadData({
            gurl: '/userc/getDateorders/',
            page: page,
            tpl: '#order-list-tpl',
            id: '#order-list',
            key: 'orders',
            query: '?query=' + query,
            func: calFunc
        });
    }
</script>
<?php $this->end('script'); ?>