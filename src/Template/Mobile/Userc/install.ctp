<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>设置</h1>
    </div>
</header>
<div class="wraper">
    <div class="account_items">
        <a class="commonlayer inner mt20 ablock" href="home_account.html">
            <div>账号管理</div>
            <span class="iconfont rcon">&#xe605;</span>
        </a>
    </div>

    <ul class="mt20 outerblock bgff inner">
        <li>
            <a class="commonlayer ablock" href="home_install_tips.html">
                <div>提醒设置</div>
                <span class="iconfont rcon">&#xe605;</span>
            </a>
        </li>
        <li>
            <a class="commonlayer ablock">
                <div>清除缓存</div>
                <div class="r_info">
                    <i class="smalldes">12.89M</i>
                    <span class="iconfont rcon">&#xe605;</span>
                </div>
            </a>
        </li>
    </ul>
    <ul class="mt20 outerblock bgff inner">
        <li>
            <a class="commonlayer ablock">
                <div>常见问题</div>
                <span class="iconfont rcon">&#xe605;</span>
            </a>
        </li>
        <li>
            <a class="commonlayer ablock">
                <div>意见反馈</div>
                <span class="iconfont rcon">&#xe605;</span>
            </a>
        </li>
        <li>
            <a class="commonlayer ablock">
                <div>关于我们</div>
                <span class="iconfont rcon">&#xe605;</span>
            </a>
        </li>
    </ul>
    <div class="inner mt60">
        <a id="loginout"  class="btn btn_dark_t">退出</a>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
    $('#loginout').on('tap',function(){
       $.util.ajax({
           url:'/userc/login-out',
           func:function(res){
               if(res.status){
                   $.util.setCookie('token_uin', '');
                   $.util.setCookie('login_status', '');
                   LEMON.db.set('token_uin', '');
                   location.href = res.redirect_url;
               }
           }
       }) ;
    });
</script>
<?php $this->end('script'); ?>