<div class="loginwraper"></div>
<div class="wraper loginpage">
    <div class="logo"><img src="/mobile/images/logo.png"/></div>
    <div class="loginbox">
        <div class="username">
            <i class="iconfont">&#xe608;</i>
            <input type="number" id="phone" value="" placeholder="手机号" autofocus='autofocus'  />
        </div>
        <div class="password">
            <i class="iconfont">&#xe606;</i>
            <input type="password" id="pwd" placeholder="密码" class="user"  />
            <a href="/user/forget-pwd1" class="fogetpwd">忘记密码?</a>
        </div>
    </div>
    <div class="login_box_btn">
        <a id="submit" class="btn btn_bg_y disabled mt160">登录</a>
        <div class="login_group mt40">
            <a href="/user/register?gender=1" class="btn btn_bg_t ">注册男</a>
            <a href="/user/register?gender=2" class="btn btn_bg_t">注册女</a>
        </div>
        <!--<a href="regiser.html" class="btn btn_bg_t mt40">注册</a>-->
    </div>
    <div class="outerlogin">
        <a href="/index/index">游客身份浏览进入</a>
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    wx.config(<?= json_encode($wxConfig) ?>);
    $('#phone,#pwd').on('keyup', function () {
        var phone = $('#phone').val();
        var pwd = $('#pwd').val();
        if ($.util.isMobile(phone) && pwd) {
            $('#submit').removeClass('disabled');
        } else {
            $('#submit').addClass('disabled');
        }
    });
    $('#submit').on('tap', function () {
        var phone = $('#phone').val();
        var pwd = $('#pwd').val();
        if ($(this).hasClass('disabled')) {
            return false;
        }
        if (phone && pwd) {
            $.post('', {phone: phone, pwd: pwd}, function (res) {
                if (res.status) {
                    $.util.showPreloader();
                    $.util.setCookie('token_uin',res.user.user_token);
                    LEMON.db.set('gender',res.user.gender);
                    LEMON.db.set('token_uin',res.user.user_token);
                    LEMON.db.set('im_accid',res.user.imaccid);
                    LEMON.db.set('im_token',res.user.imtoken);
                    LEMON.db.set('avatar',res.user.avatar);
                    setTimeout(function () {
                        window.location.href = res.redirect_url;
                    }, 1000);
                } else {
                    $.util.alert(res.msg);
                }
            }, 'json');
        }
    });
</script>
<?= $this->end('script'); ?>