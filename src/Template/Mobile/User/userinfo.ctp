<header class="bar bar-nav">
    <a class="goback icon icon-left pull-left"></a>
    <button class="button button-link button-nav pull-right">
        保存
    </button>
</header>
<div class="content">
    <div class="list-block media-list" style="margin-top:0px">
        <ul>
            <li>
                <a href="/user/userinfo" class="item-link item-content">
                    <div id="upload_pic" class="item-media">
                        <img  class="img-circle" src="/imgs/user/avatar/avatar.jpg" width="60"/>
                        <i class="icon icon-f7"></i>
                        <input name="avatar" type="hidden"/>
                    </div>
                    <div class="item-inner">
                        <div class="item-title-row">
                            <div class="item-title">绾儿</div>
                        </div>
                        <div class="item-subtitle">ID1000425</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
    $('#upload_pic').on('touchstart', function () {
        if ($.util.isAPP) {
            LEMON.event.uploadPhoto('{"dir":"user/avatar","zip":"1"}', function (data) {
                var data = JSON.parse(data);
                if (data.status === true) {
                    $('input[name="avatar"]').val(data.thumbpath);
                    $('#upload_pic img').attr('src', data.thumbpath);
                    $.util.ajax({
                        url: '/user/getAppPic',
                        data: {avatar: data.thumbpath},
                        func: function (msg) {
                            if (msg.status) {
                                $.util.alert(msg.msg);
                            } else {
                                $.util.alert(msg.msg);
                            }
                        }
                    });
                } else {
                    $.util.alert('app上传失败');
                }
            });
            return false;
        } else if ($.util.isWX) {
            $.util.wxUploadPic(function (ids) {
                alert(ids);
                $.util.ajax({
                    url: "/user/getWxPic",
                    data:{ids:ids},
                    func: function (msg) {
                        $.util.alert(msg.msg);
                        if (msg.status === true) {
                            $('#upload_pic img').attr('src', msg.path);
                            $('input[name="avatar"]').val(msg.path);
                        }
                    }
                });
            },9);
        } else {
            $.util.alert('请在微信或APP上传图片');
        }
    });
</script>
<?php $this->end('script'); ?>