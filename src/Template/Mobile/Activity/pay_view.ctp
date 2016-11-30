<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>活动支付中</h1>
    </div>
</header>
<div class="wraper">
    <div class="activity_pay_detail flex box_start">
        <div class="picinfo">
            <img src='/mobile/images/activity_item.jpg'/>
        </div>
        <div class="r_info">
            <h3><?= isset($activity)?$activity['title']:'' ?></h3>
            <div class="time color_gray"><i class="iconfont">&#xe622;</i><?= isset($activity)?getFormateDT($activity['start_time'], $activity['end_time']):'' ?></div>
            <div class="address color_gray"><i class="iconfont">&#xe623;</i><?= isset($activity)?$activity['site']:'' ?></div>
        </div>
    </div>
    <div class="activity_pay_num inner">
        <ul class="outerblock">
            <li class="flex flex_justify">
                <div>购买数量</div>
                <div class="buybox flex">
                    <span id="reduce-num" class="iconfont reduce disabled">&#xe65b;</span>
                    <input id="num" name="num" type="number" value="1" />
                    <span id="add-num" class="iconfont add color_y">&#xe65a;</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="activity_pay_type mt20">
        <h3 class="commontitle inner ">我的钱包</h3>
        <div class="con flex flex_justify inner">
            <div>支付方式</div>
            <div class="color_y"><i class="lagernum"><?= isset($user)?$user->money:''; ?></i> 美币</div>
        </div>
    </div>
</div>
<div style="height:1.4rem;"></div>
<div class="bottomblock">
    <div class="flex flex_end">
        <span class="total"><span class="color_y">共计：<i class="color_y lagernum" id="count"><?= isset($price)?$price:0; ?> </i>美币</span></span>
        <a id="<?= isset($activity)?'pay':''; ?>" href="javascript:void(0);" class="nowpay">立即支付</a>
    </div>
</div>

<script>


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
        $('#count').text(curNum * <?= isset($price)?$price:0; ?>);

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


    $('#pay').on('click', function() {

        var num = parseInt($('#num').val());
        var price = <?= isset($price)?$price:0; ?>;
        var money = <?= isset($user)?$user->money:''; ?>;
        if(num * price > money) {

            $.util.alert('余额不足！');
            return;

        }
        //if(confirm("输入付款密码")) {
            $.ajax({
                url: '/activity/mpay/<?= $activity['id']; ?>/' + num,
                type: "POST",
                dataType: "json",
                success: function (res) {

                    $.util.alert(res.msg);
                    if(res.status) {

                        window.location.href = '/activity/view/<?= isset($activity)?$activity['id']:'' ?>';

                    }

                }
            })
        //}

    })

</script>