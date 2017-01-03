<link rel="stylesheet" type="text/css" href="/mobile/css/LArea.css"/>
<div class="wraper bgff">
    <div class="info-header-tips">
        <!--<div class="closed">
            <a href="#this" class="iconfont">&#xe684;</a>
        </div>-->
        <h3 class="aligncenter title">完善个人信息<br/>可以提高魅力值哦~</h3>
    </div>
    <form>

        <div id="avatar-input" class="identify_img_ifo">

        </div>
        <div class="home_fill_basic_info ">
            <ul>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">昵</span><span class="itemsname">称</span>

                        </div>
                        <div class="home_list_r_info">
                            <input name="nick" id="nick" type="text" placeholder="请输入昵称"/>
                        </div>
                    </div>
                </li>
                <li class="birthdate  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">出</span><span
                                class="itemsname">生</span><span class="itemsname">日</span><span
                                class="itemsname">期</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input name="birthday" type="text" placeholder="出生日期" readonly="readonly"/>
                                <input type="date" onchange='inputChange(this)'/>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重：</span>
                        </div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" id="weight" name="weight" placeholder="你的体重" readonly="readonly"/>
                                <select onchange='inputChange(this)'>
                                    <option value="55-">55-KG</option>
                                    <option value="56">56KG</option>
                                    <option value="57">57KG</option>
                                    <option value="58">58KG</option>
                                    <option value="59">59KG</option>
                                    <option value="60">60KG</option>
                                    <option value="61">61KG</option>
                                    <option value="62">62KG</option>
                                    <option value="63">63KG</option>
                                    <option value="64">64KG</option>
                                    <option value="65">65KG</option>
                                    <option value="66">66KG</option>
                                    <option value="67">67KG</option>
                                    <option value="68">68KG</option>
                                    <option value="69">69KG</option>
                                    <option value="70">70KG</option>
                                    <option value="71">71KG</option>
                                    <option value="72">72KG</option>
                                    <option value="73">73KG</option>
                                    <option value="74">74KG</option>
                                    <option value="75+">75+KG</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info "><span class="itemsname short_name">身</span><span
                                class="itemsname">高：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" id="height" name="height" placeholder="你的身高" readonly="readonly"/>
                                <select onchange='inputChange(this)'>
                                    <option value="160-">160-CM</option>
                                    <option value="161">161CM</option>
                                    <option value="162">162CM</option>
                                    <option value="163">163CM</option>
                                    <option value="164">164CM</option>
                                    <option value="165">165CM</option>
                                    <option value="166">166CM</option>
                                    <option value="166">167CM</option>
                                    <option value="166">168CM</option>
                                    <option value="166">169CM</option>
                                    <option value="170">170CM</option>
                                    <option value="171">171CM</option>
                                    <option value="172">172CM</option>
                                    <option value="173">173CM</option>
                                    <option value="174">174CM</option>
                                    <option value="175">175CM</option>
                                    <option value="176">176CM</option>
                                    <option value="177">177CM</option>
                                    <option value="178">178CM</option>
                                    <option value="179">179CM</option>
                                    <option value="180">180+CM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname short_name">家</span><span
                                class="itemsname">乡：</span></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" readonly="readonly" placeholder="请输入您的家乡"/>
                            <input id="vtown" type="hidden"/>
                        </div>
                    </div>
                </li>
                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">所</span><span
                                class="itemsname">在</span><span class="itemsname">地</span><span
                                class="itemsname">区：</span></div>
                        <div class="home_list_r_info">
                            <input id="city" name="city" type="text" placeholder="请输入所在地区"/>
                            <input id="vcity" type="hidden"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业：</span>
                        </div>
                        <div class="home_list_r_info">
                            <input id="profession" name="profession" type="text" placeholder="请输入职业"/>
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

<script id="avatar-tpl" type="text/html">
    <ul class="inner">
        <li class="clearfix">
            <span class="fl">头 像</span>
            <div class="iden_r_pic fr">
                <div class="iden_r_pic">
                    <img id="avatar_img" src="/mobile/images/headpic.png" alt=""/>
                </div>
                <i class="iconfont potion">&#xe605;</i>
                <input id="avatar" name="avatar" type="hidden"/>
            </div>
        </li>
    </ul>
</script>
<!--标签选择框-->
<?= $this->cell('Select::place'); ?>
<?= $this->start('script'); ?>
<script src="/mobile/js/LArea.js" type="text/javascript"></script>
<script src="/mobile/js/LAreaData1.js" type="text/javascript"></script>
<script type="text/javascript">
    //家乡
    var area1 = new LArea();
    area1.init({
        'trigger': '#hometown',
        'valueTo': '#vtown',
        'keys': {
            id: 'id',
            name: 'name'
        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        'type': 1, //数据源类型
        'data': LAreaData //数据源
    });
    //城市
    var area2 = new LArea();
    area2.init({
        'trigger': '#city',
        'valueTo': '#vcity',
        'keys': {
            id: 'id',
            name: 'name'
        },
        'type': 1,
        'data': LAreaData
    });
</script>
<script>
    init();
    function init() {
        if ($.util.isAPP) {
            var tmpl = $('#avatar-tpl').html();
            $('#avatar-input').html(tmpl);
        }
    }
    function tochange(that) {
        $(that).siblings().val(that.options[that.selectedIndex].text);
    }
    function inputChange(that) {
        $(that).siblings().val($(that).val());
    }
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
        if (v.length > 5) {
            $(this).val(v.substr(0, 5));
        }
    });
    $('#height,#weight').keyup(function () {
        var v = $(this).val();
        if (v.length > 3) {
            $(this).val(v.substr(0, 3));
        }
    });
    $.picker(function () {
        if (window.selecter == 'city') {
            $('#city').val(_city);
        } else {
            $('#hometown').val(_city);
        }
    });
    $('#profession').keyup(function () {
        var v = $(this).val();
        if (v.length > 6) {
            $(this).val(v.substring(0, 6));
        }
    });
    LEMON.sys.setTopRight('跳过');
    window.onTopRight = function () {
        window.location.href = '/index/find-list';
    }
    $('#submit').on('tap', function () {
        var form = $('form');
        console.log(form.serialize());
        return;
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