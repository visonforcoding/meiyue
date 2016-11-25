<?php $this->start('script'); ?>
<script type="text/javascript">
    //$.util.showPreloader('前往登录..');
    if (!$.util.isAPP) {
        window.location.href = '/user/login';
    } else {
        LEMON.event.login(function (res) {
            res = JSON.parse(res);
            $.util.setCookie('token_uin', res.token_uin, 99999999);
            LEMON.db.set('token_uin', res.token_uin);
            window.location.reload();
        });
    }
</script>
<?php $this->end('script'); ?>
