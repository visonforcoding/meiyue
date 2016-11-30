<?php $this->start('script'); ?>
<script type="text/javascript">
    //$.util.showPreloader('前往登录..');
    if (!$.util.isAPP) {
        window.location.href = '/user/login';
    } else {
        alert('我没登陆');
        LEMON.event.login(function (res) {
            alert(res);
            res = JSON.parse(res);
            //$.util.setCookie('token_uin', res.token_uin, 99999999);
            //LEMON.db.set('token_uin', res.token_uin);
            LEMON.db.set('im_token', res.user.imtoken);
            LEMON.db.set('im_accid', 'meiyue_'+res.user.id);
            window.location.reload();
        });
    }
</script>
<?php $this->end('script'); ?>
