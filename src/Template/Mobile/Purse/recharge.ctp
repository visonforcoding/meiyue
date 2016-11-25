<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>账户充值</h1>
    </div>
</header>
<div class="wraper">
    <h3 class="rich_header"></h3>
    <div class="charge_container_list mt20">
        <div class="flex flex_justify inner">
            <h1 class="commontitle">请输入购买数量</h1>
            <h1 class="color_y">1元 = 1美币</h1>
        </div>
        <div class="con inner flex flex_end">
            <input id="mb" type="number" placeholder="点击输入" />
        </div>
    </div>
    <div class="charge_container_con  mt20">
        <h3 class="title">快捷充值送特权套餐</h3>
        <ul id="changed">
            <li>
                <div class="items flex flex_justify inner">
                    <h3 class="bright color_friends"><span class="lagernum">3999</span> <i class="unit">美币</i></h3>
                    <div class="smalldes closed" data-type = "0"><i class="iconfont color_y">&#xe62f;</i> 点击关闭详情</div>
                    <div class="color_y"><i class="smalldes">￥</i> <span class="lagernum">3999</span> </div>
                </div>
                <div class="content hidecon inner">
                    <div class="innerblock">
                        <h1>享受的特权  <i class="color_friends">1个月</i></h1>
                        <p><i class="iconfont color_y">&#xe654;</i>查看30个美女所发布的全部动态</p>
                        <p><i class="iconfont color_y">&#xe654;</i>和1个美女聊天</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="items flex flex_justify inner">
                    <h3 class="bright color_friends"><span class="lagernum">3999</span> <i class="unit">美币</i></h3>
                    <div class="smalldes closed" data-type = "0"><i class="iconfont color_y">&#xe62f;</i> 点击关闭详情</div>
                    <div class="color_y"><i class="smalldes">￥</i> <span class="lagernum">3999</span> </div>
                </div>
                <div class="content hidecon inner">
                    <div class="innerblock">
                        <h1>享受的特权  <i class="color_friends">1个月</i></h1>
                        <p><i class="iconfont color_y">&#xe654;</i>查看30个美女所发布的全部动态</p>
                        <p><i class="iconfont color_y">&#xe654;</i>和1个美女聊天</p>
                    </div>
                </div>
            </li>
            <li>
                <div class="items flex flex_justify inner">
                    <h3 class="bright color_friends"><span class="lagernum">3999</span> <i class="unit">美币</i></h3>
                    <div class="smalldes closed" data-type = "0"><i class="iconfont color_y">&#xe62f;</i> 点击关闭详情</div>
                    <div class="color_y"><i class="smalldes">￥</i> <span class="lagernum">3999</span> </div>
                </div>
                <div class="content hidecon inner">
                    <div class="innerblock">
                        <h1>享受的特权  <i class="color_friends">1个月</i></h1>
                        <p><i class="iconfont color_y">&#xe654;</i>查看30个美女所发布的全部动态</p>
                        <p><i class="iconfont color_y">&#xe654;</i>和1个美女聊天</p>
                    </div>
                </div>
            </li>
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
                break;
            case '1':
                ele.removeClass('showcon').addClass('hidecon');
                $(this).attr('data-type', '0');
                break;
            default:
                break;
        }
    })
</script>
<?php $this->start('script'); ?>
<script type="text/javascript">
     $('#topay').on('tap',function(res){
         var mb = $('#mb').val();
         $.util.ajax({
            url:'/purse/create-payorder',
            data:{mb:mb},
            func:function(res){
                if(res.status){
                    document.location.href = res.redirect_url;
                }
            }
         });
     });
</script>
<?php $this->end('script'); ?>
