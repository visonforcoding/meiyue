<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>消息</h1>
        <span class="r_btn">忽略全部</span>
    </div>
</header> -->
<div class="wraper">
    <ul class="chatBox">
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">邀请注册</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">我的访客</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">平台消息</div>
                <div class="tips-box"><span class="tips"></span><i class="iconfont rcon">&#xe605;</i></div>
            </a>
        </li>
    </ul>
    <ul class="chatBox mt40">
    </ul>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'chat']) ?>
<div class="shadow fullwraper flex box_bottom">
    <div class="login-tips">
        <h3 class="slogin">美约，生活更美好每一天每一天！</h3>
        <a id="go-login" class="jumpbtn">
            登录/注册
        </a>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
    $('html,body').css({'height': '100%', 'overflow': 'hidden'})
    $('#go-login').on('tap',function(){
        if (!$.util.isAPP) {
            window.location.href = '/user/login';
        } else {
            LEMON.event.login(function (res) {
                res = JSON.parse(res);
//                $.util.setCookie('token_uin', res.token_uin, 99999999);
//                LEMON.db.set('token_uin', res.token_uin);
//                LEMON.db.set('im_token', res.user.imtoken);
//                LEMON.db.set('im_accid', 'meiyue_'+res.user.id);
                window.location.reload();
                
            });
        }
    })
</script>
<?php $this->end('script'); ?>