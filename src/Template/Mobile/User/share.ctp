<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>邀请注册有奖</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="share_sucess_tips">
        <a href="/user/share-list" class="ablock">已成功邀请的人<i class="iconfont fr">&#xe605;</i></a>
    </div>
    <div class="share_items_list <?php if(isset($user) && $user->has_invs): ?>mt20<?php endif; ?>">
        <div class="inner">
            <h3 class="title">方式一：分享链接</h3>
            <p class="desc">好友点击你的链接并在15分钟内注册成功后，你将获得该好友赚取金额10%(女性好友）或充值金额15%（男性好友）的提成。</p>
            <a href="javascript:shareBanner();" class="btn btn_t_border mt40">立即分享</a>
        </div>
    </div>
    <div class="share_items_list mt20 mb60">
        <div class="inner">
            <h3 class="title">方式二：邀请码</h3>
            <p class="desc">好友在注册时，输入你的邀请码，你将获得该好友赚取金额10%（女性好友）或者充值金额15%（男性好友）的提成。</p>
            <span class="share_desc">您的邀请码<br /><strong><?= isset($user)?$user->invit_code:'--'; ?></strong></span>
            <!--<a href="javascript:void(0);" class="btn btn_t_border mt20">生成我的海报</a>-->
        </div>
    </div>
</div>
<div class="tocode" style="display: none;">
    <div class="flex flex_center fullwraper">
        <div class="codebox">
            <div class="username flex">
                <div class="avatar"><img src="../images/codepic.png"/></div>
                <div class="usertext">
                    <h3>范冰冰</h3>
                    <span class="color_y"><i class="iconfont">&#xe61d;</i> 23</span>
                </div>
            </div>
            <div class="code-con">
                <img src="../images/wxcode.png"/>
            </div>
            <div class="code-bottom">
                <h3>美 约</h3>
                <span>一个专注于高端人士的交友平台</span>
            </div>
        </div>
    </div>
</div>

<script>
    function shareBanner() {
        window.shareConfig.link = '<?= getHost().'/user/login'; ?><?= isset($user)?'?ivc='.$user->invit_code:'';?>';
        window.shareConfig.title = '我刚注册成为【美约APP】用户，你也一起来加入吧！';
        window.shareConfig.desc = '美约APP，全网实名信息认证，同城真实高端社交新选择！';
        LEMON.show.shareBanner();
    }
</script>