<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>约会详情</h1>
    </div>
</header>
<div class="wraper">
    <div class="find_date_detail">
        <div class="date_detail_place inner">
            <h3 class="title">
                <i class="itemsname color_y">
                    [<?= $date['user_skill']['skill']['name'] ?>]
                </i>
                <?= $date['title'] ?>
            </h3>
            <div class="place_pic">
							<span class="place">
								<img src="/mobile/images/date_place.jpg"/>
							</span>
                <div class="place_info">
                    <h3 class="userinfo">
                        <?= $date['user']['nick'] ?>
                        <span>
                            <?= getAge($date['user']['birthday']) ?>岁
                        </span>
                    </h3>
                    <h3 class="otherinfo">
                        <time class="color_gray">
                            <i class="iconfont">&#xe622;</i>
                            <?= getFormateDT($date['start_time'], $date['end_time']);?>
                        </time>
                        <address class="color_gray">
                            <i class="iconfont">&#xe623;</i>
                            <?= $date['site'] ?>
                        </address>
                    </h3>
                </div>
            </div>
        </div>
        <div class="date_des change-date-detail  mt20">
             <ul class="outerblock bgff">
                <li>
                    <h3 class="commontitle pt10">约会说明</h3>
                    <div class="con date_keyword">
                        <p><?= $date['description'] ?></p>
                    </div>
                </li>
                <li class="flex">
                     <?php if(count($date['tags']) > 0): ?><h3 class="commontitle">我的标签</h3>
                        <div class="con con_mark flex">
                            <?php foreach ($date['tags'] as $item): ?>
                                 <a class="mark"><?= $item['name'] ?></a>
                             <?php endforeach; ?>
                        </div>
                     <?php endif; ?>
                </li>
             </ul>
        </div>
       
        <div class="date_des mt20">
            <div class="con inner">
                <div class="date_time  flex flex_justify">
                    <span>我的钱包</span>
                    <div class="color_y"><?= isset($user)?$user['money']:'0' ?> 美币</div>
                </div>
            </div>
        </div>
        <p class="common commontitle inner mt20">
            <i class="iconfont">&#xe619;</i>报名即代表你已同意
            <a href="#this" class="color_y undertext">用户协议。</a>
        </p>
    </div>
</div>
<div style="height:1.4rem;"></div>
<div class="bottomblock">
    <div class="flex flex_end">
        <span class="total">约会金：<i class="color_y"></i>
            <span class="color_y">
                <i class="color_y lagernum"><?= getCost($date['start_time'], $date['end_time'], $date['price']); ?></i>美币
            </span>
        </span>
        <a id="order_pay" class="nowpay">立即支付</a>
    </div>
</div>


<script>

    $('.toback').on('click', function(){

        history.back();

    })


    $('#order_pay').on('tap',function(){
        //预约支付
        var dom = $(this);
        if(dom.hasClass('disabled')){
            return false;
        }
        dom.addClass('disabled');
        $.util.ajax({
            url: '/date-order/order-date/<?= $date->id; ?>',
            func:function(res){
                if(res.status){
                    window.location.href = res.redirect_url;
                }else{
                    dom.removeClass('disabled');
                }
            }
        });
    });
    LEMON.event.unrefresh();

</script>