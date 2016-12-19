<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>礼物</h1>
    </div>
</header>
<div class="wraper">
    <div class="judge_container allgift_container">
        <div class="avatar">
            <img src="<?= $user->avatar; ?>"/>
        </div>
        <h3 class="date_title"><?= $user->nick; ?></h3>
    </div>
</div>
<div class="allgift">
    <ul class="" id="allgift">
        <li>
            <div class="items active">
                <div class="gift_pic">
                    <img src="../images/gift01.png"/>
                </div>
                <div class="bottomtext"><i>5</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span></div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift04.png" style="width:100%"/>
                </div>
                <div class="bottomtext"><i>20</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift05.png"/>
                </div>
                <div class="bottomtext"><i>52</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift03.png"/>
                </div>
                <div class="bottomtext"><i>131.4</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift02.png"/>
                </div>
                <div class="bottomtext"><i>210</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift04.png" style="width:100%;"/>
                </div>
                <div class="bottomtext"><i>520</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift02.png"/>
                </div>
                <div class="bottomtext"><i>999</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
            </div>
            <div class="items">
                <div class="gift_pic">
                    <img src="../images/gift03.png"/>
                </div>
                <div class="bottomtext"><i>5000</i> <span class="ico"><img src="../images/cash01.png" alt=""/></span>
                </div>
                <span class="iconfont choose">&#xe64c;</span>
            </div>
        </li>
    </ul>
</div>
<a href="login_identify_jump.html" class="identify_footer_potion"><i class="iconfont">&#xe614;</i> 立即赠送</a>
<script type="text/javascript">
    $('#allgift .items').on('tap', function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
</script>