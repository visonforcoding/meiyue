<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
        <span id="next" class="r_btn">下一步</span>
    </div>
</header>
<div class="wraper">
    <!--基本信息三步-->
    <div class="basicinfo-header">
        <div class="line-box">
            <div class="info-line flex flex_justify">
                <div></div>
                <div></div>
            </div>
            <div class="stepnode flex flex_justify">
                <span class="active"></span>
                <span></span>
                <span></span>
            </div>
            <div class="step flex flex_justify">
                <h3 class="active">第一步</h3>
                <h3>第二步</h3>
                <h3>第三步</h3>
            </div>
        </div>
    </div>
    <form>
        <div class="identify_img_ifo mt40">
            <ul class="inner">
                <li class="clearfix">
                    <span class="fl">头 像</span>
                    <div class="iden_r_box fr">
                        <div class="iden_r_pic">
                            <img id="avatar_img" src="/mobile/images/headpic.png" alt="" />
                        </div>
                        <input id="avatar" name="avatar" type="hidden" />
                        <i class="iconfont potion">&#xe605;</i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="home_fill_basic_info  mt40">
            <ul>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">昵</span><span class="itemsname">称：</span>
                            <i class="iconfont ico"></i>
                        </div>
                        <div class="home_list_r_info">
                            <input id="nick" name="nick" type="text" placeholder="请输入昵称" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info "><span class="itemsname">真</span><span class="itemsname">实</span><span class="itemsname">姓</span><span class="itemsname">名：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input id="truename" name="truename" type="text" placeholder="请输真实姓名" />
                        </div>
                    </div>
                </li>
                <li class="birthdate">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">出</span><span class="itemsname">生</span><span class="itemsname">日</span><span class="itemsname">期：</span></div>
                        <div class="home_list_r_info">
                            <input id="birthday" name="birthday" type="text" placeholder="请输入日期" value="1992-09-24"/>
                        </div>
                    </div>
                </li>
               
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重：</span></div>
                        <div class="home_list_r_info">
                            <input id="weight" name="weight" type="number" placeholder="您的体重" />&nbsp;<i class="ml10">KG</i>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info "><span class="itemsname short_name">身</span><span class="itemsname">高：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input id="height" name="height" type="number" placeholder="您的身高" />&nbsp;CM
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">三</span><span class="itemsname">围：</span></div>
                        <div class="home_list_r_info">
                            <input name="b" type="number" placeholder="腰围" style="width:30px;" /> | 
                            <input name="w" type="number" placeholder="胸围" style="width:30px;" /> | 
                            <input name="h" type="number" placeholder="臀围" style="width:30px;" />
                        </div>
                    </div>
                </li>
                 
                <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">罩</span><span class="itemsname">杯：</span></div>
                        <div class="home_list_r_info">
                            <select name="cup">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C" selected="selected">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="start_sign  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">星</span><span class="itemsname">座：</span></div>
                        <div class="home_list_r_info">
                            <select id="zodiac"  name="zodiac">
                                <option value="0" selected="selected">选星座</option>
                                <option value="1">白羊座</option>
                                <option value="2">金牛座</option>
                                <option value="3">双子座</option>
                                <option value="4">巨蟹座</option>
                                <option value="5">狮子座</option>
                                <option value="6">处女座</option>
                                <option value="7">天秤座</option>
                                <option value="8">天蝎座</option>
                                <option value="9">射手座</option>
                                <option value="10">摩羯座</option>
                                <option value="11">水瓶座</option>
                                <option value="12">双鱼座</option>
                            </select>
                        </div>
                    </div>
                </li>
                 <li class="emontion   right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">情</span><span class="itemsname">感</span><span class="itemsname">状</span><span class="itemsname">态：</span></div>
                        <div class="home_list_r_info">
                            <select id="state" name="state">
                                <option value="1" selected="selected">单身</option>
                                <option value="2">私密</option>
                            </select>
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

                <li class='right-ico'>
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
               
                <li  class="plaintext-box">
                    <div class="home_items plaintexts">
                        <div class="home_list_l_info"><span class="itemsname">工</span><span class="itemsname">作</span><span class="itemsname">经</span><span class="itemsname">历：</span></div>
                        <div class="home_list_r_info">
                           <textarea id="sport" name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的运动/娱乐"></textarea>
                        </div>
                    </div>
                </li>
        </div>
    </form>
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
    $('#food').keyup(function () {
        var v = $(this).val();
        if (v.length > 12) {
            $.util.alert('喜欢的美食输入过长');
        }
    });
    $('#sport').keyup(function () {
        var v = $(this).val();
        if (v.length > 12) {
            $.util.alert('喜欢的运动输入过长');
        }
    });
    $.picker(function () {
        if (window.selecter == 'city') {
            $('#city').val(_city);
        } else {
            $('#hometown').val(_city);
        }
    });
    $('#city').on('tap', function () {
        window.selecter = 'city';
        $('.picker-modal').removeClass('modal-hide');
    });
    $('#hometown').on('tap', function () {
        window.selecter = 'hometown';
        $('.picker-modal').removeClass('modal-hide');
    });
    LEMON.sys.setTopRight('下一步');
    window.onTopRight = function () {
        if ($('#nick').length > 6) {
            $.util.alert('昵称不要超过6个字符');
            return false;
        }
        if (!$('#avatar').val()) {
            $.util.alert('未选择头像');
            return false;
        }
        if (!$('#nick').val()) {
            $.util.alert('未填写昵称');
            return false;
        }
        if (!$('#truename').val()) {
            $.util.alert('真实姓名必填');
            return false;
        }
        if (!$('#height').val()) {
            $.util.alert('身高必填');
            return false;
        }
        if (!$('#weight').val()) {
            $.util.alert('体重必填');
            return false;
        }
        if (!$("#zodiac").val()) {
            $.util.alert('未选择星座');
            return false;
        }
        if (!$("#hometown").val()) {
            $.util.alert('未选择星座');
            return false;
        }
        if (!$("#city").val()) {
            $.util.alert('所在地必填');
            return false;
        }
        if (!$("#profession").val()) {
            $.util.alert('职业未填写');
            return false;
        }
        if ($('#height').length > 3) {
            $.util.alert('身高输入不正确');
            return false;
        }
        if ($('#wight').length > 3) {
            $.util.alert('体重输入不正确');
            return false;
        }
        if ($('#food').length > 12) {
            $.util.alert('喜欢的美食输入过长');
            return false;
        }
        if ($('#sport').length > 12) {
            $.util.alert('喜欢的美食输入过长');
            return false;
        }
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                if (res.status) {
                    window.location.href = '/user/reg-basic-info-2';
                } else {
                    console.log(res);
                }
            }
        });
    }
</script>
<?= $this->end('script'); ?>