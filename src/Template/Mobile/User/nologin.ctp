<div>
    <div class="homepage flex">
        <!--<div class="header">
            <h1>我的</h1>
            <i class="iconfont install">&#xe661;</i>
        </div>-->
        <div class="home_cover_info flex">
            <span class="avatar">
                <img src="/mobile/images/avatar.jpg" class="avatar-pic"/>
            </span>
            <div class="cover_left_info">
                <ul class="opci">
                    <li class="bbottom userinfo">
                        <a href="#this" class="cover_block">
                            <h3>
                                <span>未登录<i class="iconfont">&#xe628;</i></span>
                                <span class="flag"><img src="/mobile/images/zui.png" alt="" /></span>
                            </h3>
                            <span class="cover_r_ico">
                                <i class="iconfont">&#xe605;</i>
                            </span>
                        </a>
                    </li>
                    <li class="follow">
                        <a class="like">喜欢 <i>0</i></a>
                        <a class="like">粉丝 <i>0</i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="wraper">
    <div class="home_items_list mt40">
        <ul>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info flex"><i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span></div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png" alt="" />352</span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60a;</i><span class="itemsname">订单管理</span></div>
                    <div class="home_list_r_info">
                        <span class="tips"></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60b;</i><span class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60c;</i><span class="itemsname">评选管理</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="home_items_list mt40">
        <ul>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60d;</i><span class="itemsname">我的技能</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60f;</i><span class="itemsname">我发起的约会</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe610;</i><span class="itemsname">我的动态</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="home_items_list items_basic_list mt40">
        <ul>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe611;</i><span class="itemsname">联系客服</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe612;</i><span class="itemsname">分享</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="height:1.6rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'me']) ?>
<div class="shadow fullwraper flex box_bottom">
    <div class="login-tips">
        <h3 class="slogin">美约，高颜值社交圈</h3>
        <a id="go-login" class="jumpbtn">
            登录/注册
        </a>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
    $('html,body').css({'height': '100%', 'overflow': 'hidden'})
    $('#go-login').on('tap',function(){
        if (!$.util.isAPP) {
            window.location.href = '/user/login';
        } else {
            LEMON.event.login(function (res) {
                res = JSON.parse(res);
                $.util.setCookie('token_uin', res.token_uin, 99999999);
                //LEMON.db.set('token_uin', res.token_uin);
                //LEMON.db.set('im_token', res.user.imtoken);
                //LEMON.db.set('im_accid', 'meiyue_'+res.user.id);
                window.location.reload();
            });
        }
    })
</script>
<?php $this->end('script'); ?>
