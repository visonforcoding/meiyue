<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="window.location.href='/userc/edit-info'">&#xe602;</i>
        <h1>基本照片与视频上传</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="up_identify_box bgff mt40">
        <?php if (!($user->images) || !($user->video)): ?>
            <div class="inner">
                <div class="upload_more_title">
                    <h3 class="color_black">照片和视频认证示范</h3>
                    <p>请上传自己的性感、具有诱惑力的照片，注意不能有私密处的裸露。</p>
                </div>
                <div class="fact_identify">
                    <dl class="Idcard">
                        <dt>
                            <img src="/mobile/images/avatar.jpg" alt=""/>
                        </dt>
                    </dl>
                    <dl class="Idcard">
                        <dt>
                            <img src="/mobile/images/avatar.jpg" alt=""/>
                        </dt>
                    </dl>
                </div>
            </div>
        <?php elseif ($user->status == UserStatus::NOPASS): ?>
            <div class="identity_audit_pass">
                <i class='iconfont color_error'>&#xe681;</i>
                <h3 class="jump_tipscon">审核不通过!</h3>
                <p class="audit_des">手持身份证的照片不够清晰，请重新拍照然后上传。集奥思路打法骄傲的解放路卡斯加发撒的金风科技。</p>
            </div>
        <?php elseif ($user->status == UserStatus::CHECKING): ?>
            <div class="identity_audit_pass">
                <i class='iconfont color_y' style="font-size:2rem">&#xe604;</i>
                <h3 class="jump_tipscon">审核中!</h3>
            </div>
        <?php endif; ?>
    </div>

    <?php if (($user->status == UserStatus::CHECKING) && ($user->images) && ($user->video)): ?>
        <!--示例-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">基本照片</h3>
                </div>
                <div class="fact_identify" id="demoImg">
                    <?php foreach (unserialize($user->images) as $image): ?>
                        <dl class="Idcard" data-id="up">
                            <dt><img src="<?= $image ?>"/></dt>
                        </dl>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!--示例-->

        <!--上传-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">基本视频</h3>
                </div>
                <div class="fact_identify">
                     <div class="home_pic_info" style='padding:0;'>
                        <div class="home_video">
                            <video width="100%" height="auto" controls="controls" preload="preload"
                                   src="<?= $user->video ?>" poster="<?= $user->video_cover ?>"></video>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!--示例-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">如上图所示，上传9张认证照片</h3>
                </div>
                <div class="fact_identify" id="demoImg">
                    <dl class="Idcard" data-id="up">
                        <dt><img src="/mobile/images/upimg.png"/></dt>
                    </dl>
                </div>
            </div>
        </div>
        <!--示例-->

        <!--上传-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">如上图所示，上传认证视频</h3>
                </div>
                <div class="fact_identify">
                    <dl class="Idcard">
                        <dt id="up_video">
                            <img src="/mobile/images/upimg.png" alt=""/>
                            <i class="iconfont playbtn">&#xe600;</i>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div style="height:62px;"></div>
<?php if (!($user->images) || !($user->video)): ?>
    <a id="submit" class="identify_footer_potion">提交审核</a>
<?php elseif ($user->status == UserStatus::NOPASS): ?>
    <a id="submit" class="identify_footer_potion">重新审核</a>
<?php endif; ?>
<?= $this->start('script'); ?>
<script>
    var user_id = <?=$user->id?>;
    $.util.choosImgs('demoImg');
    $.util.chooseVideo('up_video');
    $('#submit').on('tap', function () {
        if ($('#demoImg').data('max') === '0')
            var param = {};
            param['action'] = 'update_basic_pic';
            param = JSON.stringify(param);
            LEMON.event.uploadPics({
                key: 'demoImg',
                user_id: user_id,
                param:param
            });
        if ($('#up_video').data('choosed'))
             var param = {};
            param['action'] = 'update_basic_video';
            param = JSON.stringify(param);
            LEMON.event.uploadVideo({
                key: 'up_video',
                user_id: user_id,
                param:param
            });
        $.util.showPreloader();
        $.util.setCookie('UPLOAD_IV', true, 15);
        $(this).removeAttr('id');
        $(this).addClass('disabled');
        $.util.ajax({
            url: '/user/clear-basic-pv',
            method: 'POST',
            func: function (res) {
                $.util.hidePreloader();
                location.href = '/userc/edit-info';
            }
        });
    })
</script>
<?= $this->end('script'); ?>

