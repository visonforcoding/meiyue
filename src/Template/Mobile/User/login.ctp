<div class="loginwraper"></div>
<div class="wraper loginpage">
    <div class="logo"><img src="/mobile/images/logo.png"/></div>
    <div class="loginbox">
        <div class="username">
            <i class="iconfont">&#xe608;</i>
            <input type="number" id="phone" value="" placeholder="手机号"  />
        </div>
        <div class="password">
            <i class="iconfont">&#xe606;</i>
            <input type="password" id="pwd" placeholder="密码" class="user"  />
            <a href="#this" class="fogetpwd">忘记密码?</a>
        </div>
        <a id="submit" class="btn btn_bg_y mt160 disabled">登录</a>
        <a href="/user/register" class="btn btn_bg_t mt40">注册</a>
    </div>
    <div class="outerlogin">
        <a href="#this">游客身份浏览进入</a>
    </div>
</div>
<?=$this->start('script');?>
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
<?=$this->end('script');?>