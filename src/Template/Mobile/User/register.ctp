<div class="loginwraper"></div>
<div class="wraper loginpage">
    <div class="logo"><img src="/mobile/images/logo.png"/></div>
    <div class="loginbox">
        <div class="username">
            <i class="iconfont">&#xe608;</i>
            <input tabindex="1" type="number" id="phone" value="" placeholder="手机号" id="user" />
        </div>
        <div class="password validate flex">
            <i class="iconfont">&#xe607;</i>
            <input tabindex="2" type="text" id="vcode" placeholder="验证码" class="valicode" id="validate" />
            <a  id="gcode" class="fogetpwd getvalid disabled">获取验证码</a>
        </div>
        <div class="password">
            <i class="iconfont">&#xe606;</i>
            <input tabindex="3" type="password" id="pwd" placeholder="6-16位的密码" class="user" id="password" />
        </div>
        <a id="submit"  class="btn btn_bg_y mt160 disabled">注册</a>
        <h4 class="getlogin"><a href="/user/login">已有账号，直接登录</a></h4>
    </div>
    <div class="register_bottom_tips">
        <a href="#this">注册表明已阅读并接受“用户服务协议”</a>
    </div>
</div>
<?= $this->start('script') ?>
<script>
    $('#gcode').on('tap', function () {
        var obj = $(this);
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();
        $.post('/user/sendVCode/1', {phone: phone}, function (res) {
            if (res.status === true) {
                obj.addClass('disabled');
                var text = '<span id="timer">' + 30 + '</span>秒后重新发送';
                obj.html(text);
                t1 = setInterval(function () {
                    var timer = $('#timer').text();
                    timer--;
                    if (timer < 1) {
                        obj.html('获取验证码');
                        obj.removeClass('disabled');
                        clearInterval(t1);
                    } else {
                        $('#timer').text(timer);
                    }
                }, 1000);
            } else {
               if(res.code=='201'){
                   $.util.alert(res.msg);
                   setTimeout(function(){
                       $.util.lmlogin();
                   },1000);
               }
               
            }
        }, 'json');
    });
    $('#phone').on('keyup', function () {
        var obj = $(this);
        var phone = obj.val();
        var gcode = $('#gcode');
        if ($.util.isMobile(phone)) {
            gcode.removeClass('disabled');
        } else {
            if (!gcode.hasClass('disabled')) {
                gcode.addClass('disabled');
            }
        }
    });
    $('#phone,#pwd,#vcode').on('keyup', function () {
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var pwd = $('#pwd').val();
        var submit = $('#submit');
        if ($.util.isMobile(phone) && vcode && pwd) {
            submit.removeClass('disabled');
        } else {
            if (!submit.hasClass('disabled')) {
                submit.addClass('disabled');
            }
        }
    });
    $('#submit').on('tap', function () {
        var obj = $(this);
        console.log(obj);
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var pwd = $('#pwd').val();
        console.log('11');
        if (phone && vcode && pwd) {
            $.post('', {phone: phone, vcode: vcode, pwd: pwd}, function (res) {
                //$.util.alert(res.msg);
                if (res.status) {
                    obj.addClass('disabled');
                    $.util.setCookie('token_uin',res.user.token);
                    LEMON.db.set('gender',res.user.gender);
                    LEMON.db.set('token_uin',res.user.token);
                    LEMON.db.set('im_accid',res.user.imaccid);
                    LEMON.db.set('im_token',res.user.imtoken);
                    setTimeout(function () {
                        window.location.href = res.url;
                    }, 1000);
                } else {
                    obj.removeClass('disabled');
                }
            }, 'json');
        }
    });
</script>
<?=
$this->end('script')?>