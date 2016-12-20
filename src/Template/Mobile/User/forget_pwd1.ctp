<header>
    <div class="header">
        <i class="iconfont toback" onclick="window.location.href='/user/login'">&#xe602;</i>
        <h1><?= $pageTitle;?></h1>
    </div>
</header>
<div class="wraper fullwraper bgff">
    <div class="nav-banner"></div>
    <div class="foget-pwd-box">
        <div class="items">
            <div class="flex items-box">
                <span class="prenum">+86</span><input type="number" id="phone" type="text" placeholder="请输入手机号" value=""/>
            </div>
        </div>
        <div class="items">
            <div class="flex  flex_justify items-box">
                <input id="vcode" type="text" placeholder="请输入验证码" class="valinum" />
                <span id="gcode" class="getvolid disabled">获取验证码</span>
            </div>
        </div>
        <a id='submit' class="btn btn_bg_active mt60 disabled">下一步</a>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#gcode').on('tap', function () {
        var obj = $(this);
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();
        $.post('/user/sendVCode', {phone: phone}, function (res) {
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
                $.util.alert(res.msg);
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

    $('#phone,#vcode').on('keyup', function () {
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        var submit = $('#submit');
        if ($.util.isMobile(phone) && vcode) {
            submit.removeClass('disabled');
        } else {
            if (!submit.hasClass('disabled')) {
                submit.addClass('disabled');
            }
        }
    });

    $('#submit').on('tap', function () {
        var obj = $(this);
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();
        var vcode = $('#vcode').val();
        $.util.showPreloader();
        if (phone && vcode) {
            $.util.showPreloader();
            $.post('', {phone: phone, vcode: vcode}, function (res) {
                $.util.hidePreloader();
                if (res.status) {
                    setTimeout(function () {
                        window.location.href = res.url;
                    }, 1000);
                } else {
                    $.util.alert(res.msg);
                    obj.removeClass('disabled');
                }
            }, 'json');
        }
    });

    LEMON.sys.back('/user/login');
</script>
<?php $this->end('script'); ?>