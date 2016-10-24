<header class="bar bar-nav">
    <h1 class='title'>登录</h1>
</header>
<div class="content">
    <div class="list-block">
        <ul>
            <!-- Text inputs -->
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-title label">手机号</div>
                        <div class="item-input">
                            <input id="phone" name="phone" type="number" placeholder="Your name">
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="item-content">
                    <div class="item-inner">
                        <div class="item-title label">密码</div>
                        <div class="item-input">
                            <input id="pwd" name="pwd" type="password" placeholder="E-mail">
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="content-block">
            <div class="row">
                <div class="col-50"><a href="/user/register" class="button button-big button-fill button-danger">注册</a></div>
                <div class="col-50"><a href="#" id="submit" class="button button-big button-fill button-success disabled">登录</a></div>
            </div>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
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
            $.post('/user/login', {phone: phone, pwd: pwd}, function (res) {
                if (res.status) {
                    $.showPreloader('登录中...')
                    setTimeout(function () {
                        window.location.href = res.redirect_url;
                    }, 1000);
                } else {
                    $.toast(res.msg);
                }
            }, 'json');
        }
    });
</script>
<?php $this->end('script'); ?>