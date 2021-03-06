<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>活动报名</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="activity_pay_detail flex box_start">
        <div class="picinfo">
            <img src='<?= generateImgUrl(isset($activity['big_img'])?$activity['big_img']:''); ?>'/>
        </div>
        <div class="r_info">
            <h3><?= isset($activity)?$activity['title']:'' ?></h3>
            <div class="time color_gray"><i class="iconfont">&#xe622;</i><?= isset($activity)?getFormateDT($activity['start_time'], $activity['end_time']):'' ?></div>
            <div class="address color_gray"><i class="iconfont">&#xe623;</i><?= isset($activity)?$activity['site']:'' ?></div>
        </div>
    </div>
    <div class="activity_pay_num mt20">
        <ul class="outerblock">
            <li class="flex flex_justify">
                <span>剩余名额</span>
                <div class="r_info">
                    <div class="r_info_pic flex">
                        <span class="sex">男：<i
                                class="color_friends"><?= $activity['male_rest'] ?></i>/<?= $activity['male_lim'] ?>
                            位</span>
                        <span class="sex">女：<i
                                class="color_friends"><?= $activity['female_rest'] ?></i>/<?= $activity['female_lim'] ?>
                            位</span>
                    </div>
                </div>
            </li>
            <?php if($user->gender == 1): ?>
            <li class="flex flex_justify">
                <div>购买数量</div>
                <div class="buybox flex">
                    <span id="reduce-num" class="iconfont reduce disabled">&#xe65b;</span>
                    <input id="num" name="num" type="number" value="1" />
                    <span id="add-num" class="iconfont add color_y">&#xe65a;</span>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if($user->gender == 1): ?>
    <div class="activity_pay_type mt20">
        <div class="con flex flex_justify inner">
            <div>我的钱包</div>
            <div class="color_y"><i class="lagernum"><?= isset($user)?$user->money:''; ?></i> 元</div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div style="height:1.4rem;"></div>
<div class="bottomblock">
    <div class="flex flex_end">
        <?php if ($actstatus == 3): ?>
            <a class="identify_footer_potion">报名结束</a>
        <?php elseif ($actstatus == 1): ?>
            <span class="total"><span class="color_y">共计：<i class="color_y lagernum" id="count"><?= ($user->gender == 1)?$activity->male_price:$activity->female_price; ?> </i>元</span></span>
            <a id="pay" href="javascript:void(0);" class="nowpay">立即支付</a>
        <?php elseif ($actstatus == 4): ?>
            <a class="identify_footer_potion">您已报名,审核中</a>
        <?php elseif ($actstatus == 5): ?>
            <a class="identify_footer_potion">您已报名,审核不通过</a>
        <?php elseif (($actstatus == 6) && ($user->gender == 2)): ?>
            <a class="identify_footer_potion">您已报名</a>
        <?php else: ?>
            <a id="join" class="identify_footer_potion">我要报名</a>
        <?php endif; ?>
    </div>
</div>

<script>
    <?php if($user->gender == 2): ?>
    $('#join').on('click', function() {
        $(this).removeAttr('id');
        var obj = $(this);
        if($.util.checkLogin(null)) {
            $.util.showPreloader();
            $.util.ajax({
                url: '/activity/join/<?= $activity['id']; ?>',
                type: "POST",
                dataType: "json",
                func: function (res) {
                    $.util.hidePreloader();
                    $.util.alert(res.msg);
                    if(res.status) {
                        setTimeout(function() {
                            location.href = '/userc/my-activitys';
                        }, 1000)
                    } else {
                        obj.attr('id', 'join');
                    }
                }
            })
        }
    });
    <?php else: ?>
    $('#reduce-num').on('click', function(){
        var lim = <?= isset($lim)?$lim:0; ?>;
        var curNum = parseInt($('#num').val());
        var nextNum = curNum - 1;
        if(nextNum == 1) {
            $('#num').val(nextNum);
            $(this).removeClass('color_y');
            $(this).removeClass('disabled');
            $(this).addClass('disabled');
        } else if (nextNum > 1) {
            $('#num').val(nextNum);
            $(this).removeClass('disabled');
            $(this).removeClass('color_y');
            $(this).addClass('color_y');
        } else {
            $.util.alert('数量不能少于一');
        }
        if(nextNum < lim) {
            $('#add-num').removeClass('disabled');
            $('#add-num').removeClass('color_y');
            $('#add-num').addClass('color_y');
        } else {
            $('#add-num').removeClass('disabled');
            $('#add-num').removeClass('color_y');
            $('#add-num').addClass('disabled');
        }
        changeCount();
    });
    $('#add-num').on('click', function() {
        var lim = <?= isset($lim)?$lim:0; ?>;
        var curNum = parseInt($('#num').val());
        var nextNum = curNum + 1;
        if(nextNum == lim) {
            $('#num').val(nextNum);
            $(this).removeClass('color_y');
            $(this).removeClass('disabled');
            $(this).addClass('disabled');
        } else if (nextNum < lim) {
            $('#num').val(nextNum);
            $(this).removeClass('disabled');
            $(this).removeClass('color_y');
            $(this).addClass('color_y');
        } else {
            $.util.alert('不能超过报名名额！')
        }
        if(nextNum > 1) {
            $('#reduce-num').removeClass('disabled');
            $('#reduce-num').removeClass('color_y');
            $('#reduce-num').addClass('color_y');
        } else {
            $('#reduce-num').removeClass('disabled');
            $('#reduce-num').removeClass('color_y');
            $('#reduce-num').addClass('disabled');
        }
        changeCount();
    });
    function changeCount() {
        var curNum = parseInt($('#num').val());
        $('#count').text(curNum * <?= ($user->gender == 1)?$activity->male_price:$activity->female_price; ?>);
    }
    $('#num').bind('input propertychange', function() {
        var lim = <?= isset($lim)?$lim:0; ?>;
        var curNum = parseInt($(this).val());
        if(curNum > lim) {
            $(this).val(lim);
            $.util.alert("不能超过报名名额！");
        } else if(curNum < 1) {
            $(this).val(1);
            $.util.alert("数量不能少于一！");
        }
    });
    $(document).on('tap', '#pay', function() {
        var num = parseInt($('#num').val());
        var price = <?= isset($activity->price)?$activity->price:0; ?>;
        var money = <?= isset($user)?$user->money:''; ?>;
        var totalcount = num * price;
        if((totalcount > money) && price) {
            $.util.alert('钱包余额不足，立即充值');
            setTimeout(function() {
                //location.href='/purse/recharge?redurl=/activity/pay-view/<?= $activity['id']; ?>';
                location.href="/wx/pay/0/"+ totalcount +"?title=活动金额&pagetitle=活动支付&redurl=/activity/pay-view/<?= $activity['id']; ?>";
            }, 1000);
            return;
        }
        $(this).removeAttr('id');
        var obj = $(this);
        $.util.showPreloader();
        $.util.ajax({
            url: '/activity/mpay/<?= $activity['id']; ?>/' + num,
            type: "POST",
            dataType: "json",
            func: function (res) {
                $.util.hidePreloader();
                $.util.alert(res.msg);
                if(res.status) {
                    setTimeout(function() {
                        window.location.href = '/userc/my-activitys';
                    }, 1000)
                } else {
                    obj.attr('id', 'pay');
                }
            }
        })
    })
    <?php endif; ?>

</script>