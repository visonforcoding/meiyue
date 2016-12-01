<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>消息</h1>
        <span class="r_btn">忽略全部</span>
    </div>
</header>
<div class="wraper">
    <ul class="chatBox">
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">邀请注册</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">我的访客</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">平台消息</div>
                <div class="tips-box"><span class="tips"></span><i class="iconfont rcon">&#xe605;</i></div>
            </a>
        </li>
    </ul>
    <ul class="chatBox mt40">
        <li>
            <a href="chat_detail.html" class="ablock flex flex_justify">
                <div class="chat-left-info flex">
                    <div class="avatar">
                        <img src="../images/avatar.jpg"/>
                    </div>
                    <div class="chat-text">
                        <h3 class="name">范美美</h3>
                        <span class="last-info line1">今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗？</span>
                    </div>
                </div>
                <time class="smalldes">16/06/03 18:00</time>
            </a>
        </li>
        <li>
            <a href="chat_detail.html" class="ablock flex flex_justify">
                <div class="chat-left-info flex">
                    <div class="avatar">
                        <img src="../images/avatar.jpg"/>
                    </div>
                    <div class="chat-text">
                        <h3 class="name">范美美</h3>
                        <span class="last-info line1">今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗？</span>
                    </div>
                </div>
                <time class="smalldes">18:00</time>
            </a>
        </li>
        <li>
            <a href="chat_detail.html" class="ablock flex flex_justify">
                <div class="chat-left-info flex">
                    <div class="avatar">
                        <img src="../images/avatar.jpg"/>
                    </div>
                    <div class="chat-text">
                        <h3 class="name">范美美</h3>
                        <span class="last-info line1">今晚有空吗？</span>
                    </div>
                </div>
                <time class="smalldes">18:00</time>
            </a>
        </li>
    </ul>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'chat']) ?>
<div class="shadow fullwraper flex box_bottom">
    <div class="login-tips">
        <h3 class="slogin">美约，生活更美好每一天每一天！</h3>
        <a href="#this" class="jumpbtn">
            登录/注册
        </a>
    </div>
</div>
<script type="text/javascript">
    $('html,body').css({'height': '100%', 'overflow': 'hidden'})
</script>