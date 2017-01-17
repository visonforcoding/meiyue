<?php use Cake\I18n\Time; ?>
<!-- <header>
    <div class="header">
        <span class="iconfont toback" onclick="history.back();">&#xe602;</span>
        <h1>活动详情</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="activity_detail_box">
        <img src="<?= $activity['big_img']; ?>" alt=""/>
        <div class="tips"><?= $activity['title'] ?></div>
    </div>
    <div class="activity_detail_bottomdes">
        <div class="desc">
            <span class="title">美约独家</span>
        </div>
        <pre class="bottom_des color_y"><i class="l_sprit iconfont">&#xe64d;</i> <?= $activity['description'] ?> <i
                class="r_sprit iconfont">&#xe64d;</i></pre>
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

<?php if ($actstatus == 3): ?>
    <a class="identify_footer_potion">报名结束</a>
<?php elseif ($actstatus == 1): ?>
    <div class="bottomblock">
        <div class="flex flex_end">
            <span class="total"><span
                    class="color_y"><i><?= ($user['gender'] == 1) ? $activity['male_price'] : $activity['female_price']; ?> </i>美币/人</span></span>
            <a onclick="topay();" class="nowpay">我要报名</a>
        </div>
    </div>
<?php elseif ($actstatus == 4): ?>
    <a class="identify_footer_potion">您已报名,审核中</a>
<?php elseif ($actstatus == 5): ?>
    <a class="identify_footer_potion">您已报名,审核不通过</a>
<?php elseif (($actstatus == 6) && ($user->gender == 2)): ?>
    <a class="identify_footer_potion">您已报名</a>
<?php else: ?>
    <a onclick="topay();" class="identify_footer_potion">我要报名</a>
<?php endif; ?>


<script>
    function topay() {
        $.util.checkLogin('/activity/pay-view/<?= $activity['id']; ?>');
    }

    LEMON.sys.setTopRight('分享');
    window.onTopRight = function () {
        shareBanner();
    };
    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/activity/view/'.$activity['id']; ?><?= isset($user)?'?ivc='.$user->invit_code:'';?>';
        window.shareConfig.title = '<?= $activity['title'] ?>';
        window.shareConfig.imgUrl = '<?= getHost().$activity['big_img']; ?>';
        var share_desc = '<?= isset($activity['share_desc'])?$activity['share_desc']:''; ?>';
        share_desc && (window.shareConfig.desc = share_desc);
        LEMON.show.shareBanner();
    }
    $.util.checkShare();
</script>