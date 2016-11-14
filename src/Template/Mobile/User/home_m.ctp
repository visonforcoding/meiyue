<header>
    <div class="homepage mhomepage">
        <div class="header">
            <h1>我的</h1>
            <i class="iconfont install">&#xe661;</i>
        </div>
        <div class="home_cover_info">
            <span class="avatar">
                <img src="<?=  createImg($user->avatar).'?w=77'?>"/>
            </span>
            <div class="cover_left_info">
                <ul>
                    <li class="blight userinfo">
                        <a href="#this" class="cover_block">
                            <h3>
                                <span>帅哥帅哥<i class="iconfont">&#xe628;</i></span>
                                <span class="flag price">>10万金币</span>
                            </h3>
                            <span class="cover_r_ico">
                                <i class="iconfont">&#xe605;</i>
                            </span>
                        </a>
                    </li>
                    <li class="follow flex flex_justify">
                        <div>赞赏我 <i>12</i></div>
                        <div>关注 <i>122</i></div>
                        <div>访客 <i>122</i></div>
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
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span></div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png" alt="" /><?=$this->number->format($user->money)?></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/dateorder"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60a;</i><span class="itemsname">我的约单</span></div>
                    <div class="home_list_r_info">
                        <span class="color_y">3</span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe60b;</i><span class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <span class="color_y">3</span>
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
                    <div class="home_list_l_info"><i class="iconfont">&#xe658;</i><span class="itemsname">会员中心</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="#this"  class="home_items">
                    <div class="home_list_l_info"><i class="iconfont">&#xe657;</i><span class="itemsname">付费查看记录</span></div>
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
                    <div class="home_list_l_info"><i class="iconfont">&#xe659;</i><span class="itemsname">做任务赢特权</span></div>
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
<div style="height:1.6rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'me']) ?>