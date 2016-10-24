<header class="bar bar-nav">
    <h1 class='title'>注册</h1>
</header>
<div class="content">
    <div class="list-block">
        <ul>
            <!-- Text inputs -->
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-name"></i></div>
                    <div class="item-inner">
                        <div class="item-title label">手机号</div>
                        <div class="item-input">
                            <input id="phone" name="phone" type="text" placeholder="手机号">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-email"></i></div>
                    <div class="item-inner">
                        <div class="item-title label">验证码</div>
                        <div class="item-input col-70">
                            <input id="vcode" name="vcode" type="email" placeholder="验证码">
                        </div>
                        <div class="col-30"><a id="gcode" class="button disabled">获取验证码</a></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-media"><i class="icon icon-form-password"></i></div>
                    <div class="item-inner">
                        <div class="item-title label">密码</div>
                        <div class="item-input">
                            <input id="pwd" name="pwd" type="password" placeholder="Password" class="">
                        </div>
                    </div>
                </div>
            </li>
    </div>
    <div class="content-block">
        <div class="row">
            <div class="col-100"><a id="submit" href="#" class="button button-big button-fill button-success">提交</a></div>
        </div>
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
                $.toast(res.msg);
                var text = '<i id="timer">' + 30 + '</i>秒后重新发送';
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
                $.toast(res.msg);
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
    $('#submit').on('tap',function(){
       var obj = $(this);
       if(obj.hasClass('disabled')){
           return false;
       }
       var phone = $('#phone').val(); 
       var vcode = $('#vcode').val(); 
       var pwd = $('#pwd').val();
       if(phone&&vcode&&pwd){
           $.post('/user/register',{phone:phone,vcode:vcode,pwd:pwd},function(res){
               $.toast(res.msg);
               if(res.status){
                   obj.addClass('disabled');
                   setTimeout(function(){
                       window.location.href=res.url;
                   },1000);
               }else{
                   obj.removeClass('disabled');
               }
           },'json');
       }
    });
</script>
<?php $this->end('script'); ?>