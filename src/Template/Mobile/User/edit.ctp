<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>个人信息</h1>
    </div>
</header> -->
<div class="wraper">
    <h3 class="basic_info_integrity">当前资料完整度<?= $percent; ?>%</h3>
    <div class="identify_img_ifo mt40">
        <ul class="inner">
            <li class="clearfix" id="avatar_img">
                <span class="fl">上传图像</span>
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

                <span class="fl">基本信息</span>
                <span class="fr"><i class="iconfont right_ico ">&#xe605;</i></span>

            </li>
            <li class="clearfix" <?= (!($user->idfront) || !($user->idback) || !($user->idperson) || ($user->id_status == UserStatus::NOPASS)) ? 'onclick="window.location.href=\'/userc/edit-auth\';"' : '' ?>>
                <span class="fl">身份认证</span>
                <?php if (!($user->idfront) || !($user->idback) || !($user->idperson)): ?>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                <?php elseif ($user->id_status == UserStatus::PASS): ?>
                    <span class="fr">
                        <i class="color_gray fr-des">审核通过</i>
                    </span>
                <?php elseif ($user->id_status == UserStatus::CHECKING): ?>
                    <span class="fr" onclick="window.location.href = '/userc/edit-auth';">
                        <i class="color_gray fr-des">审核中</i><i class="iconfont right_ico">&#xe605;</i>
                    </span>
                <?php elseif ($user->id_status == UserStatus::NOPASS): ?>
                    <span class="fr" onclick="window.location.href = '/userc/edit-auth';">
                        <i class="color_error fr-des">审核不通过</i><i class="iconfont right_ico">&#xe605;</i>
                    </span>
                <?php endif; ?>

            </li>
            <?php if ($user->gender == 2): ?>
                <li class="clearfix">
                    <span class="fl">真人脸部识别</span>
                    <?php if (!$user->auth_video): ?>
                        <span class="fr"  onclick="window.location.href = '/userc/edit-true';">
                            <i class="iconfont right_ico fr">&#xe605;</i>
                        </span>
                    <?php elseif ($user->auth_status == UserStatus::PASS): ?>
                        <!--<i class="iconfont right_ico fr">&#xe605;</i>-->
                        <span class="fr">
                            <i class="color_gray fr-des">审核通过</i>
                        </span>
                    <?php elseif ($user->auth_status == UserStatus::CHECKING): ?>
                        <span class="fr" onclick="window.location.href = '/userc/edit-true';">
                            <i class="color_gray fr-des">审核中</i><i class="iconfont right_ico">&#xe605;</i>
                        </span>
                    <?php elseif ($user->auth_status == UserStatus::NOPASS): ?>
                        <span class="fr" onclick="window.location.href = '/userc/edit-true';">
                            <i class="color_error fr-des">审核不通过</i><i class="iconfont right_ico">&#xe605;</i>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
            <!--  <li class="clearfix" onclick="window.location.href='/userc/edit-auth';">
                 <a href="#this">
                     <span class="fl">真人视频认证</span>
                     <i class="iconfont right_ico fr">&#xe605;</i>
                 </a>
             </li> -->
            <?php if ($user->gender == 2): ?>
                <li class="clearfix">
                    <a id="status-btn">
                        <span class="fl">基本照片与视频</span>
                        <?php if (!($user->images) || !($user->video)): ?>
                            <i class="iconfont right_ico fr" onclick="window.location.href = '/userc/edit-basic-pic';">&#xe605;</i>
                        <?php elseif ($user->status == UserStatus::PASS): ?>
                            <span class="fr">
                                <i class="color_gray fr-des">审核通过</i>
                            </span>
                        <?php elseif ($user->status == UserStatus::CHECKING): ?>
                            <span class="fr" onclick="window.location.href = '/userc/edit-basic-pic';">
                                <i class="color_gray fr-des">审核中</i><i class="iconfont right_ico">&#xe605;</i>
                            </span>
                        <?php elseif ($user->status == UserStatus::NOPASS): ?>
                            <span class="fr color_gray" onclick="window.location.href = '/userc/edit-basic-pic';">
                                <i class="color_error fr-des">审核不通过</i><i class="iconfont right_ico">&#xe605;</i>
                            </span>
                        <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!--<div class="complete_basic_info mt100">完善个人资料有奖，<a href="#this">点击查看详情</a></div>-->
    <?php if ($user->gender == 2): ?>
        <div class="complete_basic_info mt100"><a href="/user/my-homepage/<?= $user->id; ?>">预览我的主页</a></div>
    <?php endif; ?>
</div>

<?php $this->start('script'); ?>
<script>
    $('#avatar_img').on('tap', function () {
        //点击选择图片
        if ($.util.isAPP) {
            LEMON.event.uploadAvatar('{"dir":"user/avatar","zip":"1"}', function (data) {
                var data = JSON.parse(data);
                if (data.status === true) {
                    $('#avatar_img img').attr('src', data.urlpath);
                    uploadAvatar(data.path);
                } else {
                    $.util.alert('app上传失败');
                }
            });
            return false;
        } else if ($.util.isWX) {
            $.util.wxUploadPic(function (id) {
                $.util.ajax({
                    url: "/user/getWxPic/" + id,
                    func: function (msg) {
                        if (msg.status === true) {
                            $('#avatar_img img').attr('src', msg.path);
                            uploadAvatar(msg.path);
                        }
                    }
                });
            });
            return false;
        } else {
            $.util.alert('请在微信或APP上传图片');
        }
    });


    //上传头像
    function uploadAvatar(path) {
        if (!path) {
            return false;
        }
        var a = {avatar: path};
        $.util.ajax({
            url: '/user/reg-user-info',
            data: a,
            func: function (res) {
                if (res.status) {
                    LEMON.db.set('avatar', res.realUrl);
                }
                $.util.alert(res.msg);
            }
        });
    }
</script>
<?php $this->end(); ?>

<script>
    window.onload = init;
    function init() {
        var imgs = '<?= $user->images; ?>';
        var video = '<?= $user->video; ?>';
        if (imgs && video) {
            $.util.setCookie('UPLOAD_IV', '')
        }
        if ($.util.getCookie('UPLOAD_IV')) {
            $('#status-btn').html('<span class="fl">基本照片与视频上传</span><span class="fr"><i class="color_gray fr-des">上传中</i></span>');
        }
    }
    LEMON.sys.back('/user/index');
</script>
