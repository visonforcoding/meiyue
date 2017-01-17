<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
    </div>
</header> -->
<link rel="stylesheet" type="text/css" href="/mobile/css/LArea.css"/>
<div class="wraper">
    <form method="post">
        <div class="home_fill_basic_info">
            <div class="items_title">
                <h3>基本资料</h3>
            </div>
            <ul>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required">
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
                        <div class="home_list_l_info required"><span class="itemsname">真</span><span class="itemsname">实</span><span class="itemsname">姓</span><span class="itemsname">名</span><i class="iconfont ico"></i></div>
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
                                <input type="text" placeholder="出生日期" readonly="readonly" />
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
                                <input type="text" id="weight" name="weight" placeholder="你的体重" readonly="readonly"/>
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
                                    <option value="55+">55+KG</option>
                                </select>
                           </div>
                        </div>
                    </div>
                </li>
                <li  class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">身</span><span class="itemsname">高</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" id="height" name="height" placeholder="你的身高" readonly="readonly"/>
                                <select name="" onchange='tochange(this)'>
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
                 <li class='bwh right-ico'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">三</span><span class="itemsname">围</span></div>
                         <div class="home_list_r_info flex flex_end">
                                <div class="home-basic-option">
                                <input  id="bwh_b" name="bwh_b" type="text" placeholder="胸围" readonly="readonly" value="<?= $user->bwh_b; ?>"/>
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
                                </div>|<div class="home-basic-option">
                                <input id="bwh_w" name="bwh_w" type="text" placeholder="腰围" value="<?= $user->bwh_w; ?>"  readonly="readonly"/>
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
                                </div>|<div class="home-basic-option">
                                <input id="bwh_h" name="bwh_h" type="text" placeholder="臀围" value="<?= $user->bwh_h; ?>" readonly="readonly"/>
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
                 <li class="start_sign right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">星</span><span class="itemsname">座</span></div>
                        <div class="home_list_r_info">
                             <div class="home-basic-option">
                                <input type="text" placeholder="你的星座" readonly="readonly"/>
                                <select name="zodiac"  onchange='tochange(this)'>
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
                <li class='right-ico'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">罩</span><span class="itemsname">杯</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" placeholder="请输入你的罩杯" readonly="readonly"/>
                                <select id="cup" name="cup"  onchange='tochange(this)'>
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
                    </div>
                </li>
                  <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">情</span><span class="itemsname">感</span><span class="itemsname">状</span><span class="itemsname">态</span></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" placeholder="你的情感状态" readonly="readonly"/>
                                <select id="state" name="state" onchange='tochange(this)'>
                                    <option value="1"  selected="selected">单身</option>
                                    <option value="2">私密</option>
                                </select>
                            </div>
                        </div>
                        </div>
                </li>
               
                 <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname short_name">家</span><span class="itemsname">乡</span></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" readonly="readonly" placeholder="请输入您的家乡" />
                            <input id="vtown" type="hidden" />
                        </div>
                    </div>
                </li>
                 <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">所</span><span class="itemsname">在</span><span class="itemsname">地</span><span class="itemsname">区</span></div>
                        <div class="home_list_r_info">
                            <input  id="city" name="city" type="text" placeholder="请输入所在地区" />
                            <input id="vcity" type="hidden" />
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业</span></div>
                        <div class="home_list_r_info">
                            <input name="profession" type="text" placeholder="请输入职业" />
                        </div>
                    </div>
                </li>
        </div>
        <!--爱好-->
        <div class="home_fill_basic_info home_fill_hobby">
            <div class="items_title">
                <h3>兴趣爱好</h3>
            </div>
            <ul>
                <li  class="plaintext-box">
                    <div class="home_items  plaintexts">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的美食</span></div>
                        <div class="home_list_r_info">
                            <!--<input id="food" name="food" type="text" placeholder="请输入美食" />-->
                            <textarea id="food" name="food" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入美食"></textarea>
                        </div>
                    </div>
                </li>
                <li  class="plaintext-box">
                    <div class="home_items plaintexts">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的运动<br>/娱乐</span></div>
                        <div class="home_list_r_info">
                            <!--<input id="sport" name="sport" type="text" placeholder="运动/娱乐" />-->
                            <textarea id="sport" name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的运动/娱乐"></textarea>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!--个性标签-->
        <div class="home_fill_basic_info home_fill_hobby">
            <div class="items_title">
                <h3>我的标签</h3>
            </div>
            <ul>
                <li class="home-basic-mark right-ico">
                    <div id="tag-container" class="home_items home-mark-box">
                        <div class="home_list_l_info"><span class="itemsname">个性标签</span></div>
                        <div class="home_list_r_info">
                            <input name="tag" type="text" placeholder="请选择标签" readonly="readonly" />
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>
<div style="height:62px;"></div>
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
<?php if ($user->gender == '2'): ?>
    <a id="submit" class="identify_footer_potion">下一步</a>
<?php else: ?>
    <a href="/index/index" class="identify_footer_potion">跳过</a>
<?php endif; ?>
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<?= $this->cell('Select::place'); ?>

<?= $this->start('script'); ?>
<script>

    function tochange(that){
         $(that).siblings().val(that.options[that.selectedIndex].text);
   }
   function inputChange(that){
         $(that).siblings().val($(that).val());
   }
  
    $('#nick').keyup(function () {
        var v = $(this).val();
        if (v.length > 6) {
            $.util.alert('昵称不要超过6个字符');
        }
    });
    $('#height,#wight').keyup(function () {
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
    // $.picker(function () {
    //     if (window.selecter == 'city') {
    //         $('#city').val(_city);
    //     } else {
    //         $('#hometown').val(_city);
    //     }
    // });
    // $('#city').on('tap', function () {
    //     window.selecter = 'city';
    //     $('.picker-modal').removeClass('modal-hide');
    // });
    // $('#hometown').on('tap', function () {
    //     window.selecter = 'hometown';
    //     $('.picker-modal').removeClass('modal-hide');
    // });
    $('#submit').on('tap', function () {
        if ($('#nick').val().length > 6) {
            $.util.alert('昵称不要超过6个字符');
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
                    window.location.href = '/user/reg-auth';
                } else {
                    console.log(res);
                }
            }
        });
    });
    function chooseTagsCallBack(tagsData) {

        var html = "";
        for (key in tagsData) {

            var item = tagsData[key];
            html += "<a class='mark'>" + item['name'] +
                    "<input type='text' name='tags[_ids][]' value='" + item['id']
                    + "' tag-name='" + item['name'] + "' hidden></a>";

        }
        $("#tag-container").html(html);

    }

    $("#tag-container").on('click', function () {
        var currentDatas = [];
        $("#tag-container").find("input").each(function () {

            currentDatas.push($(this).val());

        })
        new TagsPicker().show(chooseTagsCallBack, currentDatas);

    });
</script>
<?= $this->end('script'); ?>