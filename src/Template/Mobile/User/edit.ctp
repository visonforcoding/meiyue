<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>个人信息</h1>
    </div>
</header>
<div class="wraper">
    <h3 class="basic_info_integrity">当前资料完整度<?= $percent;?>%</h3>
    <div class="identify_img_ifo mt40">
        <ul class="inner">
            <li class="clearfix">
                <span class="fl">上传图片</span>
                <div class="iden_r_box fr">
                    <div class="iden_r_pic">
                        <img src="<?= $user->avatar; ?>" alt="" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
        </ul>
    </div>
    <div class="identify_basic_info mt40">
        <ul class="inner">
            <li class="clearfix" onclick="window.location.href = '/userc/edit-basic';">
                <a>
                    <span class="fl">基本信息</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix">
                <a href="#this">
                    <span class="fl">身份认证</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix">
                <a href="#this">
                    <span class="fl">基本照片与视频上传</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
        </ul>
    </div>
    <div class="complete_basic_info mt100">完善个人资料有奖，<a href="#this">点击查看详情</a></div>
</div>