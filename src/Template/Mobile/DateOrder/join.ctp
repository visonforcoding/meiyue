<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>约会详情</h1>
        <!--<span class="r_btn">编辑</span>-->
    </div>
</header>
<div class="wraper">
    <div class="find_date_detail">
        <div class="date_top_con flex inner">
            <span class="place"><img src="/mobile/images/date_place.jpg"/></span>
            <h3 class="date_top_con_right">
                <span class="date_ability"><?= $date['skill']['name']?></span>
                <span class="date_guest"><?= $date['user']['nick']; ?>
                    <i class="iconfont color_y">
                        <?php if($date['user']['gender'] == 2): ?>
                            &#xe61d;
                        <?php else: ?>
                            &#xe61c;
                        <?php endif; ?>
                    <i class="age color_y"><?= getAge($date['user']['birthday']); ?></i></span>
                <span class="date_much"><i><?= $date['price']; ?></i> 美币/小时</span>
            </h3>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">约会说明</h3>
            <div class="con date_keyword">
                <p><?= $date['description']; ?></p>
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
        <div class="date_des mt20">
            <h3 class="commontitle inner">邀约时间与地点</h3>
            <div class="con com_choose_time">
                <ul class="outerblock">
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>时间</span>
                            <div>
                                <span><?= getFormateDT($date['start_time'], $date['end_time']);?></span>
                                <i class="iconfont r_con">&#xe605;</i>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>地点</span>
                            <div>
                                <span class="color_gray">请选择</span>
                                <i class="iconfont r_con">&#xe605;</i>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="date_des">
                <h3 class="commontitle inner">总费用</h3>
                <div class="con">
                    <ul class="outerblock">
                        <li>
                            <div class="date_time flex flex_justify">
                                <span>共<i class="color_y">3</i>小时</span>
                                <div>
                                    <span>合计：<i class="lagernum color_y">900</i><i class="color_y">美币</i></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="date_time  flex flex_justify">
                                <span>预约金</span>
                                <div>
                                    <span>900*20%=180 美币</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="commontips mt10 inner">* 预约金是您对对方的许诺,占总费用的20%;若对方同意后，您爽单，则预约金归对方所有；若对方不同意，则预约金全数退还。</p>
            </div>
            <div class="date_des mt20">
                <h3 class="commontitle inner">支付方式</h3>
                <div class="con">
                    <div class="date_time  flex flex_justify">
                        <span>我的钱包</span>
                        <div class="color_y">90 美币</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height:1.4rem;"></div>
    <div class="bottomblock">
        <div class="flex flex_end">
            <span class="total">预约金：<i class="color_y">￥</i> <span class="color_y"><i class="color_y lagernum">180 </i>美币</span></span>
            <a href="javascript:void(0);" class="nowpay">立即支付</a>
        </div>
    </div>