<div>
    <div class="homepage">
        <!--  <div class="header">
             <h1>我的</h1>
             <i class="iconfont install">&#xe661;</i>
         </div> -->
        <div class="home_cover_info">
					<span class="avatar">
						<img src="<?= createImg($user->avatar) . '?w=150' ?>" class="avatar-pic"/>
						<div class="vip"><img src="/mobile/images/vip.png" class="responseimg"/></div>
					</span>
            <div class="cover_left_info">
                <ul class="">
                    <li class="bbottom userinfo" onclick="window.location.href='/userc/edit-info'">
                        <a href="#this" class="cover_block">
                            <h3>
                                <span><?= $user->nick ?>
                                    <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
                                </span>
                                <div class="bottom-btn">
                                    <?php if($user->id_status == UserStatus::PASS): ?>
                                    <span class="identify-info id-btn">身份已认证</span>
                                    <?php else: ?>
                                    <span class="identify-info id-btn">身份未认证</span>
                                    <?php endif; ?>
                                    <!--<span class="identify-info video-btn">视频已认证</span>-->
                                </div>
                            </h3>
									<span class="cover_r_ico">
										<i class="iconfont">&#xe605;</i>
									</span>
                        </a>
                    </li>
                    <li class="follow">
                        <a class="like" onclick="window.location.href='/userc/fans'">喜欢 <i><?= $focount; ?></i></a>
                        <a class="like" onclick="window.location.href='/userc/follows'">粉丝 <i><?= $facount; ?></i></a>
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
                <a href="/userc/my-purse"  class="home_items">
                    <div class="home_list_l_info flex">
                        <i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span>
                    </div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png" alt="" /><?= $this->Number->format($user->money) ?></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/dateorder"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60a;</i><span class="itemsname">订单管理</span></div>
                    <div class="home_list_r_info">
                       <!-- <span class="tips"></span>-->
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-activitys"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60b;</i><span class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/user/voted"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60c;</i><span class="itemsname">我的评选</span></div>
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
                <a href="/userc/user-skills-index"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60d;</i><span class="itemsname">我的技能</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li id="my-dates-btn">
                <a href="/date/index"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60f;</i><span class="itemsname">我发起的约会</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-tracle"  class="home_items">
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
            <li>
                <a href="/userc/install"  class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe612;</i><span class="itemsname">设置</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'me']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    //$.util.showPreloader('前往登录..');
    window.onActiveView = function () {
        if (!$.util.getCookie('token_uin')) {
//            alert('我又没登陆');
//            LEMON.event.login(function (res) {
//                res = JSON.parse(res);
//                $.util.setCookie('token_uin', res.token_uin, 99999999);
//                LEMON.db.set('token_uin', res.token_uin);
//                window.location.reload();
//            });
        }
    }
</script>
<?php $this->end('script'); ?>