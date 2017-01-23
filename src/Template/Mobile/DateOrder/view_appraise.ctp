<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>发表评价</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="judge_container">
        <div class="avatar">
            <img src="<?= generateImgUrl($order->dater->avatar) ?>"/>
        </div>
        <h3 class="date_title">[<?= $order->user_skill->skill->name ?>] <?= $order->dater->nick ?></h3>
        <ul class="jude_list" id="judeBox">
            <li data-score="<?= $order->appraise_time ?>" id="ontime">
                <span>准时赴约</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="<?= $order->appraise_match ?>" id="similar">
                <span>相符程度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="<?= $order->appraise_service ?>" id="attitude">
                <span>服务态度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    judge('ontime');
    judge('attitude');
    judge('similar');
    function judge(parent) {
        var parentNode = $('#' + parent);
        var liList = parentNode.children('i');
        var num = parentNode.data('score');
        liList.each(function (index) {
            for (var j = 0; j <= num-1; j++) {
                liList[j].style.color = '#eab96a';
            }
            for (var j = index + 1; j < liList.length; j++) {
                liList[j].style.color = '#999';
            }
        });
    }
</script>

