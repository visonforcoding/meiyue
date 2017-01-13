<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
        <span class="r_btn">提交</span>
    </div>
</header> -->
<div class="wraper">
    <!--基本信息三步-->
    <div class="basicinfo-header">
        <div class="line-box">
            <div class="info-line flex flex_justify">
                <div class="active"></div>
                <div></div>
            </div>
            <div class="stepnode flex flex_justify">
                <span class="active"></span>
                <span  class="active"></span>
                <span></span>
            </div>
            <div class="step flex flex_justify">
                <h3 class="active">第一步</h3>
                <h3  class="active">第二步</h3>
                <h3>第三步</h3>
            </div>
        </div>
    </div>
    <div class="identify_info_des">
        <div class="inner">
            <ul>
                <li>
                    <h3><i class="iconfont color_y">&#xe604;</i>为什么要真人脸部识别？</h3>
                    <div class="con">
                        <p class='smallarea'>作为一款高端真实的社交软件，我们鼓励您认证真实身份，让每一份友谊都能建立在真实的基础上。您上传的任何信息，仅供审核使用且TA人无法查看，敬请放心。</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="identify_info_des">
        <div class="inner">
            <ul>
                <li>
                    <h3><i class="iconfont color_y">&#xe604;</i>我的真人脸部识别</h3>
                    <div class="con">
                        <div class="up_identify_box">
                            <p class="color_error">请对准手机屏幕：1.露齿笑，2.左转头，3.右转头</p>
                            <div class="fact_identify mt40"   style="display: none;">
                              <div class="home_pic_info" style='padding:0;'>
                                <div class="home_video relpotion flex flex_center">
                                     <img src="/mobile/images/upimg.png" alt="" />
                                     <div class="play-icon"><i class="iconfont"></i></div>
                                </div>
                              </div>
                            </div>
                            <div id="auth_video" class="btn btn_dark_t mt20">点击录制</div>
                        </div>
                    </div>
                </li>
            </ul>
            <!--上传-->
        </div>
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    var user_id = <?= $user->id ?>;
    $.util.chooseAuthVideo('auth_video', '注意依次做以下动作：点头，露齿笑，往左转头，举右手');
    LEMON.sys.setTopRight('下一步');
    window.onTopRight = function () {
        $.util.showPreloader();
        if ($('#auth_video').data('choosed'))
            var param = {};
            param['action'] = 'up_auth_video';
            param = JSON.stringify(param);
            LEMON.event.uploadVideo({key: 'auth_video', user_id: user_id, param: param}, function (res) {
                if (res) {
                    $.util.alert('视频已提交');
                    setTimeout(function () {
                        document.location.href = '/user/reg-basic-info-3/' + user_id;
                    }, 1000);
                }
            });
        //$.util.alert('完成注册
    };


</script>
<?= $this->end('script'); ?>