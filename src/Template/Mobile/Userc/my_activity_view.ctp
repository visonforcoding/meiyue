<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1>活动详情</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="activity_detail_box">
        <?php $activity = $actregistration['activity']; ?>
        <img src="<?= $activity['big_img']; ?>" alt=""/>
        <div class="tips"><?= $activity['title'] ?></div>
    </div>
    <div class="activity_detail_bottomdes">
        <div class="desc">
            <span class="title">美约独家</span>
        </div>
        <p class="bottom_des color_y"><i class="l_sprit iconfont">&#xe64d;</i> <?= $activity['description'] ?> <i
                class="r_sprit iconfont">&#xe64d;</i></p>
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
                    <div class="r_info_pic"
                         onclick="window.location.href = '/activity/mem-index/<?= $activity['id']; ?>'">
                        <span
                            class="number">共<?= ($activity['male_lim'] - $activity['male_rest'] + $activity['female_lim'] - $activity['female_rest']); ?>
                            人</span>
                        <i class="iconfont">&#xe605;</i>
                    </div>

                </div>
            </li>
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

<?php if ($actstatus == 0): ?>
    <a class="identify_footer_potion">异常状态</a>
<?php elseif ($actstatus == 1): ?>
    <div class="potion_footer flex flex_justify">
        <span onclick="toCancel();" class="footerbtn cancel">我要取消</span>
        <span class="footerbtn gopay"><?= ($user->gender == 2)?'报名成功':'购买数量：'.$actregistration->num;?></span>
    </div>
<?php elseif ($actstatus == 2): ?>
    <a class="identify_footer_potion">您已取消</a>
<?php elseif ($actstatus == 3): ?>
    <a class="identify_footer_potion">活动结束</a>
<?php elseif ($actstatus == 4): ?>
    <a class="identify_footer_potion">您已报名,审核中</a>
<?php elseif ($actstatus == 5): ?>
    <a class="identify_footer_potion">您已报名,审核不通过</a>
<?php elseif ($actstatus == 6): ?>
    <a class="identify_footer_potion">报名成功</a>
<?php endif; ?>
<script>
    function toCancel() {
        <?php if($user->gender == 1): ?>
        $.util.confirm(
            '取消派对',
            '将扣除报名费<?= $actregistration['punish_percent'] ?>%(即<?= $actregistration['punish'] ?>美币）作为惩罚',
            function() {
                $.util.ajax({
                    url: '/activity/cancel/<?= $actregistration['id']; ?>',
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
        <?php else: ?>
        $.util.confirm(
            '取消派对',
            '确定要取消派对报名吗?',
            function() {
                $.util.ajax({
                    url: '/activity/cancel/<?= $actregistration['id']; ?>',
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
</script>