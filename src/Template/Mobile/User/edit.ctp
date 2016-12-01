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
                <div class="iden_r_box fr" id="avatar_img">
                    <div class="iden_r_pic">
                        <img src="<?= $user->avatar; ?>" alt="" />
                        <input type="hidden" name="avatar" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
        </ul>
    </div>
    <div class="identify_basic_info mt40">
        <ul class="inner">
            <li class="clearfix" onclick="window.location.href='/userc/edit-basic';">
                <a>
                    <span class="fl">基本信息</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix" onclick="window.location.href='/userc/edit-auth';">
                <a href="#this">
                    <span class="fl">身份认证</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix" onclick="window.location.href='/userc/edit-basic-pic';">
                <a href="#this">
                    <span class="fl">基本照片与视频上传</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
        </ul>
    </div>
    <div class="complete_basic_info mt100">完善个人资料有奖，<a href="#this">点击查看详情</a></div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#avatar_img').on('tap', function () {
        //点击选择图片
        if ($.util.isAPP) {
            LEMON.event.uploadAvatar('{"dir":"user/avatar","zip":"1"}', function (data) {
                var data = JSON.parse(data);
                if (data.status === true) {
                    uploadAvatar(data.path, data.urlpath);
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
                        $.util.alert(msg.msg);
                        if (msg.status === true) {
                            $('#upload_pic img').attr('src', msg.path);
                            $('input[name="avatar"]').val(msg.path);
                        }
                    }
                });
            });
        } else {
            $.util.alert('请在微信或APP上传图片');
        }
    });


    //上传头像
    public function uploadAvatar(path, urlpath) {
        if (!path) {
            return false;
        }
        $.util.ajax({
            url: 'user/reg-user-info',
            data: {avatar: path},
            func: function (res) {
                $.util.alert(res.msg);
                if (res.status) {
                    $('#avatar_img').attr('src', urlpath);
                }
            }
        });
    }
</script>
<?php $this->end(); ?>
