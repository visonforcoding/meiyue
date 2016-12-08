<div class="wraper bgff">
    <div class="info-header-tips">
        <!--        <div class="closed">
                    <a href="#this" class="iconfont">&#xe684;</a>
                </div>-->
        <h3 class="aligncenter title">完善个人信息<br />可以提高魅力值哦~</h3>
    </div>
    <form>
    <div class="identify_img_ifo">
        <ul class="inner">
            <li class="clearfix">
                <span class="fl">头 像</span>
                <div class="iden_r_pic fr">
                    <div class="iden_r_pic">
                        <img id="avatar_img" src="/mobile/images/headpic.png" alt="" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                    <input id="avatar" name="avatar" type="hidden" />
                </div>
            </li>
        </ul>
    </div>
    <div class="home_fill_basic_info ">
        <ul>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info ">
                        <span class="itemsname">昵</span><span class="itemsname">称：</span>
                       
                    </div>
                    <div class="home_list_r_info">
                        <input name="nick" id="nick" type="text" placeholder="请输入昵称" />
                       
                    </div>
                </div>
            </li>
            <li class="birthdate">
                <div class="home_items">
                    <div class="home_list_l_info"><span class="itemsname">出</span><span class="itemsname">生</span><span class="itemsname">日</span><span class="itemsname">期：</span></div>
                    <div class="home_list_r_info">
                        <input id="birthday" name="birthday" type="date" placeholder="请输入日期" value="1989-09-24"/>
                       
                    </div>
                </div>
            </li>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重：</span></div>
                    <div class="home_list_r_info">
                        <input id="weight" name="weight" type="number" placeholder="您的体重" />&nbsp;KG
                    </div>
                </div>
            </li>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info "><span class="itemsname short_name">身</span><span class="itemsname">高：</span><i class="iconfont ico"></i></div>
                    <div class="home_list_r_info">
                        <input id="height" name="height" type="number" placeholder="您的身高" />&nbsp;cm
                    </div>
                </div>
            </li>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业：</span></div>
                    <div class="home_list_r_info">
                        <input id="profession" name="profession" type="text" placeholder="请输入职业" />
                    </div>
                </div>
            </li>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info"><span class="itemsname short_name">家</span><span class="itemsname">乡：</span></div>
                    <div class="home_list_r_info">
                        <input id="hometown" name="hometown" type="text" placeholder="请输入家乡" />
                    </div>
                </div>
            </li>
            <li>
                <div class="home_items">
                    <div class="home_list_l_info"><span class="itemsname">所</span><span class="itemsname">在</span><span class="itemsname">地</span><span class="itemsname">区：</span></div>
                    <div class="home_list_r_info">
                        <input id="city" name="city" type="text" placeholder="请输入所在地区" />
                    </div>
                </div>
            </li>
        </ul>
    </div>
    </form>
    <div class="other-info-jump">
        <a id="submit" class="color_y">填好了，进入首页</a>
    </div>
    <div style="height:.3rem"></div>
</div>
<!--标签选择框-->
<?= $this->cell('Select::place'); ?>

<?= $this->start('script'); ?>
<script>
    if ($.util.isAPP) {
        //app定位
        if (!$.util.getCookie('coord')) {
            LEMON.event.getLocation(function (res) {
                var data = JSON.parse(res);
                if (data.success === 'ok') {
                    $.util.setCookie('coord', data.lng + ',' + data.lat, 30);
                    $.util.setCookie('coord_time',<?= time() ?>, 30);
                }
            });
        }
    }
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
    $('#nick').keyup(function () {
        var v = $(this).val();
        if (v.length > 6) {
            $.util.alert('昵称不要超过6个字符');
        }
    });
    $('#height,#weight').keyup(function () {
        var v = $(this).val();
        if (v.length > 3) {
            $.util.alert('体重或身高输入不正确');
        }
    });
    $.picker(function () {
        if (window.selecter == 'city') {
            $('#city').val(_city);
        } else {
            $('#hometown').val(_city);
        }
    });
    $('#city').on('click', function () {
        window.selecter = 'city';
        $('.picker-modal').removeClass('modal-hide');
    });
    $('#hometown').on('click', function () {
        window.selecter = 'hometown';
        $('.picker-modal').removeClass('modal-hide');
    });
    LEMON.sys.setTopRight('跳过');
    window.onTopRight = function () {
        window.location.href = '/index/find-list';
    }
    $('#submit').on('tap', function () {
        if ($('#nick').val().length > 6&&$('#nick').val()) {
            $.util.alert('昵称不要超过6个字符');
            return false;
        }
        if ($('#height').val().length > 3&&$('#height').val()) {
            $.util.alert('身高输入不正确');
            return false;
        }
        if ($('#weight').length > 3&&$('#weight').val()) {
            $.util.alert('体重输入不正确');
            return false;
        }
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                if (res.status) {
                    window.location.href = '/index/find-list';
                } else {
                    console.log(res);
                }
            }
        });

    })

</script>
<?= $this->end('script'); ?>