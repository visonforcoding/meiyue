<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>发表评价</h1>
    </div>
</header>
<div class="wraper">
    <div class="judge_container">
        <div class="avatar">
            <img src="<?= $order->dater->avatar ?>"/>
        </div>
        <h3 class="date_title">[<?= $order->user_skill->skill->name ?>] <?= $order->dater->nick ?></h3>
        <ul class="jude_list" id="judeBox">
            <li data-score="5" id="ontime">
                <span>准时赴约</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="5" id="similar">
                <span>相符程度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="5" id="attitude">
                <span>服务态度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    judge('ontime',<?=$order->appraise_time?>);
    judge('attitude',<?=$order->appraise_service?>);
    judge('similar',<?=$order->appraise_match?>);
    function judge(parent, num) {
        var parentNode = $('#' + parent);
        var liList = parentNode.find('i');
        liList.each(function (index) {
            $(this).on('tap', function () {
                for (var j = 0; j <= index; j++) {
                    $(liList[j]).addClass('color_y');
                }
                for (var j = index + 1; j < liList.length; j++) {
                    $(liList[j]).addClass('color_gray');
                }
                num = index + 1;
                console.log("您得了" + (num) + "颗星");
            })
            for (var j = num; j <= liList.length; j++) {
                $(liList[j]).addClass('color_gray');
            }
        })
    }
</script>
