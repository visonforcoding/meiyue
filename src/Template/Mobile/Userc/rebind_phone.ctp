<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1><?= $pageTitle;?></h1>
    </div>
</header>
<div class="wraper fullpage bgff">
    <div class="nav-banner iphone-banner"></div>
    <div class="foget-pwd-box">
        <div class="items">
            <div class="flex items-box">
                <span class="prenum">+86</span><input type="number" id="phone" type="text" placeholder="请输入手机号" />
            </div>
        </div>
        <div class="items">
            <div class="flex  flex_justify items-box">
                <input id="vcode" type="text" placeholder="请输入验证码" class="valinum" />
                <span id="gcode" class="getvolid disabled">获取验证码</span>
            </div>
        </div>
        <a id='submit' class="btn btn_bg_active mt60 disabled">确定</a>
    </div>
    <p class="resetnum">重绑手机号后，注意要使用新手机号登录。</p>
</div>

<?php $this->start('script'); ?>
<script>
    $('#gcode').on('tap', function () {
        var obj = $(this);
        if (obj.hasClass('disabled')) {
            return false;
        }
        var phone = $('#phone').val();

        $.post('/user/sendVCode/2', {phone: phone}, function (res) {
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
        console.log(phone + "|" + vcode);
        if (phone && vcode) {
            $.post('', {nphone: phone, vcode: vcode}, function (res) {
                if (res.status) {
                    $.util.alert('绑定成功，请重新登录');
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
</script>
<?php $this->end('script'); ?>