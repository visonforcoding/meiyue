<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>账号管理</h1>
    </div>
</header>
<div class="wraper fullpage bgff">
    <div class="install_account_items">
        <div class="avatar">
            <i class="iconfont">&#xe608;</i>
        </div>
        <h3><?= $phone; ?><a href="/userc/rebind-phone" class="undertext color_y">重新绑定</a></h3>
    </div>
    <div class="restpwd inner">
        <a href="/userc/reset-pw1" class="btn btn_dark_t">修改密码</a>
    </div>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript">
    LEMON.sys.back('/user/install');
</script>
<?php $this->end('script'); ?>