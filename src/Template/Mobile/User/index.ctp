<div>
    <div class="homepage flex">
        <!--  <div class="header">
             <h1>我的</h1>
             <i class="iconfont install">&#xe661;</i>
         </div> -->
        <div class="home_cover_info flex">
					<span class="avatar" onclick="window.location.href='/user/my-homepage/<?= $user->id; ?>'">
						<img src="<?= createImg($user->avatar) . '?w=150' ?>" class="avatar-pic"
                             onclick="location.href='/user/my-homepage/<?= $user->id; ?>'"/>
                        <!--<div class="vip"><img src="/mobile/images/vip.png" class="responseimg"/></div>-->
					</span>
            <div class="cover_left_info">
                <ul class="">
                    <li class="bbottom userinfo" onclick="window.location.href='/userc/edit-info'">
                        <a href="#this" class="cover_block">
                            <div class='identify-user-info'>
                                <h3 class='flex'>
                                    <span><?= $user->nick ?></span>
                                    <?php if($shown['isActive']): ?>
                                        <span class="hot"><img src="/mobile/images/hot.png" class="responseimg"/></span>
                                    <?php endif; ?>
                                    &nbsp;
                                    <?php if($shown['isHongRen']): ?>
                                        <span class="vip"><img src="/mobile/images/my-hot.png" class="responseimg"/></span>
                                    <?php endif; ?>
                                </h3>
                                <div class="bottom-btn">
                                    <?php if ($user->id_status == UserStatus::PASS): ?>
                                        <span class="identify-info id-btn">身份已认证</span>
                                    <?php endif; ?>
                                    <!--<span class="identify-info video-btn">视频已认证</span>-->
                                </div>
                            </div>
                            <span class="cover_r_ico">
								<i class="iconfont">&#xe605;</i>
							</span>

                        </a>
                    </li>
                    <li class="follow flex flex_justify">
                        <a class="like" href="/userc/likes">我喜欢 <i><?= $focount; ?></i></a>
                        <a class="like" href="/userc/fans">粉丝 <i><?= $facount; ?></i></a>
                        <a class="like" href="/userc/visitors">访客 <i><?= $user->visitnum; ?></i></a>
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
                <a href="/userc/my-purse" class="home_items">
                    <div class="home_list_l_info flex">
                        <i class="iconfont">&#xe60e;</i><span class="itemsname">我的钱包</span>
                    </div>
                    <div class="home_list_r_info">
                        <span class="cashpic"><img src="/mobile/images/cash.png"
                                                   alt=""/><?= $this->Number->format($user->money) ?></span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/dateorder" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60a;</i><span
                                class="itemsname">订单管理</span></div>
                    <div class="home_list_r_info">
                        <!-- <span class="tips"></span>-->
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-activitys" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60b;</i><span
                                class="itemsname">我的派对</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/user/voted" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60c;</i><span
                                class="itemsname">我的选美</span></div>
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
                <a href="/userc/user-skills-index" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60d;</i><span
                                class="itemsname">技能管理</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li id="my-dates-btn">
                <a href="/date/index" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe60f;</i><span
                                class="itemsname">发布约会</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/my-tracle" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont">&#xe610;</i><span
                                class="itemsname">我的动态</span></div>
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
                <a onclick="tel();" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe611;</i><span
                                class="itemsname">联系客服</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href='/user/share' class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe612;</i><span class="itemsname">邀请好友注册</span>
                    </div>
                    <div class="home_list_r_info">
                        <span class="color_gray">成为合伙人</span>
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/suggest" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe69c;</i><span
                                class="itemsname">意见反馈</span></div>
                    <div class="home_list_r_info">
                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
            <li>
                <a href="/userc/install" class="home_items">
                    <div class="home_list_l_info  flex"><i class="iconfont ico">&#xe69d;</i><span
                                class="itemsname">设置</span></div>
                    <div class="home_list_r_info">

                        <i class="iconfont">&#xe605;</i>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="height:53px"></div>
<div class="footer_submit_btn">
    <div class="submit_ico_group">
        <a href="/userc/tracle-pic" class="submit_ico2 submit_ico" id="picbtn">
            <span class="iconfont">&#xe6b9;</span>
        </a>
        <a href="/userc/tracle-video" class="submit_ico3 submit_ico" id="videobtn">
            <span class="iconfont">&#xe6b8;</span>
        </a>
        <div class="submit_ico1 submit_ico" id="submitbtn" data-type='0'>
            <span>发布<br/>动态</span>
        </div>
    </div>
</div>

<!--底部-->
<?= $this->element('footer', ['active' => 'me']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    if ($.util.isAPP) {
        $('.footer_submit_btn').css('bottom', '10px')
    }
    $('#submitbtn').on('tap', function () {
        var data = $(this).data('type');
        switch (data) {
            case '0':
                $('#videobtn').removeClass('moveright').addClass('moveleft');
                $('#picbtn').removeClass('movedown').addClass('moveup');
                $(this).html('<i class="iconfont">&#xe653;</i>');
                $(this).attr('data-type', '1');
                break;
            case '1':
                $('#videobtn').removeClass('moveleft').addClass('moveright');
                $('#picbtn').removeClass('moveup').addClass('movedown');
                $(this).html('<span>发布<br />动态</span>');
                $(this).attr('data-type', '0');
                break;
            default:
                break;
        }
    })

    $('#videobtn,#picbtn').bind('click', function (event) {
        event.preventDefault();
        var url = $(this).attr('href');
        $.util.ajax({
            url: '/userc/check-user-status',
            func: function (res) {
                if (!res.status) {
                    $.util.alert(res.msg);
                } else {
                    document.location.href = url;
                }
            }
        })
    });
    //$.util.showPreloader('前往登录..');
    window.onActiveView = function () {
        // $('#submitbtn').html('<span>发布<br />动态</span>');
        // $('#submitbtn').attr('data-type', '0');
        // $('#videobtn').removeClass('moveleft,moveright');
        // $('#picbtn').removeClass('moveup,movedown');

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
    window.onBackView = window.onActiveView();
    function tel() {
        $.util.confirm(
            '联系客服',
            '0755-33580266',
            function () {
                LEMON.event.tel('0755-33580266');
            },
            null,
            null,
            '拨打'
        )
    }
</script>
<?php $this->end('script'); ?>