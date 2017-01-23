<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>礼物</h1>
        <!--<span class="r_btn">赠送</span>-->
    </div>
</header> -->
<div class="wraper">
    <div class="judge_container allgift_container">
        <div class="avatar">
            <img src="<?= generateImgUrl($user->avatar); ?>"/>
        </div>
        <h3 class="date_title"><?= $user->nick  ; ?></h3>
    </div>
    <?php $count = ceil(count($gifts)/6);?>
    <div class="allgift">
        <ul class="inner" id="imgBox">
            <?php for($i=0; $i < $count; $i++): ?>
                <li>
                    <?php for($j=$i*6; $j < $i*6 + 6; $j++): ?>
                        <?php if(isset($gifts[$j])): ?>
                        <div class="items"
                             data-id="<?= $gifts[$j]['id']; ?>"
                             data-name="<?= $gifts[$j]['name']; ?>"
                             data-price="<?= $gifts[$j]['price']; ?>">

                            <div class="gift_pic">
                                <img src="<?= generateImgUrl($gifts[$j]['pic']); ?>"/>
                            </div>
                            <div class="bottomtext">
                                <i><?= $gifts[$j]['price']; ?></i>
                                <span class="ico">
                                    <img src="/mobile/images/cash.png" alt="" />
                                </span>
                            </div>
                        </div>
                        <?php else: break;?>
                        <?php endif; ?>
                    <?php endfor; ?>
                </li>
            <?php endfor; ?>
        </ul>
        <div class="yd" id="imgTab">
            <?php for($i=0; $i<$count; $i++): ?>
                <?php if($i==0): ?>
                    <span class="cur"></span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</div>

<script>
    var loop = $.util.loopImg(
        $('#imgBox'),
        $('#imgBox li'),
        $('#imgTab span'),
        $('.allgift')
    );

    $('.items').on('click', function() {

        var usermoney = 0;
        usermoney = <?= $me->money; ?>;
        var giftname = $(this).data('name');
        var giftprice = $(this).data('price');
        var giftid = $(this).data('id');
        if(parseFloat(giftprice) > usermoney) {
            $.util.alert('您的余额不足~~');
            return;
        }

        $.util.confirm(
            '赠送礼物',
            '赠送一件【' + giftname + '】给 <?= $user->nick;?>',
            function() {
                $.ajax({
                    url: '/gift/send/<?= $user->id; ?>/' + giftid,
                    type: "POST",
                    dataType: "json",
                    success: function (res) {
                        $.util.alert(res.msg);
                        history.back();
                    }
                })
            },
            null
        );
    })
</script>