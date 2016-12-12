<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>约会详情</h1>
        <span class="r_btn iconfont ico">&#xe603;</span>
    </div>
</header>
<div class="wraper">
    <div class="date_head_info">
        <div class="date_head_con inner flex flex_justify">
            <div class="l_info">
                <span class="avatar">
                    <?php if ($user->gender == 1): ?>
                        <a href="/index/homepage/<?= $order->dater->id; ?>"><img src="<?= $order->dater->avatar ?>"/></a>
                    <?php else: ?>
                        <a href=""><img src="<?= $order->buyer->avatar ?>"/></a>
                    <?php endif; ?>
                </span>
                <div class="l_con">
                    <?php if ($user->gender == 1): ?>
                        <h3><?= $order->dater->nick ?></h3>
                    <?php else: ?>
                        <h3><?= $order->buyer->nick ?></h3>
                    <?php endif; ?>
                    <div class="age color_y">
                        <i class="iconfont translate">
                            <?php if ($user->gender == 1): ?>
                                &#xe61d;
                            <?php else: ?>
                                &#xe61c;
                            <?php endif; ?>
                        </i>
                        <?php if ($user->gender == 1): ?>
                            <?= getAge($order->dater->birthday) ?>岁
                        <?php else: ?>
                            <?= getAge($order->buyer->birthday) ?>岁
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="color_y lagernum">
                <?php if ($user->gender == 1): ?>
                    <?php if ($order->status == 1): ?>
                        等待支付预约金中
                        <h3 class="color_y tips">对方已接单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 2): ?>
                        订单关闭
                        <h3 class="color_y tips">支付超时</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 3): ?>
                        等待对方确认中
                        <h3 class="color_y tips">已支付预约金</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 5): ?>
                        订单关闭
                        <h3 class="color_y tips">对方已拒绝</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 6): ?>
                        订单关闭
                        <h3 class="color_y tips">对方超时未作出响应</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 7): ?>
                        等待你支付尾款
                        <h3 class="color_y tips">对方已接单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 8): ?>
                        订单关闭
                        <h3 class="color_y tips">对方已拒绝</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 9): ?>
                        订单关闭
                        <h3 class="color_y tips">超时未支付尾款，自动关闭</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 10): ?>
                        等待对方赴约中
                        <h3 class="color_y tips">请提前预定好场地</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 11): ?>
                        订单关闭
                        <h3 class="color_y tips">您已取消订单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 12): ?>
                        订单关闭
                        <h3 class="color_y tips">对方已取消订单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 13): ?>
                        对方已到达
                        <h3 class="color_y tips">还剩6小时自动确认订单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 15): ?>
                        交易成功
                    <?php endif; ?>
                    <?php if ($order->status == 16): ?>
                        交易成功
                        <h3 class="color_y tips">已评价</h3>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($order->status == 3): ?>
                        等待确认中
                        <h3 class="color_y tips">对方已支付预约金</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 5): ?>
                        订单关闭
                        <h3 class="color_y tips">您已拒绝</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 6): ?>
                        订单关闭
                        <h3 class="color_y tips">您超时未作出响应</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 7): ?>
                        等待对方支付尾款
                        <h3 class="color_y tips">你已确认接单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 8): ?>
                        订单关闭
                        <h3 class="color_y tips">您已拒绝</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 9): ?>
                        订单关闭
                        <h3 class="color_y tips">对方超时未支付尾款</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 10): ?>
                        约单已生成
                        <h3 class="color_y tips">请及时到达约会地点</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 11): ?>
                        订单关闭
                        <h3 class="color_y tips">对方已取消</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 12): ?>
                        订单关闭
                        <h3 class="color_y tips">您已取消订单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 13): ?>
                        等待对方确认
                        <h3 class="color_y tips">您已确认到达</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 15): ?>
                        交易成功
                    <?php endif; ?>
                    <?php if ($order->status == 16): ?>
                        交易成功
                        <h3 class="color_y tips">对方已评价</h3>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--约吃饭-->
    <div class="date_ability_list bgff mt20">
        <div class="title flex flex_justify inner">
            <h3><i class="color_y">[<?= $order->user_skill->skill->name ?>]</i> <?= ($order->date) ? $order->date->title : '' ?></h3>
            <span class="smallarea"><?= $order->price ?>美币/小时</span>
        </div>
        <ul class="outerblock btop inner">
            <li class="flex flex_justify">
                <div class="date_info">
                    <h3 class="time"><i>时间 </i><?= getFormateDT($order->start_time, $order->end_time) ?></h3>
                    <h3 class="address"><i>地点 </i><?= $order->site ?></h3>
                </div>
                <span>共2小时</span>
            </li>
            <li class="flex ">
                <div class="date_info">
                    <h3 class="time">约会说明：<?= $order->user_skill->description ?></h3>
                </div>
            </li>
            <li class="flex">
                <div class="date_info">
                    <h3 class="time"><i>我的标签：</i>
                        <?php foreach ($order->dater->tags as $tag): ?>
                            <a href="#this"><?= $tag->name ?></a>
                        <?php endforeach; ?>
                    </h3>
                </div>
            </li>
        </ul>
    </div>
    <!--付款详情-->
    <div class="date_ability_pay mt20">
        <h3 class="commontitle inner">付款详情</h3>
        <ul class="b_content outerblock bgff inner">
            <li class="flex flex_justify">
                <div>合计</div><div><?= $order->amount ?>美币</div>
            </li>
            <li class="flex flex_justify">
                <?php if (in_array($order->status, ['13', '10'])): ?>
                    <div>已支付</div><div><?= $order->amount ?>美币</div>
                <?php endif; ?>
            </li>
        </ul>
        <?php if ($order->status == 7): ?>
            <div class="flex flex_justify date_bosses inner">
                <div class="bold">剩余尾款</div><div class="color_y"><?= $order->amount - $order->pre_pay ?>美币</div>
            </div>
        <?php endif; ?>
        <p class="commontips inner mt20"><a href="#this" class="color_y">退款规则</a></p>
    </div>
</div>
<div style="height:62px;"></div>
<?php if ($user->gender == 1): ?>
    <?php if ($order->status == 1): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span class="total">预约金:<span class="color_y"><?= $order->pre_pay ?> </i>美币</span></span>
                <a  data-id="<?= $order->id ?>" id="prepay" class="nowpay">付款</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 2): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span  id="remove_order" class="footerbtn gopay">删除订单</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 3): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span  id="refuse_status_3" class="footerbtn gopay">取消订单</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 7): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span class="total">剩余尾款数:<span class="color_y"><?= $order->amount - $order->pre_pay ?> </i>美币</span></span>
                <a  data-id="<?= $order->id ?>" id="payall" class="nowpay">立即支付</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 10): ?>
        <div class="potion_footer flex flex_justify">
            <span id="refuse_status_10" class="footerbtn cancel">取消约单</span>
            <span id="godate" class="footerbtn gopay">赴约成功</span>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 16): ?>
        <div class="potion_footer flex flex_justify">
            <a href="/date-order/appraise/<?= $order->id ?>" class="footerbtn cancel">查看评价</a>
            <span  id="remove_order" class="footerbtn gopay">删除订单</span>
        </div>
    <?php endif; ?>
<?php else: ?>
    <!--女性-->
    <?php if ($order->status == 3): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span id="refuse_status_3" class="footerbtn cancel">拒绝</span>
                <span  id="receive_order" class="footerbtn gopay">接单</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 4): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span id="refuse_status_3" class="footerbtn cancel">拒绝</span>
                <span  id="receive_order" class="footerbtn gopay">接单</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 7): ?>
        <a href="login_identify_jump.html" class="identify_dark_potion">取消约单</a>
    <?php endif; ?>
    <?php if ($order->status == 10): ?>
        <div class="potion_footer flex flex_justify">
            <span id="refuse_status_10" class="footerbtn cancel">取消约单</span>
            <span  id="godate" class="footerbtn gopay">到达约会目的地</span>
        </div>
    <?php endif; ?>
    <?php if ($order->status == 16): ?>
        <div class="potion_footer flex flex_justify">
            <span  id="remove_order" class="footerbtn gopay">删除订单</span>
            <a href="/date-order/appraise/<?= $order->id ?>"><span  class="footerbtn cancel">查看评价</span></a>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $this->start('script'); ?>
<script>
    var orderid = <?= $order->id ?>;
    $('#payall').on('tap', function () {
        //立即支付尾款
        console.log('test');
        var id = $(this).data('id');
        $.util.ajax({
            url: '/userc/order-payall',
            data: {order: id},
            func: function (res) {
                $.util.alert(res.msg);
            }
        });
    });
    var refuse_msg = '<?= $refuse_msg ?>';
    $(document).on('tap', '#refuse_status_10', function () {
        //状态10时 取消订单
        $.util.confirm('确定要取消订单吗?', refuse_msg, function () {
            $.util.ajax({
                url: '/date-order/cancel-date-order-10',
                data: {order_id: orderid},
                func: function (res) {
                    $.util.alert(res.msg);
                }
            })
        })
    });
    $(document).on('tap', '#receive_order', function () {
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
    $('#godate').on('tap', function () {
        //赴约成功
        $.util.ajax({
            url: '/userc/order-go',
            data: {order: orderid},
            func: function (res) {
                $.util.alert(res.msg);
            }
        });
    });
    $(document).on('tap', '#remove_order', function () {
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
</script>
<?php $this->end('script'); ?>