<!--<header hidden>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>关于我们</h1>
    </div>
</header>-->
<div class="wraper">
    <div class="aboutus_container">
        <div class="logo">
            <img src="/mobile/images/logo.png"/>
        </div>
        <h3 class="brand">美约圈</h3>
        <h3 class="version smalldes">V1.0</h3>
        <h3 class="slogn">一个有趣的技能交友平台</h3>
    </div>
    <div class="mt350" style="text-align: center">
        <?php if($gender == 1): ?>
            <a href="/index/agreement-user"><i class='color_black'>用户服务协议</i></a>
        <?php else: ?>
            <a href="/index/agreement-artist"><i class='color_black'>艺人入驻协议</i></a>
        <?php endif; ?>
    </div>
</div>