 <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <span class="r_btn release-btn" id="submit">保存</span>
        <h1>基本信息</h1>
    </div>
</header>
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
                            <?php use Cake\I18n\Date;

                            if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <input id="nick" name="nick" type="text" placeholder="请输入昵称" value="<?= $user->nick; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">真</span><span
                                class="itemsname">实</span><span class="itemsname">姓</span><span
                                class="itemsname">名</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="truename" name="truename" type="text" placeholder="请输真实姓名" value="<?= $user->truename; ?>"/>
                        </div>
                    </div>
                </li>
                <li class="birthdate right-ico" >
                    <div class="home_items">
                        <div class="home_list_l_info required">
                            <span class="itemsname">出</span><span class="itemsname">生</span><span class="itemsname">日</span><span class="itemsname">期</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                    <input id="birthday" name="birthday" type="text" placeholder="出生日期" readonly="readonly" value="<?= ($user->birthday)?$user->birthday:new Date('1991-1-1'); ?>" required='required' />
                                    <input type="date"  onchange='inputChange(this)' />
                            </div> 

                        </div>
                    </div>
                </li>
               
                <li  class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">体</span><span class="itemsname">重</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" placeholder="你的体重" readonly="readonly" value="<?= isset($user->weight)?$user->weight:'40-'; ?>KG"/>
                                <select id="weight" name="weight" onchange='tochange(this)'>
                                    <option value="40-" <?= (isset($user->weight) && $user->weight == '40-')?'selected':''; ?>>40-KG</option>
                                    <option value="40" <?= (isset($user->weight) && $user->weight == '40')?'selected':''; ?>>40KG</option>
                                    <option value="41" <?= (isset($user->weight) && $user->weight == '41')?'selected':''; ?>>41KG</option>
                                    <option value="42" <?= (isset($user->weight) && $user->weight == '42')?'selected':''; ?>>42KG</option>
                                    <option value="43" <?= (isset($user->weight) && $user->weight == '43')?'selected':''; ?>>43KG</option>
                                    <option value="44" <?= (isset($user->weight) && $user->weight == '44')?'selected':''; ?>>44KG</option>
                                    <option value="45" <?= (isset($user->weight) && $user->weight == '45')?'selected':''; ?>>45KG</option>
                                    <option value="46" <?= (isset($user->weight) && $user->weight == '46')?'selected':''; ?>>46KG</option>
                                    <option value="47" <?= (isset($user->weight) && $user->weight == '47')?'selected':''; ?>>47KG</option>
                                    <option value="48" <?= (isset($user->weight) && $user->weight == '48')?'selected':''; ?>>48KG</option>
                                    <option value="49" <?= (isset($user->weight) && $user->weight == '49')?'selected':''; ?>>49KG</option>
                                    <option value="50" <?= (isset($user->weight) && $user->weight == '50')?'selected':''; ?>>50KG</option>
                                    <option value="51" <?= (isset($user->weight) && $user->weight == '51')?'selected':''; ?>>51KG</option>
                                    <option value="52" <?= (isset($user->weight) && $user->weight == '52')?'selected':''; ?>>52KG</option>
                                    <option value="53" <?= (isset($user->weight) && $user->weight == '53')?'selected':''; ?>>53KG</option>
                                    <option value="54" <?= (isset($user->weight) && $user->weight == '54')?'selected':''; ?>>54KG</option>
                                    <option value="55" <?= (isset($user->weight) && $user->weight == '55')?'selected':''; ?>>55KG</option>
                                    <option value="55+" <?= (isset($user->weight) && $user->weight == '55+')?'selected':''; ?>>55+KG</option>
                                </select>
                           </div>
                        </div>
                    </div>
                </li>
                <li  class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">身</span><span
                                class="itemsname">高</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" placeholder="你的身高" value="<?= isset($user->height)?$user->height:155; ?>CM" readonly="readonly"/>
                                <select id="height" name="height" onchange='tochange(this)'>
                                    <?php for($i= 155;$i<=200;$i ++): ?>
                                        <option value="<?= $i; ?>" <?= (isset($user->height) && $user->height == $i)?'selected':''; ?>><?= $i; ?>CM</option>
                                    <?php endfor; ?>
                                </select>
                                </div>
                        </div>
                    </div>
                </li>
                <?php if($user->gender == 2): ?>
                    <li class='bwh right-ico'>
                        <div class="home_items">
                            <div class="home_list_l_info required"><span class="itemsname">三</span><span class="itemsname">围</span>
                                <i class="iconfont ico"></i>
                            </div>
                            <div class="home_list_r_info flex flex_end">
                                <div class="home-basic-option">
                                <input id="bwh_b" name="bwh_b" type="text" placeholder="胸围" readonly="readonly" value="<?= $user->bwh_b; ?>"/>
                                <select onchange='inputChange(this)'>
                                    <?php for($i= 80;$i<=89;$i ++): ?>
                                        <option value="<?= $i; ?>" <?= (isset($user->bwh_b) && $user->bwh_b == $i)?'selected':''; ?>><?= $i; ?></option>
                                    <?php endfor; ?>
                                    <option value="90+">90+</option>
                                </select>
                                </div>|<div class="home-basic-option">
                                <input id="bwh_w" name="bwh_w" type="text" placeholder="腰围" value="<?= $user->bwh_w; ?>"  readonly="readonly"/>
                                <select onchange='inputChange(this)'>
                                    <?php for($i= 60;$i<=69;$i ++): ?>
                                        <option value="<?= $i; ?>" <?= (isset($user->bwh_w) && $user->bwh_w == $i)?'selected':''; ?>><?= $i; ?></option>
                                    <?php endfor; ?>
                                    <option value="70+">70+</option>
                                </select>
                                </div>|<div class="home-basic-option">
                                <input id="bwh_h" name="bwh_h" type="text" placeholder="臀围" value="<?= $user->bwh_h; ?>" readonly="readonly"/>
                                <select onchange='inputChange(this)'>
                                    <?php for($i= 80;$i<=89;$i ++): ?>
                                        <option value="<?= $i; ?>" <?= (isset($user->bwh_h) && $user->bwh_h == $i)?'selected':''; ?>><?= $i; ?></option>
                                    <?php endfor; ?>
                                    <option value="90+">90+</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                 <li class="start_sign  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">星</span><span class="itemsname">座</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <div class="home-basic-option">
                                <input type="text" placeholder="你的星座" readonly="readonly" value="<?= isset($user->zodiac)?Zodiac::getStr($user->zodiac):'请选择星座'; ?>"/>
                                <select id="zodiac" name="zodiac" onchange='tochange(this)'>
                                    <option value="0" <?= isset($user->zodiac)?'':'selected'; ?>>请选择星座</option>
                                    <option value="1" <?= (isset($user->zodiac) && $user->zodiac == 1)?'selected':''; ?>>白羊座</option>
                                    <option value="2" <?= (isset($user->zodiac) && $user->zodiac ==2)?'selected':''; ?>>金牛座</option>
                                    <option value="3" <?= (isset($user->zodiac) && $user->zodiac ==3)?'selected':''; ?>>双子座</option>
                                    <option value="4" <?= (isset($user->zodiac) && $user->zodiac == 4)?'selected':''; ?>>巨蟹座</option>
                                    <option value="5" <?= (isset($user->zodiac) && $user->zodiac == 5)?'selected':''; ?>>狮子座</option>
                                    <option value="6" <?= (isset($user->zodiac) && $user->zodiac == 6)?'selected':''; ?>>处女座</option>
                                    <option value="7" <?= (isset($user->zodiac) && $user->zodiac == 7)?'selected':''; ?>>天秤座</option>
                                    <option value="8" <?= (isset($user->zodiac) && $user->zodiac == 8)?'selected':''; ?>>天蝎座</option>
                                    <option value="9" <?= (isset($user->zodiac) && $user->zodiac == 9)?'selected':''; ?>>射手座</option>
                                    <option value="10" <?= (isset($user->zodiac) && $user->zodiac == 10)?'selected':''; ?>>摩羯座</option>
                                    <option value="11" <?= (isset($user->zodiac) && $user->zodiac == 11)?'selected':''; ?>>水瓶座</option>
                                    <option value="12" <?= (isset($user->zodiac) && $user->zodiac == 12)?'selected':''; ?>>双鱼座</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <?php if($user->gender == 2): ?>
                    <li class="start_sign  right-ico">
                        <div class="home_items">
                            <div class="home_list_l_info required"><span class="itemsname">罩</span><span class="itemsname">杯</span>
                                <i class="iconfont ico"></i>
                            </div>
                            <div class="home_list_r_info">
                                 <div class="home-basic-option">
                                    <input type="text" placeholder="你的罩杯" readonly="readonly" value="<?= $user->cup; ?>"/>
                                    <select id="cup" name="cup"  onchange='tochange(this)'>
                                        <option value="0">选罩杯</option>
                                        <option value="A" <?= (isset($user->cup) && $user->cup == 'A')?'selected':''; ?>>A</option>
                                        <option value="B" <?= (isset($user->cup) && $user->cup == 'B')?'selected':''; ?>>B</option>
                                        <option value="C" <?= (isset($user->cup) && $user->cup == 'C')?'selected':''; ?>>C</option>
                                        <option value="D" <?= (isset($user->cup) && $user->cup == 'D')?'selected':''; ?>>D</option>
                                        <option value="E" <?= (isset($user->cup) && $user->cup == 'E')?'selected':''; ?>>E</option>
                                        <option value="F" <?= (isset($user->cup) && $user->cup == 'F')?'selected':''; ?>>F</option>
                                        <option value="G" <?= (isset($user->cup) && $user->cup == 'G')?'selected':''; ?>>G</option>
                                        <option value="H" <?= (isset($user->cup) && $user->cup == 'H')?'selected':''; ?>>H</option>
                                    </select>
                                   </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                 <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">情</span><span
                                class="itemsname">感</span><span class="itemsname">状</span><span
                                class="itemsname">态</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                             <div class="home-basic-option">
                                    <input type="text" placeholder="你的情感状态" readonly="readonly" value="<?= (isset($user->state) && $user->state == 1)?'单身':'私密'; ?>"/>
                                    <select id="state" name="state" onchange='tochange(this)'>
                                        <option value="1" <?= (isset($user->state) && $user->state == 1)?'selected':'';?>>单身</option>
                                        <option value="2" <?= (isset($user->state) && $user->state == 2)?'selected':'';?>>私密</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                </li>
               
                <li class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">家</span><span
                                class="itemsname">乡</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" readonly="readonly" placeholder="请输入您的家乡"  value="<?= $user->hometown; ?>"/>
                            <input id="vtown" type="hidden" />
                        </div>
                    </div>
                </li>
                <li  class="right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">所</span><span
                                class="itemsname">在</span><span class="itemsname">地</span><span
                                class="itemsname">区</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input  id="city" name="city" type="text" placeholder="请输入所在地区" value="<?= $user->city; ?>" readonly="readonly"/>
                            <input id="vcity" type="hidden" />
                        </div>
                    </div>
                </li>
                 <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">职</span><span class="itemsname">业</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <input id="profession" name="profession" type="text" placeholder="请输入职业" value="<?= $user->profession; ?>"/>
                        </div>
                    </div>
                </li>
                 <li class='plaintext-box'>
                    <div class="home_items">
                       <div class="home_list_l_info"><span class="itemsname">工</span><span
                                class="itemsname">作</span><span class="itemsname">经</span><span
                                class="itemsname">历</span>
                           </span>
                        </div>
                        <div class="home_list_r_info  plaintext">
                            <textarea name="career" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入工作经历"><?= $user->career; ?></textarea>
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
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">常出没地点</span></div>
                        <div class="home_list_r_info" style='width:auto;'>
                            <input id="place" name="place" type="text" placeholder="请输入地点" value="<?= $user->place; ?>"/>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的美食</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea  id="food" name="food" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入美食"><?= $user->food; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的音乐</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea  id="music" name="music" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入音乐"><?= $user->music; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的电影</span></div>
                        <div class="home_list_r_info  plaintext">
                              <textarea id="movie" name="movie" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入电影"><?= $user->movie; ?></textarea>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items sport_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的运动<br>/娱乐</span></div>
                        <div class="home_list_r_info   plaintext">
                             <textarea id="sport" name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入运动/娱乐"><?= $user->sport; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">个性签名</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea id="sign" name="sign" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入个性签名"><?= $user->sign; ?></textarea>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!--个性标签-->
        <?php if($user->gender == 2): ?>
            <div class="home_fill_basic_info home_fill_hobby">
                <div class="items_title">
                    <h3>我的标签</h3>
                </div>
                <ul>
                    <li class="home-basic-mark right-ico">
                        <div id="tag-container" class="home_items home-mark-box">
                            <?php foreach($user->tags as $tag): ?>
                                <a class='mark'><?= $tag['name']; ?><input type='text' name='tags[_ids][]' value='<?= $tag['id']; ?>' tag-name='<?= $tag['name']; ?>' hidden></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <!--微信号-->
        <?php if($user->gender == 2): ?>
            <div class="home_fill_basic_info ">
                <div class="items_title">
                    <h3>我的微信 <i>（用户查看你的微信你会有收入哦）</i></h3>
                </div>
                <ul>
                    <li class='home_fill_hobby'>
                        <div class="home_items">
                            <div class="home_list_l_info"><span class="itemsname">微信号：</span></div>
                            <div class="home_list_r_info">
                                <input name="wxid" type="text" placeholder="请输入" value="<?= $user->wxid; ?>"/>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="isDisplay">
                    <input id="show-wx" name="wx_ishow" value="1" hidden>
                    <span class="displaybtn <?= ($user->wx_ishow == 1)?'choose':''; ?>"><i class="iconfont">&#xe64c;</i>展示赚钱</span>
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<script src="/mobile/js/LArea.js" type="text/javascript" ></script>
<script src="/mobile/js/LAreaData1.js" type="text/javascript"></script>
<!--<a id="submit" class="identify_footer_potion">提交</a>-->
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<?= $this->start('script'); ?>
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

    function tochange(that){
         $(that).siblings().val(that.options[that.selectedIndex].text);
   }
   function inputChange(that){
         $(that).siblings().val($(that).val());
   }
    var originNick = '<?= $user->nick; ?>';
    $('#nick').keyup(function () {
        var v = $(this).val();
        if (v.length > 5) {
            $(this).val(v.substr(0, 5));
        }
    });
    $('#nick').blur(function () {
        var v = $(this).val();
        if(v.length == 0) {
            $(this).val(originNick);
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
        if(v < 0) {
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
    $('#submit').on('click', function () {
        submitForm();
    });

    function submitForm() {
        <?php if($user->gender == 2): ?>
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
        if ($('#height').val() == '0') {
            $.util.alert('身高必填');
            return false;
        }
        if ($('#weight').val() == '0') {
            $.util.alert('体重必填');
            return false;
        }
        if (($('#bwh_b').val() == '0') || ($('#bwh_w').val() == '0') || ($('#bwh_h').val() == '0')) {
            $.util.alert('三围必填');
            return false;
        }
        if ($("#cup").val() == '0') {
            $.util.alert('罩杯必填');
            return false;
        }
        if ($("#state").val() == '0') {
            $.util.alert('情感状态必填');
            return false;
        }
        if ($("#zodiac").val() == '0') {
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
        <?php endif; ?>
        var form = $('form');
        $.util.showPreloader();
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                $.util.hidePreloader();
                $.util.alert(res.msg);
                if (res.status) {
                    setTimeout(function() {
                        window.location.href = '/userc/edit-info';
                    }, 1000);
                }
            }
        });
    }

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


    $('.displaybtn').on('click', function() {
        if($(this).hasClass('choose')) {
            $(this).removeClass('choose');
            $('#show-wx').val('0');
        } else {
            $(this).addClass('choose');
            $('#show-wx').val('1');
        }
    });

    var lastDate = $('#birthday').val();
    $('#birthday').on('change', function(){
        var date = $(this).val();
        if(date.length == 0) {
            $(this).val(lastDate);
        }
        else{
            lastDate = date;
        }
    });

    LEMON.sys.setTopRight('保存')
    window.onTopRight = function () {
        submitForm();
    }
</script>
<?= $this->end('script'); ?>