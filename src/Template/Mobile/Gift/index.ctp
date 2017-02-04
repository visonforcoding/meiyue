<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>礼物</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="judge_container allgift_container">
        <div class="avatar">
            <img src="<?= generateImgUrl($user->avatar); ?>"/>
        </div>
        <h3 class="date_title"><?= $user->nick; ?></h3>
    </div>
</div>
<div class="allgift">
    <ul class="" id="allgift">
        <li>
            <?php foreach($gifts as $gift): ?>
                <div class="items" data-id="<?= $gift->id; ?>" data-name="<?= $gift->name; ?>" data-cost="<?= $gift->price; ?>">
                    <div class="gift_pic">
                        <img src="<?= generateImgUrl($gift->pic); ?>"/>
                    </div>
                    <div class="bottomtext"><i><?= $gift->price; ?></i> <span class="ico"><img src="/mobile/images/cash01.png" alt=""/></span></div>
                    <span class="iconfont choose">&#xe64c;</span>
                </div>
            <?php endforeach; ?>
        </li>
    </ul>
</div>
<a id="sendto" class="identify_footer_potion"><i class="iconfont">&#xe614;</i> 立即赠送</a>
<script type="text/javascript">
    var gid = null;
    var gname = '';
    var gprice = 0;
    $('#allgift .items').on('tap', function () {
        $(this).addClass('active').siblings().removeClass('active');
        gid = $(this).data('id');
        gname = $(this).data('name');
        gprice = $(this).data('cost');
    })

    $('#sendto').on('tap', function() {
        if(!gid) {
            $.util.alert('请选择要送的礼物');
            return;
        }
        <?php if($isChecking): ?>
        $.util.confirm(
            '赠送礼物',
            '赠送【' + gname + '】将会消耗'+gprice+'积分',
            function() {
                $.util.showPreloader('请稍候');
                $.ajax({
                    url: '/gift/send/<?= $user->id; ?>/' + gid,
                    type: "POST",
                    dataType: "json",
                    success: function (res) {
                        $.util.hidePreloader();
                        $.util.alert(res.msg);
                        gid = null;
                        $('#allgift .items').removeClass('active');
                        if(res.status) {
                            setTimeout(function(){
                                LEMON.event.back();
                                //$.util.openTalk(res);
                            },500);
                        }
                    }
                })
            },
            null
        );
        <?php else: ?>
        $.util.confirm(
            '赠送礼物',
            '赠送一件【' + gname + '】给 <?= $user->nick;?>',
            function() {
                $.util.showPreloader('请稍候');
                $.ajax({
                    url: '/gift/send/<?= $user->id; ?>/' + gid,
                    type: "POST",
                    dataType: "json",
                    success: function (res) {
                        $.util.hidePreloader();
                        $.util.alert(res.msg);
                        gid = null;
                        $('#allgift .items').removeClass('active');
                        if(res.status) {
                            setTimeout(function(){
                                LEMON.event.back();
                                //$.util.openTalk(res);
                            },500);
                        }
                    }
                })
            },
            null
        );
        <?php endif; ?>
    });

</script>