<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>美约认证</h1>
    </div>
</header> -->
<div class="wraper">
    <?php if (!$user->auth_video): ?>
        <div class="identify_info_des">
            <div class="inner">
                <ul>
                    <li>
                        <h3><i class="iconfont color_y">&#xe604;</i>为什么要真人脸部识别？</h3>
                        <div class="con">
                            <p>美约作为一个真实的高端红人工作交友平台，希望给大家提供一个真诚的工作交友环境。请放心您上传的真人视频仅供审核用，仅自己可见，其他人无法看到。</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    <?php elseif ($user->auth_status == UserStatus::NOPASS): ?>
        <div class="identity_audit_pass">
            <i class='iconfont color_error'>&#xe61a;</i>
            <h3 class="jump_tipscon">审核不通过!</h3>
            <p class="audit_des">手持身份证的照片不够清晰，请重新拍照然后上传。集奥思路打法骄傲的解放路卡斯加发撒的金风科技。</p>
        </div>
    <?php elseif ($user->auth_status == UserStatus::CHECKING): ?>
        <div class="identity_audit_pass">
            <i class='iconfont color_y' style="font-size:2rem">&#xe681;</i>
            <h3 class="jump_tipscon">审核中!</h3>
        </div>
    <?php endif; ?>
    <div class="identify_info_des">
        <?php if (!$user->auth_video || ($user->auth_status == UserStatus::NOPASS)): ?>
            <div class="inner">
                <ul>
                    <li>
                        <h3><i class="iconfont color_y">&#xe604;</i>我的认证视频</h3>
                        <div class="con">
                            <div class="up_identify_box">
                                <p class="smallarea">请对准手机屏幕：1.露齿笑，2.左转头，3.右转头</p>
                                <div id="auth_video" class="btn btn_dark_t mt40">点击录制</div>
                                <div class="fact_identify mt40"   style="display: none;">
                                    <dl  class="Idcard personimg">
                                        <dt>
                                        <img src="/mobile/images/upimg.png" alt="" />
                                        </dt>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <!--上传-->
            </div>
        <?php endif; ?>
        <?php if ($user->auth_status == UserStatus::CHECKING): ?>
            <div class="up_identify_box bgff mt40">
                <div class="inner">
                    <div class="title">
                        <h3 class="color_black">我的真人视频认证</h3>
                    </div>
                    <div class="fact_identify">
                       <div class="home_pic_info" style='padding:0;'>
                        <div class="home_video">
                           <video width='100%' height='auto' class="basevd" controls="controls" preload="preload" 
                           src="<?= $user->auth_video ?>" poster="<?= $user->auth_video_cover ?>"></video>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div style="height:62px;"></div>
<?php if (!$user->auth_video): ?>
    <a id="submit" class="identify_footer_potion">提交审核</a>
<?php elseif ($user->auth_status == UserStatus::NOPASS): ?>
    <a id="submit" class="identify_footer_potion">重新审核</a>
<?php endif; ?>
<?= $this->start('script'); ?>
<script>
    var user_id = <?= $user->id ?>;
    $.util.chooseAuthVideo('auth_video', '注意依次做以下动作：点头，露齿笑，往左转头，举右手');
    $('#submit').on('click', function() {
        $.util.showPreloader();
        if ($('#auth_video').data('choosed'))
            var param = {};
        param['action'] = 'up_auth_video';
        param = JSON.stringify(param);
        LEMON.event.uploadVideo({key: 'auth_video', user_id: user_id, param: param}, function (res) {
            if (res) {
                $.util.alert('视频已提交');
                setTimeout(function () {
                    document.location.href = '/userc/edit-info';
                }, 1000);
            }
        });
    });
</script>
<?= $this->end('script'); ?>