<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
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
                        <img src="<?= $order->buyer->avatar ?>"/>
                    <?php else: ?>
                        <img src="<?= $order->dater->avatar ?>"/>
                    <?php endif; ?>
                </span>
                <div class="l_con">
                    <?php if ($user->gender == 1): ?>
                        <h3><?= $order->buyer->nick ?></h3>
                    <?php else: ?>
                        <h3><?= $order->dater->nick ?></h3>
                    <?php endif; ?>
                    <div class="age color_y"><i class="iconfont translate">&#xe61d;</i>
                        <?php if ($user->gender == 1): ?>
                            <h3><?= getAge($order->buyer->birthday) ?></h3>
                        <?php else: ?>
                            <h3><?= getAge($order->dater->birthday) ?></h3>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="color_y lagernum">
                <?php if ($user->gender == 1): ?>
                    <?php if ($order->status == 7): ?>
                        等待你支付尾款
                        <h3 class="color_y tips">对方已接单</h3>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($order->status == 7): ?>
                        等待对方支付尾款
                        <h3 class="color_y tips">你已确认接单</h3>
                    <?php endif; ?>
                    <?php if ($order->status == 10): ?>
                        约单已生成
                        <h3 class="color_y tips">请及时到达约会地点</h3>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--约吃饭-->
    <div class="date_ability_list bgff mt20">
        <div class="title flex flex_justify inner">
            <h3 class="color_y">[<?= $order->user_skill->skill->name ?>]</h3>
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
                <div>已支付预约金</div><div><?= $order->pre_pay ?>美币</div>
            </li>
        </ul>
        <?php if($order->status == 7): ?>
        <div class="flex flex_justify date_bosses inner">
            <div class="bold">剩余尾款</div><div class="color_y"><?= $order->amount - $order->pre_pay ?>美币</div>
        </div>
        <?php endif;?>
        <p class="commontips inner mt20"><a href="#this" class="color_y">退款规则</a></p>
    </div>
</div>
<div style="height:62px;"></div>
<?php if ($user->gender == 1): ?>
    <?php if ($order->status == 7): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span class="total">剩余尾款数:<span class="color_y"><?= $order->amount - $order->pre_pay ?> </i>美币</span></span>
                <a href="javascript:void(0);" data-id="<?=$order->id?>" id="payall" class="nowpay">立即支付</a>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php if ($order->status == 7): ?>
        <a href="login_identify_jump.html" class="identify_dark_potion">取消约单</a>
    <?php endif; ?>
    <?php if ($order->status == 10): ?>
        <div class="potion_footer flex flex_justify">
			<span class="footerbtn cancel">取消约单</span>
			<span  id="godate" class="footerbtn gopay">赴约成功</span>
		</div>
    <?php endif; ?>
<?php endif; ?>

<?php $this->start('script'); ?>
<script>
    var orderid = <?=$order->id?>;
    $('#payall').on('tap',function(){
        //立即支付尾款
        var id = $(this).data('id');
        $.util.ajax({
           url:'/userc/order-payall',
           data:{order:id},
           func:function(res){
               $.util.alert(res.msg);
           }
        });
    });
    $('#godate').on('tap',function(){
        //赴约成功
        $.util.ajax({
           url:'/userc/order-payall',
           data:{order:id},
           func:function(res){
               $.util.alert(res.msg);
           }
        });
    });
</script>
<?php $this->end('script'); ?>