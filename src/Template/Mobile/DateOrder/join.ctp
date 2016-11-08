<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>约会详情</h1>
    </div>
</header>
<div class="wraper">
    <div class="find_date_detail">
        <div class="activity_tips">
            <p>请抓紧时间，共有12人同时在支付中···</p>
        </div>
        <div class="date_detail_place inner">
            <h3 class="title"><i class="itemsname color_y"><?= $date['skill']['name'] ?></i><?= $date['title'] ?></h3>
            <div class="place_pic">
							<span class="place">
								<img src="/mobile/images/date_place.jpg"/>
							</span>
                <div class="place_info">
                    <h3 class="userinfo"><?= $date['user']['nick'] ?><span> <?= getAge($date['user']['birthday']) ?></span></h3>
                    <h3 class="otherinfo">
                        <time class="color_gray"><i class="iconfont">&#xe622;</i> <?= getFormateDT($date['start_time'], $date['end_time']);?></time>
                        <address class="color_gray"><i class="iconfont">&#xe623;</i> <?= $date['site'] ?></address>
                    </h3>
                </div>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">约会说明</h3>
            <div class="con date_keyword">
                <p><?= $date['description'] ?></p>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">我的标签</h3>
            <div class="con con_mark">
                <?php foreach ($date['tag'] as $item): ?>
                    <a class="mark"><?= $item['name'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="date_des mt40">
            <div class="con">
                <div class="date_time  flex flex_justify">
                    <span>使用优惠</span>
                    <div class="color_gray">无可用优惠  <i class="iconfont">&#xe605;</i></div>
                </div>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">支付方式</h3>
            <div class="con">
                <div class="date_time  flex flex_justify">
                    <span>我的钱包</span>
                    <div class="color_y"><?= $date['user']['money'] ?> 美币</div>
                </div>
            </div>
        </div>
        <p class="common commontitle inner mt20"><i class="iconfont">&#xe619;</i>报名即代表你已同意<a href="#this" class="color_y undertext">用户协议。</a></p>
    </div>
</div>
<div style="height:1.4rem;"></div>
<div class="bottomblock">
    <div class="flex flex_end">
        <span class="total">约会金：<i class="color_y"></i> <span class="color_y"><i class="color_y lagernum"><?= getCost($date['start_time'], $date['end_time'], $date['price']); ?></i>美币</span></span>
        <a class="nowpay">立即支付</a>
    </div>
</div>


<script>

    $(".toback").on('click', function(){

        history.back();

    })


    $(".nowpay").on('click', function(){

        $.ajax({
            url: "/date-order/",
            type: "POST",
            data: options,
            dataType: "json",
            success: function (res) {

                if (res.status) {


                }

            }

        });

    })

</script>