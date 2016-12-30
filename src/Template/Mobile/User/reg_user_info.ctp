<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>美约认证信息填写</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="identify_img_ifo">
        <ul class="inner">
            <!--            <li class="clearfix">
                            <span class="fl">个人头像</span>
                            <div class="iden_r_box fr">
                                <div id='thumbnail' class="iden_r_pic">
                                    <img id='avatar_img' src="/mobile/images/headpic.png" alt="" />
                                    <input id='avatar' type="file" name="avatar" class="img-input" 
                                           style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" />
                                </div>
                                <i class="iconfont potion">&#xe605;</i>
                            </div>
                        </li>-->
            <li class="clearfix">
                <span class="fl">上传头像</span>
                <div class="iden_r_box fr">
                    <div class="iden_r_pic">
                        <img id='avatar_img' src="/mobile/images/headpicinfo.png" alt="" />
                        <input type="hidden" name="avatar" />
<!--                        <input id='avatar' type="hidden" name="avatar" class="img-input" 
                               style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" single />-->
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
        </ul>
    </div>
</div>
<div style="height:62px;"></div>
<?php if ($user->gender == '2'): ?>
    <a id="submit" class="identify_footer_potion">下一步</a>
<?php else: ?>
    <a href="/index/index" class="identify_footer_potion">跳过</a>
<?php endif; ?>
<?= $this->start('script'); ?>
<script>
    $('#avatar_img').on('tap', function () {
        //点击选择图片
        //alert('点击了图片上传');
        if ($.util.isAPP) {
            //alert('我要调app的东西了');
            LEMON.event.uploadAvatar('{"dir":"user/avatar","zip":"1"}', function (data) {
                var data = JSON.parse(data);
                if (data.status === true) {
                    $('input[name="avatar"]').val(data.path);
                    $('#avatar_img').attr('src', data.urlpath);
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
    $('#submit').on('tap', function () {
        var avatar = $('input[name="avatar"]').val();
        //alert(avatar);
        if (!avatar) {
            return false;
        }
        $.util.ajax({
            data: {avatar: avatar},
            func: function (res) {
                if (res.status) {
                    document.location.href = '/user/reg-basic-info';
                } else {
                    $.util.alert(res.msg);
                }
            }
        });
    });
</script>
<?= $this->end('script'); ?>