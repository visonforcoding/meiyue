<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
        <span id="next" class="r_btn">下一步</span>
    </div>
</header> -->
<link rel="stylesheet" type="text/css" href="/mobile/css/LArea.css"/>
<div class="wraper bgff">
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
                            <span class="itemsname">昵</span><span class="itemsname">称</span>
                            <i class="iconfont ico"></i>
                        </div>
                        <div class="home_list_r_info">
                            <input id="nick" name="nick" type="text" placeholder="请输入昵称" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info "><span class="itemsname">真</span><span class="itemsname">实</span><span class="itemsname">姓</span><span class="itemsname">名</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input id="truename" name="truename" type="text" placeholder="请输真实姓名" />
                        </div>
                    </div>
                </li>
                <li class="birthdate  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">出</span><span class="itemsname">生</span><span class="itemsname">日</span><span class="itemsname">期</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input id="birthday" name="birthday" type="text" placeholder="出生日期" readonly="readonly" />
                                <input type="date"  onchange='inputChange(this)' />
                            </div>
                        </div>
                    </div>
                </li>

                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="hidden" id="weight" name="weight" placeholder="你的体重" readonly="readonly"/>
                                <input type="text"  placeholder="你的体重" readonly="readonly"/>
                                <select name="" onchange='tochange(this)'>
                                    <option value="40-">40-KG</option>
                                    <option value="40">40KG</option>
                                    <option value="41">41KG</option>
                                    <option value="42">42KG</option>
                                    <option value="43">43KG</option>
                                    <option value="44">44KG</option>
                                    <option value="45">45KG</option>
                                    <option value="46">46KG</option>
                                    <option value="47">47KG</option>
                                    <option value="48">48KG</option>
                                    <option value="49">49KG</option>
                                    <option value="50">50KG</option>
                                    <option value="51">51KG</option>
                                    <option value="52">52KG</option>
                                    <option value="53">53KG</option>
                                    <option value="54">54KG</option>
                                    <option value="55">55KG</option>
                                    <option value="56">55+KG</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li  class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info "><span class="itemsname short_name">身</span><span class="itemsname">高</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="hidden" id="height" name="height" placeholder="你的身高" readonly="readonly"/>
                                <input type="text"  placeholder="你的身高" readonly="readonly"/>
                                <select name="" onchange='tochange(this)'>
                                    <?php for($i= 155;$i<=200;$i ++): ?>
                                        <option value="<?= $i; ?>" <?= ($user->height == $i)?'selected':''; ?>><?= $i; ?>CM</option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li  class="bwh right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">三</span><span class="itemsname">围</span></div>
                        <div class="home_list_r_info flex flex_end">
                            <div class="home-basic-option">
                                <input  id="bwh_b" name="bwh_b" type="text" placeholder="胸围" readonly="readonly" />
                                <select name="" onchange='tochange(this)'>
                                    <option value="0">胸围</option>
                                    <option value="80">80</option>
                                    <option value="81">81</option>
                                    <option value="82">82</option>
                                    <option value="83">83</option>
                                    <option value="84">84</option>
                                    <option value="85">85</option>
                                    <option value="86">86</option>
                                    <option value="87">87</option>
                                    <option value="88">88</option>
                                    <option value="89">89</option>
                                    <option value="90+">90+</option>
                                </select>
                            </div>|
                            <div class="home-basic-option">
                                <input id="bwh_w" name="bwh_w" type="text" placeholder="腰围"  readonly="readonly"/>
                                <select name="" onchange='tochange(this)'>
                                    <option value="0">腰围</option>
                                    <option value="60">60</option>
                                    <option value="61">61</option>
                                    <option value="62">62</option>
                                    <option value="63">63</option>
                                    <option value="64">64</option>
                                    <option value="65">65</option>
                                    <option value="66">66</option>
                                    <option value="67">67</option>
                                    <option value="68">68</option>
                                    <option value="69">69</option>
                                    <option value="70+">70+</option>
                                </select>
                            </div>|
                            <div class="home-basic-option">
                                <input id="bwh_h" name="bwh_h" type="text" placeholder="臀围"  readonly="readonly"/>
                                <select name="" onchange='tochange(this)'>
                                    <option value="0">臀围</option>
                                    <option value="80">80</option>
                                    <option value="81">81</option>
                                    <option value="82">82</option>
                                    <option value="83">83</option>
                                    <option value="84">84</option>
                                    <option value="85">85</option>
                                    <option value="86">86</option>
                                    <option value="87">87</option>
                                    <option value="88">88</option>
                                    <option value="89">89</option>
                                    <option value="90+">90+</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">罩</span><span class="itemsname">杯</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input name="cup" id="cup" type="text" placeholder="你的罩杯" readonly="readonly"/>
                                <select onchange='tochange(this)'>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C" selected="selected">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">星</span><span class="itemsname">座</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input name="zodiac" id="zodiac"  placeholder="请输入你的星座" readonly="readonly"/>
                                <!--<input  type="text" placeholder="请输入你的星座" readonly="readonly"/>-->
                                <select   onchange='tochange(this)'>
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
                    </div>
                </li>
                <li class="emontion   right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">情</span><span class="itemsname">感</span><span class="itemsname">状</span><span class="itemsname">态</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input id="state" name="state" placeholder="你的情感状态" readonly="readonly"/>
                                <!--<input  type="text" placeholder="你的情感状态" readonly="readonly"/>-->
                                <select   onchange='tochange(this)'>
                                    <option   selected="selected" style="display: none">请选择</option>
                                    <option value="1" >单身</option>
                                    <option value="2">私密</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>


                <li class='right-ico'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname short_name">家</span><span class="itemsname">乡</span></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" readonly="readonly" placeholder="请输入您的家乡" />
                            <input id="vtown" type="hidden" />
                        </div>
                    </div>
                </li>
                <li  class='right-ico'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">所</span><span class="itemsname">在</span><span class="itemsname">地</span><span class="itemsname">区</span></div>
                        <div class="home_list_r_info">
                            <input  id="city" name="city" type="text" readonly="readonly" placeholder="请输入所在地区" />
                            <input id="vcity" type="hidden" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业</span></div>
                        <div class="home_list_r_info">
                            <input id="profession" name="profession" type="text" placeholder="请输入职业" />
                        </div>
                    </div>
                </li>

                <!--<li  class="plaintext-box">
                    <div class="home_items plaintexts">
                        <div class="home_list_l_info"><span class="itemsname">工</span><span class="itemsname">作</span><span class="itemsname">经</span><span class="itemsname">历：</span></div>
                        <div class="home_list_r_info">
                           <textarea id="sport" name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入工作经历"></textarea>
                        </div>
                    </div>
                </li>-->
        </div>
    </form>
    <div style='height:20px'></div>
</div>

<!--标签选择框-->
<?php

use Cake\I18n\Date; ?>
<?= $this->cell('Select::place'); ?>
<?= $this->start('script'); ?>
<script src="/mobile/js/LArea.js" type="text/javascript" ></script>
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
    function tochange(that) {
        if(that.options[that.selectedIndex].value=='0'){
            return;
        }
        $(that).prev('input').val(that.options[that.selectedIndex].text);
        $(that).prev('input').prev().val(that.options[that.selectedIndex].value);
    }
    function inputChange(that) {
        $(that).siblings().val($(that).val());
    }
    var user_id = <?= $user->id ?>;
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
    $('#nick, #truename').keyup(function () {
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
    $('#bwh_b, #bwh_h, #bwh_w').keyup(function () {
        var v = parseInt($(this).val());
        if (v > 99) {
            $(this).val(($(this).val()).substr(0, 2))
        }
        if (v < 0) {
            $(this).val(0);
        }
    });
    $('#profession').keyup(function () {
        var v = $(this).val();
        if (v.length > 6) {
            $(this).val(v.substring(0, 6));
        }
    });
    $('#place, #food, #movie, #music, #sport, #sign').keyup(function () {
        var v = $(this).val();
        if (v.length > 12) {
            $(this).val(v.substring(0, 12));
        }
    });

    $('#next').on('click', function () {
        if (!$('#avatar').val()) {
            $.util.alert('未选择头像');
            return false;
        }
        if (($('#birthday').val()).length == 0) {
            $.util.alert('请填写正确的出生日期');
            $('#birthday').val('<?= new Date('1991-1-1'); ?>');
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
        if ((!$('#bwh_b').val()) || (!$('#bwh_w').val()) || (!$('#bwh_h').val())) {
            $.util.alert('三围必填');
            return false;
        }
        if (!$("#cup").val()) {
            $.util.alert('罩杯必填');
            return false;
        }
        if (!$("#state").val()) {
            $.util.alert('情感状态必填');
            return false;
        }
        if (!$("#zodiac").val()) {
            $.util.alert('未选择星座');
            return false;
        }
        if (!$("#profession").val()) {
            $.util.alert('职业未填写');
            return false;
        }
        if (!$("#hometown").val()) {
            $.util.alert('家乡必填');
            return false;
        }
        if (!$("#city").val()) {
            $.util.alert('所在地区必填');
            return false;
        }
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                if (res.status) {
                    window.location.href = '/user/reg-basic-info-2/' + user_id;
                } else {
                    console.log(res);
                }
            }
        });
    });

    LEMON.sys.setTopRight('下一步');
    window.onTopRight = function () {
        $("#next").trigger('click');
    };
</script>
<?= $this->end('script'); ?>