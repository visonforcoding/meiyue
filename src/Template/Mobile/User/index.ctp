<header>
    <div class="homepage">
       <!--  <div class="header">
            <h1>我的</h1>
            <i class="iconfont install">&#xe661;</i>
        </div> -->
        <div class="home_cover_info">
            <span class="avatar">
                <img src="<?=  createImg($user->avatar).'?w=77'?>"/>
            </span>
            <div class="cover_left_info">
                <ul>
                    <li class="bbottom userinfo">
                        <a href="#this" class="cover_block">
                            <h3>
                                <span><?=$user->nick?><i class="iconfont">&#xe628;</i></span>
                                <span class="flag"><img src="/mobile/images/zui.png" alt="" /></span>
                            </h3>
                            <span class="cover_r_ico">
                                <i class="iconfont" onclick="window.location.href='/userc/edit-info'">&#xe605;</i>
                            </span>
                        </a>
                    </li>
                    <li class="follow">
                        <a href="/userc/likes" class='like'>喜欢 <i>12</i></a>
                        <a href="/userc/fans" class='like'>粉丝 <i>122</i></a>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<div class="wraper">
    <div class="home_items_list mt40">
        <ul>
            <li>
                <a href="/userc/my-purse"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span></div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png" alt="" /><?=$this->Number->format($user->money)?></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/dateorder"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60a;</i><span class="itemsname">订单管理</span></div>
                    <div class="home_list_r_info">
                        <span class="tips"></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-activitys"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60b;</i><span class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/user/voted"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60c;</i><span class="itemsname">我的评选</span></div>
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
                    <div class="home_list_l_info"><i class="iconfont">&#xe60d;</i><span class="itemsname">我的技能</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li id="my-dates-btn">
                <a href="/date/index"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60f;</i><span class="itemsname">我发起的约会</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-tracle"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe610;</i><span class="itemsname">我的动态</span></div>
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
                    <div class="home_list_l_info"><i class="iconfont ico">&#xe611;</i><span class="itemsname">联系客服</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont ico">&#xe612;</i><span class="itemsname">分享</span></div>
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