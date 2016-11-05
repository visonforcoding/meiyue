<header>
    <div class="home_page">
        <div class="header">
            <span class="l_btn iconfont">&#xe602;</span>
            <span class="r_btn iconfont">&#xe62d;</span>
        </div>
    </div>
</header>
<div class="wraper">
    <!--基本信息-->
    <div class="home_page_basic">
        <h3 class="aligncenter"><span class="home_name"><b><?=$user->nick?></b><em><i class="iconfont">&#xe623;</i><?=$distance?></em></span></h3>
        <div class="home_name_info aligncenter">
            <i class="iconfont color_y">&#xe61d;</i> <?=$age?> <i class="job"><?=$user->profession?></i> <i class="address"><?=$user->city?></i>
        </div>
        <div class="commend aligncenter">
            <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_gray">&#xe62a;</i>
            <span class="total">4.2分</span>
        </div>
        <ul class="otherinfo flex flex_justify bdbottom">
            <li><span class="t_desc"><?=$user->height?>cm</span><span class="b_desc">身高</span></li>
            <li><span class="t_desc"><?=$user->weight?>kg</span><span class="b_desc">体重</span></li>
            <li><span class="t_desc"><?=$user->bwh?></span><span class="b_desc">三围</span></li>
            <li><span class="t_desc"><?=$birthday?></span><span class="b_desc">生日</span></li>
        </ul>
    </div>
    <!--图片 && 视频展示-->
    <div class="home_pic_info mt40">
        <ul class="inner flex flex_justify">
            <?php foreach(unserialize($user->images) as $image): ?>
            <li><img src="<?=  createImg($image)?>"/></li>
            <?php endforeach; ?>
            <li><a href="#this" class='ablock'><img src="/mobile/images//avatar.jpg"/><span>更 多 私 房</span></a></li>
        </ul>
        <div class="inner home_video mt20">
            <img src="/mobile/images//vid.jpg"/>
        </div>
    </div>
    <!--Ta的资料-->
    <div class="home_basic_mark mt40">
        <div class="inner">
            <div class="title">
                <h3>Ta的资料</h3>
            </div>
            <div class="con">
                <a href="#this">24岁</a>
                <a href="#this">处女座</a>
                <a href="#this">三围  89/60/99</a>
                <a href="#this">生日 1994/02/09</a>
            </div>
            <div class="bottom">
                <div class="title">工作经验:</div>
                <p><?=$user->career?></p>
            </div>
        </div>
    </div>
    <!--Ta的技能-->
    <div class="home_basic_ability mt40">
        <div class="inner">
            <div class="title">
                <h3>Ta的技能</h3>
            </div>
            <ul class="outerblock">
                <li class="itms_list">
                    <div class="items flex flex_justify">
                        <span class="items_name"><i class="iconfont color_y">&#xe631;</i>约电影</span>
                        <div>
                            <span class="price"><i>500</i> 美币/小时</span>
                            <a href="#this" class="date">约他</a>
                        </div>
                    </div>
                </li>
                <li class="itms_list">
                    <div class="items flex flex_justify">
                        <span class="items_name"><i class="iconfont color_y">&#xe631;</i>约电影</span>
                        <div>
                            <span class="price"><i>500</i> 美币/小时</span>
                            <a href="#this" class="date">约他</a>
                        </div>
                    </div>
                </li>
                <li class="itms_list">
                    <div class="items flex flex_justify">
                        <span class="items_name"><i class="iconfont color_y">&#xe631;</i>约电影</span>
                        <div>
                            <span class="price"><i>500</i> 美币/小时</span>
                            <a href="#this" class="date">约他</a>
                        </div>
                    </div>
                </li>
                <li class="itms_list">
                    <div class="items flex flex_center more">
                        <i class="iconfont more color_y">&#xe62f;</i>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!--查看Ta的微信-->
    <ul class="home_seach_info outerblock mt40">
        <li>
            <a class="items flex flex_justify" href="#this">
                <span class="seach_name">查看Ta的微信</span>
                <span class="golook">点击查看<i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <li>
            <a class="items flex flex_justify">
                <span class="seach_name">Ta的约会/排队</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <li>
            <a class="items flex flex_justify">
                <span class="seach_name">Ta的评选</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
    </ul>
    <!--其它资料-->
    <ul class="home_seach_otherinfo outerblock mt40">
        <li>
            <a class="items flex flex_justify" href="#this">
                <span class="seach_name importext">其它资料</span>
                <span class="golook"><i class="iconfont r_icon">&#xe605;</i></span>
            </a>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">情感状态</span>
                <span class="golook">单身中</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">TA的家乡</span>
                <span class="golook">中南海</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的美食</span>
                <span class="golook">中南海</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的音乐</span>
                <span class="golook">中南海</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">喜欢的电影</span>
                <span class="golook">中南海</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name sport_items">喜欢的运动/娱乐</span>
                <span class="golook">中南海</span>
            </div>
        </li>
        <li>
            <div class="items flex">
                <span class="seach_name">个人签名</span>
                <span class="golook">中南海</span>
            </div>
        </li>
    </ul>
</div>
<div class="togift flex flex_center">
    <i class="iconfont">&#xe614;</i>
</div>
<div style="height:1.6rem"></div>
<!--底部-->
<div class="home_page_footer">
    <ul class="clearfix  flex flex_justify">
        <li class="active">
            <a href="#this" class="active">
                <i class="iconfont">&#xe63d;</i>关注
            </a>
        <li>
            <a href="#this">
                <i class="iconfont">&#xe632;</i>约Ta
            </a>
        </li>
        <li>
            <a href="#this">
                <i class="iconfont">&#xe603;</i>私聊
            </a>
        </li>
    </ul>
</div>
<!--弹出层-->
<!--约Ta弹出层-->
<div style="display:none" class="raper show flex flex_center">
    <!--约Ta弹出层-->
    <div class="popup" style="display: none;">
        <div class="popup_con">
            <h3 class="aligncenter">需支付100美币才能看到她的微信需支付100美币才能看到她的微信需支付100美币才能看到她的微信</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn cancel">取消</span>
            <span class="footerbtn gopay">立即支付</span>
        </div>
    </div>
    <!--查看微信弹出层-->
    <div class="popup wx_popup" hidden>
        <div class="popup_con">
            <h3 class="aligncenter"><span class="wx_user">范冰冰微信<i class="iconfont color_wx">&#xe641;</i></span></h3>
            <ul class="wx_copy_con">
                <li class="flex flex_justify">
                    <span class="wx_l_con">微信号：fangmeimei</span>
                    <span class="wx_r_copy">复制</span>
                </li>
                <li class="flex flex_justify">
                    <span class="wx_l_con">暗号：明天下雨吗？</span>
                    <span class="wx_r_copy">复制</span>
                </li>
            </ul>
            <h3 class="wx_tips smallarea">添加微信时，注意一定要填写暗号</h3>
            <p class="wx_care_tips smallarea">若微信号为空假号，点击此处<a href="#this" class="color_ts">举报</a></p>
        </div>
        <span class="closed"><i class="iconfont">&#xe644;</i></span>
    </div>
</div>
