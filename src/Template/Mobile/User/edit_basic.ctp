<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <span class="r_btn release-btn" id="submit">保存</span>
        <h1>基本信息</h1>
    </div>
</header>
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
                            <span class="itemsname">昵</span><span class="itemsname">称：</span>
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
                                class="itemsname">名：</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="truename" name="truename" type="text" placeholder="请输真实姓名" value="<?= $user->truename; ?>"/>
                        </div>
                    </div>
                </li>
                <li class="birthdate">
                    <div class="home_items">
                        <div class="home_list_l_info required">
                            <span class="itemsname">出</span>
                            <span class="itemsname">生</span>
                            <span class="itemsname">日</span>
                            <span class="itemsname">期：</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <div class="checkdate">
                                <input id="birthday" name="birthday" type="date" placeholder="请输入日期" value="<?= ($user->birthday)?$user->birthday:new Date('1991-1-1'); ?>" required="required"/>
                            </div>
                        </div>
                    </div>
                </li>
               
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">体</span><span class="itemsname">重：</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <input id="weight" name="weight" type="text" placeholder="您的体重" value="<?= $user->weight; ?>"/>&nbsp;KG
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">身</span><span
                                class="itemsname">高：</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="height" name="height" type="text" placeholder="您的身高" value="<?= $user->height; ?>"/>&nbsp;CM
                        </div>
                    </div>
                </li>
                <?php if($user->gender == 2): ?>
                    <li class='bwh'>
                        <div class="home_items">
                            <div class="home_list_l_info required"><span class="itemsname">三</span><span class="itemsname">围：</span>
                                <i class="iconfont ico"></i>
                            </div>
                            <div class="home_list_r_info">
                                <input id="bwh_b" name="bwh_b" type="tel" placeholder="胸围" style="width:30px;" value="<?= $user->bwh_b; ?>"/> |
                                <input id="bwh_w" name="bwh_w" type="tel" placeholder="腰围" style="width:30px;" value="<?= $user->bwh_w; ?>" /> |
                                <input id="bwh_h" name="bwh_h" type="tel" placeholder="臀围" style="width:30px;" value="<?= $user->bwh_h; ?>" />
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                 <li class="start_sign  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">星</span><span class="itemsname">座：</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <select id="zodiac" name="zodiac">
                                    <option value="0">选星座</option>
                                    <option value="1" <?= ($user->zodiac == 1)?'selected':''; ?>>白羊座</option>
                                    <option value="2" <?= ($user->zodiac ==2)?'selected':''; ?>>金牛座</option>
                                    <option value="3" <?= ($user->zodiac ==3)?'selected':''; ?>>双子座</option>
                                    <option value="4" <?= ($user->zodiac == 4)?'selected':''; ?>>巨蟹座</option>
                                    <option value="5" <?= ($user->zodiac == 5)?'selected':''; ?>>狮子座</option>
                                    <option value="6" <?= ($user->zodiac == 6)?'selected':''; ?>>处女座</option>
                                    <option value="7" <?= ($user->zodiac == 7)?'selected':''; ?>>天秤座</option>
                                    <option value="8" <?= ($user->zodiac == 8)?'selected':''; ?>>天蝎座</option>
                                    <option value="9" <?= ($user->zodiac == 9)?'selected':''; ?>>射手座</option>
                                    <option value="10" <?= ($user->zodiac == 10)?'selected':''; ?>>摩羯座</option>
                                    <option value="11" <?= ($user->zodiac == 11)?'selected':''; ?>>水瓶座</option>
                                    <option value="12" <?= ($user->zodiac == 12)?'selected':''; ?>>双鱼座</option>
                                </select>
                        </div>
                    </div>
                </li>
                <?php if($user->gender == 2): ?>
                    <li class="start_sign  right-ico">
                        <div class="home_items">
                            <div class="home_list_l_info required"><span class="itemsname">罩</span><span class="itemsname">杯：</span>
                                <i class="iconfont ico"></i>
                            </div>
                            <div class="home_list_r_info">
                                <select id="cup" name="cup">
                                    <option value="A" <?= ($user->cup == 'A')?'selected':''; ?>>A</option>
                                    <option value="B" <?= ($user->cup == 'B')?'selected':''; ?>>B</option>
                                    <option value="C" <?= ($user->cup == 'C')?'selected':''; ?>>C</option>
                                    <option value="D" <?= ($user->cup == 'D')?'selected':''; ?>>D</option>
                                    <option value="E" <?= ($user->cup == 'E')?'selected':''; ?>>E</option>
                                    <option value="F" <?= ($user->cup == 'F')?'selected':''; ?>>F</option>
                                    <option value="G" <?= ($user->cup == 'G')?'selected':''; ?>>G</option>
                                </select>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                 <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">情</span><span
                                class="itemsname">感</span><span class="itemsname">状</span><span
                                class="itemsname">态：</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                                <select id="state" name="state">
                                    <option value="1" <?= ($user->state == 1)?'selected':'';?>>单身</option>
                                    <option value="2" <?= ($user->state == 2)?'selected':'';?>>恋爱</option>
                                    <option value="3" <?= ($user->state == 3)?'selected':'';?>>已婚</option>
                                    <option value="4" <?= ($user->state == 4)?'selected':'';?>>离异</option>
                                </select>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">职</span><span class="itemsname">业：</span>
                            <?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?>
                        </div>
                        <div class="home_list_r_info">
                            <input id="profession" name="profession" type="text" placeholder="请输入职业" value="<?= $user->profession; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">家</span><span
                                class="itemsname">乡：</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" placeholder="请输入家乡" value="<?= $user->hometown; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">所</span><span
                                class="itemsname">在</span><span class="itemsname">地</span><span
                                class="itemsname">区：</span><?php if($user->gender == 2): ?><i class="iconfont ico"></i><?php endif; ?></div>
                        <div class="home_list_r_info">
                            <input id="city" name="city" type="text" placeholder="请输入所在地区" value="<?= $user->city; ?>"/>
                        </div>
                    </div>
                </li>
                 <li class='plaintext-box'>
                    <div class="home_items">
                       <div class="home_list_l_info"><span class="itemsname">工</span><span
                                class="itemsname">作</span><span class="itemsname">经</span><span
                                class="itemsname">历：</span>
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
                        <div class="home_list_l_info"><span class="itemsname">常出没地点：</span></div>
                        <div class="home_list_r_info">
                            <input id="place" name="place" type="text" placeholder="请输入地点" value="<?= $user->place; ?>"/>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的美食：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea  id="food" name="food" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入美食"><?= $user->food; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的音乐：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea  id="music" name="music" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入音乐"><?= $user->music; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的电影：</span></div>
                        <div class="home_list_r_info  plaintext">
                              <textarea id="movie" name="movie" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入电影"><?= $user->movie; ?></textarea>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items sport_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的运动<br>/娱乐：</span></div>
                        <div class="home_list_r_info   plaintext">
                             <textarea id="sport" name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的运动/娱乐"><?= $user->sport; ?></textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">个性签名：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <textarea id="sign" name="sign" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="个性签名"><?= $user->sign; ?></textarea>
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

<div style="height:62px;"></div>
<!--<a id="submit" class="identify_footer_potion">提交</a>-->
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<?= $this->start('script'); ?>
<script>
    var originNick = '<?= $user->nick; ?>';
    $('#nick').keyup(function () {
        var v = $(this).val();
        if (v.length > 5) {
            $(this).val(v.substr(0, 5));
        }
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
        <?php if($user->gender == 2): ?>
        if(($('#birthday').val()).length == 0) {
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
        if((!$('#bwh_b').val())&&(!$('#bwh_w').val())&&(!$('#bwh_h').val())) {
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
        if (!$("#hometown").val()) {
            $.util.alert('家乡必填');
            return false;
        }
        if (!$("#city").val()) {
            $.util.alert('所在地区必填');
            return false;
        }
        if (!$("#profession").val()) {
            $.util.alert('职业未填写');
            return false;
        }
        <?php endif; ?>
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                $.util.alert(res.msg);
                if (res.status) {
                    setTimeout(function() {
                        window.location.href = '/userc/edit-info';
                    }, 1000);
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
        $("#submit").trigger('click');
    }
</script>
<?= $this->end('script'); ?>