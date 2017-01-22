<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1>活动详情</h1>
        <!--<span class="iconfont r_btn ico">&#xe62d;</span>-->
    </div>
</header> -->
<div class="wraper">
    <div class="activity_detail_box">
        <img src="<?= $activity['big_img']; ?>" alt="" />
        <div class="tips"><?= $activity['title'] ?></div>
    </div>
    <div class="activity_detail_bottomdes">
        <div class="desc">
            <span class="title">美约独家</span>
        </div>
        <p class="bottom_des color_y"><i class="l_sprit iconfont">&#xe64d;</i> <?= $activity['description'] ?>  <i class="r_sprit iconfont">&#xe64d;</i></p>
    </div>
    <div class="activity_detail_adress bgff mt20">
        <ul>
            <li class="flex">
                <i class="iconfont">&#xe64b;</i>
                <div class="r_info bdbottom">
                    <span><?= getFormateDT($activity['start_time'], $activity['end_time']) ?></span>
                </div>
            </li>
            <li class="flex">
                <i class="iconfont">&#xe623;</i>
                <div class="r_info">
                    <span><?= $activity['site']; ?></span>
                </div>
            </li>
        </ul>
    </div>
    <div class="activity_detail_infomation mt20 bgff">
        <ul>
            <li class="flex flex_justify bdbottom">
                <span>报名信息</span>
                <div class="r_info">
                    <div class="r_info_pic"  onclick="window.location.href = '/activity/mem-index/<?= $activity['id']; ?>'">
                        <span class="number">共<?= ($activity['male_lim'] - $activity['male_rest'] + $activity['female_lim'] - $activity['female_rest']);?>人</span>
                        <i class="iconfont">&#xe605;</i>
                    </div>

                </div>
            </li>
            <li class="flex flex_justify">
                <span>剩余名额</span>
                <div class="r_info">
                    <div class="r_info_pic flex">
                        <span class="sex">男：<i class="color_friends"><?= $activity['male_rest']?></i>/<?= $activity['male_lim']?>位</span>
                        <span class="sex">女：<i class="color_friends"><?= $activity['female_rest']?></i>/<?= $activity['female_lim']?>位</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="activity_initiate bgff mt20">
        <h3 class="title">活动详细介绍</h3>
        <div class="bottom_info info inner">
            <?= $activity['detail']; ?>
        </div>
    </div>
    <!--活动须知-->
    <div class="activity_initiate bgff mt20">
        <h3 class="title">活动须知</h3>
        <div class="bottom_info info inner">
            <?= $activity['notice']; ?>
        </div>
    </div>
</div>
<div style="height:63px;"></div>

        <?php if ($botBtSts == 0): ?>
        <div class="bottomblock">
            <div class="flex flex_end">
                <span class="total"><span class="color_y"><i><?= ($user['gender'] == 1)?$activity['male_price']:$activity['female_price']; ?> </i>元/人</span></span>
                <a onclick="topay();" class="nowpay">我要报名</a>
            </div>
            </div>
        <?php elseif ($botBtSts == 1): ?>
            <a class="identify_footer_potion">人数已满</a>
        <?php elseif ($botBtSts == 2): ?>
            <a class="identify_footer_potion">报名成功</a>
        <?php elseif ($botBtSts == 3 && $cancancle): ?>
            <div class="bottomblock">
                <div class="flex flex_end">
                    <span class="total"><span class="color_y">购买数量：<i><?= $regist_item->num; ?></i></span></span>
                    <a onclick="cancel();" class="nowpay">我要取消</a>
                </div>
            </div>
        <?php elseif ($botBtSts == 3 && !$cancancle): ?>
            <a class="identify_footer_potion">报名成功</a>
        <?php elseif ($botBtSts == 4): ?>
            <a class="identify_footer_potion">正在进行</a>
        <?php elseif ($botBtSts == 5): ?>
            <a class="identify_footer_potion">活动已结束</a>
        <?php else: ?>
            <a class="identify_footer_potion">异常状态</a>
        <?php endif; ?>


<script>

    function topay() {
        window.location.href = '/activity/pay-view/<?= $activity['id']; ?>';
    };

    function cancel() {
        <?php if($regist_item): ?>
        $.util.confirm(
            '取消派对',
            '将扣除报名费<?= $regist_item['punish_percent'] ?>%(即<?= $regist_item['punish'] ?>元）作为惩罚',
            function() {
                $.util.ajax({
                    url: '/activity/cancel/<?= $regist_item['id']; ?>',
                    type: "POST",
                    dataType: "json",
                    func: function (res) {
                        $.util.alert(res.msg);
                        if(res.status) {
                            setTimeout(function() {
                                window.location.href = '/userc/my-activitys';
                            }, 1000)
                        }
                    }
                })
            },
            null
        );
        <?php endif; ?>
    }
    //LEMON.sys.back('/user/index');
</script>