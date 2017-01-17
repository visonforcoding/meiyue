<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>账户充值</h1>
    </div>
</header> -->
<div class="wraper">
    <!-- <h3 class="rich_header"></h3> -->
    <div class="charge_container_list mt20">
        <div class="flex flex_justify inner">
            <h1 class="commontitle">请输入购买数量</h1>
            <h1 class="color_y">1元 = 1美币</h1>
        </div>
        <div class="con inner flex flex_end">
            <input id="mb" type="tel" placeholder="点击输入"/>
        </div>
    </div>
    <div class='mt20 charge_container_con'>
        <h3 class="title">快捷充值</h3>
        <ul class='flex flex_justify charge-package' id='package'>
            <li class='items flex flex_center' onclick="quickPay(100);">
                <div>
                    <h3 class='color_friends'>
                        <span class='lagernum'>100</span><i class='unit'>美币</i>
                    </h3>
                    <div class='color_y aligncenter price'>￥100</div>
                </div>
            </li>
             <li class='items flex flex_center' onclick="quickPay(200);">
                <div>
                    <h3 class='color_friends'>
                        <span class='lagernum'>200</span><i class='unit'>美币</i>
                    </h3>
                    <div class='color_y aligncenter price'>￥200</div>
                </div>
            </li>
             <li class='items flex flex_center' onclick="quickPay(500);">
                <div>
                    <h3 class='color_friends'>
                        <span class='lagernum'>500</span><i class='unit'>美币</i>
                    </h3>
                    <div class='color_y aligncenter price'>￥500</div>
                </div>
            </li>
             <li class='items flex flex_center' onclick="quickPay(1000);">
                <div>
                    <h3 class='color_friends'>
                        <span class='lagernum'>1000</span><i class='unit'>美币</i>
                    </h3>
                    <div class='color_y aligncenter price'>￥1000</div>
                </div>
            </li>
        </ul>
    </div>
    <div class="charge_container_con  mt20">
        <h3 class="title">快捷充值送特权</h3>
        <ul id="changed">
            <?php foreach ($packs as $item): ?>
                <li>
                    <div class="items flex flex_justify inner">
                        <h3 class="bright color_friends" onclick="payView(<?= $item->id; ?>)"><span class="lagernum"><?= $item->title; ?></span> <i
                                class="unit"><?= $item->vali_time; ?>天&nbsp;</i></h3>
                        <div class="smalldes closed" data-type="0"><i class="iconfont color_y">&#xe62f;</i> <i
                                class="slide-btn-name">点击展开详情</i></div>
                        <div class="color_y" onclick="payView(<?= $item->id; ?>)"><i class="smalldes">￥</i> <span
                                class="lagernum"><?= $item->price; ?></span><i class="iconfont rco">&#xe605;</i>  </div>
                    </div>
                    <div class="content hidecon inner">
                        <div class="innerblock">
                            <h1>享受的特权 <i class="color_friends"><?= $item->vali_time; ?>天&nbsp;</i></h1>
                            <p><i class="iconfont color_y">&#xe654;</i> 查看
                                <?= checkIsEndless($item->browse_num) ? '无限' : $item->browse_num; ?>
                                个美女所发布的全部动态</p>
                            <p><i class="iconfont color_y">
                                    &#xe654;</i>和<?= checkIsEndless($item->chat_num) ? '无限' : $item->chat_num; ?>个美女聊天
                            </p>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div style="height:62px;"></div>
<a id="topay" class="identify_footer_potion">立即支付</a>
<script type="text/javascript">
    $('#changed .closed').on('tap', function () {
        var data = $(this).data('type');
        var ele = $(this).parent('.items').siblings();
        switch (data) {
            case '0':
                ele.removeClass('hidecon').addClass('showcon');
                $(this).attr('data-type', '1');
                $(this).find('.slide-btn-name').text('点击关闭详情');
                break;
            case '1':
                ele.removeClass('showcon').addClass('hidecon');
                $(this).attr('data-type', '0');
                $(this).find('.slide-btn-name').text('点击展开详情');
                break;
            default:
                break;
        }
    })
    $('#package li').on('tap',function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
</script>
<?php $this->start('script'); ?>
<script type="text/javascript">
     $('#topay').on('tap',function(){
         var mb = $('#mb').val();
         if(mb > 100000){
             $.util.alert('单笔充值不可超过10万');
             return false;
         }
         $.util.ajax({
            url:'/purse/create-payorder<?= isset($redurl)?"?redurl=".$redurl:""; ?>',
            data:{mb:mb},
            func:function(res){
                if(res.status){
                    document.location.href = res.redirect_url;
                }
            }
        });
    });


     function quickPay(num) {
         $.util.ajax({
             url:'/purse/create-payorder<?= isset($redurl)?"?redurl=".$redurl:""; ?>',
             data:{mb:num},
             func:function(res){
                 if(res.status){
                     document.location.href = res.redirect_url;
                 }
             }
         });
     };


    //支付
    function payView($packid) {
        $.util.showPreloader();
        $.ajax({
            type: 'POST',
            url: '/userc/create-payorder/' + $packid + '<?= isset($redurl) ? "?redurl=" . $redurl : ""; ?>',
            dataType: 'json',
            success: function (res) {
                $.util.hidePreloader();
                if (typeof res === 'object') {
                    if (res.status) {
                        document.location.href = res.redirect_url;
                    } else {
                        alert(res.msg);
                    }
                }
            }
        });
    }
</script>
<?php $this->end('script'); ?>
