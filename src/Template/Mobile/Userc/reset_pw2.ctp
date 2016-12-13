<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1><?= $pageTitle;?></h1>
    </div>
</header>
<div class="wraper fullwraper bgff">
    <div class="nav-banner"></div>
    <div class="foget-pwd-box">
        <div class="items">
            <div class="flex items-box">
                <input id="newpwd" type="password" placeholder="请输入新密码" />
            </div>
        </div>
        <div class="items">
            <div class="flex  flex_justify items-box">
                <input id="newpwd-again" type="password" placeholder="请再次输入新密码" />
            </div>
        </div>
        <a id="submit" class="btn btn_bg_active mt60 disabled">提交</a>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#newpwd,#newpwd-again').on('keyup', function () {
        var newpwd = $('#newpwd').val();
        var newpwd_again = $('#newpwd-again').val();
        var submit = $('#submit');
        if (newpwd && newpwd_again) {
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
        var newpwd = $('#newpwd').val();
        var newpwd_again = $('#newpwd-again').val();
        if(newpwd != newpwd_again) {
            $.util.alert('密码不一致');
            return;
        }
        if (newpwd && newpwd_again) {
            $.util.showPreloader();
            $.post('', {newpwd1: newpwd, newpwd2: newpwd_again}, function (res) {
                $.util.hidePreloader();
                if (res.status) {
                    $.util.alert(res.msg);
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