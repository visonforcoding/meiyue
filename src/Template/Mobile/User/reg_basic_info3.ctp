<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
        <span id="next" class="r_btn">提交</span>
    </div>
</header>
<div class="wraper">
    <!--基本信息三步-->
    <div class="basicinfo-header">
        <div class="line-box">
            <div class="info-line flex flex_justify">
                <div class="active"></div>
                <div class="active"></div>
            </div>
            <div class="stepnode flex flex_justify">
                <span class="active"></span>
                <span  class="active"></span>
                <span class="active"></span>
            </div>
            <div class="step flex flex_justify">
                <h3 class="active">第一步</h3>
                <h3 class="active">第二步</h3>
                <h3 class="active">第三步</h3>
            </div>
        </div>
    </div>
    <div class="identify_info_des">
        <div class="up_identify_box bgff">
            <div class="inner">
                <div class="upload_more_title">
                    <h3 class="color_black">照片和视频认证示范</h3>
                    <p>请上传自己的性感、具有诱惑力的照片，注意不能有私密处的裸露。</p>
                </div>
                <div class="fact_identify">
                    <dl class="Idcard">
                        <dt>
                        <img src="/mobile/images/avatar.jpg" alt="" />
                        </dt>
                    </dl>
                    <dl class="Idcard">
                        <dt>
                        <img src="/mobile/images/avatar.jpg" alt="" />
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
        <!--示例-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">如上图所示，上传9张认证照片</h3>
                </div>
                <div  class="fact_identify" id="demoImg">
                    <dl class="Idcard" data-id="up">
                        <dt><img src="/mobile/images/upimg.png" /></dt>
                    </dl>
                </div>
            </div>
        </div>
        <!--上传-->
        <div class="up_identify_box bgff mt40">
            <div class="inner">
                <div class="title">
                    <h3 class="color_black">如上图所示，上传认证视频</h3>
                </div>
                <div class="fact_identify">
                    <dl class="Idcard">
                        <dt id="up_video">
                        <img src="/mobile/images/upimg.png" alt="" />
                        <i class="iconfont playbtn">&#xe600;</i>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
        <!--上传-->
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    var user_id = <?= $user->id ?>;
    $.util.choosImgs('demoImg');
    $.util.chooseVideo('up_video');

    LEMON.sys.setTopRight('提交')
    window.onTopRight = function () {
        $.util.showPreloader();
        if ($('#demoImg').data('max') === '0') {
            var param = {};
            param['action'] = 'add_basic_pic';
            param = JSON.stringify(param);
            LEMON.event.uploadPics({key: 'demoImg', user_id: user_id, param: param});
        }else{
            $.util.alert('请上传基本图片');
            return false;
        }
        if ($('#up_video').data('choosed')) {
            LEMON.event.uploadVideo({key: 'up_video', user_id: user_id});
        }else{
            $.util.alert('请上传基本视频');
            return false;
        }
        //$.util.alert('完成注册');
        $.util.ajax({
            url: '/user/w-reg-login/' + user_id,
            func: function (res) {
                if (res.status) {
                    $.util.setCookie('token_uin', res.user.user_token);
                    LEMON.db.set('gender', res.user.gender);
                    LEMON.db.set('token_uin', res.user.user_token);
                    LEMON.db.set('im_accid', res.user.imaccid);
                    LEMON.db.set('im_token', res.user.imtoken);
                    LEMON.db.set('avatar', res.user.avatar);
                    LEMON.sys.endReg();
                    document.location.href = '/user/reg-basic-info-4';
                }
            }
        });
    }


</script>
<?= $this->end('script'); ?>