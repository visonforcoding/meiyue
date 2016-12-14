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
                            <i class="iconfont ico"></i>
                        </div>
                        <div class="home_list_r_info">
                            <input name="nick" type="text" placeholder="请输入昵称" value="<?= $user->nick; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">真</span><span
                                class="itemsname">实</span><span class="itemsname">姓</span><span
                                class="itemsname">名：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input name="truename" type="text" placeholder="请输真实姓名" value="<?= $user->truename; ?>"/>
                        </div>
                    </div>
                </li>
                <li class="birthdate">
                    <div class="home_items">
                        <div class="home_list_l_info">
                            <span class="itemsname">出</span>
                            <span class="itemsname">生</span>
                            <span class="itemsname">日</span>
                            <span class="itemsname">期：</span>
                        </div>
                        <div class="home_list_r_info">
                            <div class="checkdate">
                                <input id="birthday" name="birthday" type="text" placeholder="请输入日期" value="<?= $user->birthday; ?>" />
                            </div>
                        </div>
                    </div>
                </li>
               
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重：</span>
                        </div>
                        <div class="home_list_r_info">
                            <input name="weight" type="text" placeholder="您的体重" value="<?= $user->weight; ?>"/>&nbsp;KG
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">身</span><span
                                class="itemsname">高：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input name="height" type="text" placeholder="您的身高" value="<?= $user->height; ?>"/>&nbsp;CM
                        </div>
                    </div>
                </li>
                <li class='bwh'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">三</span><span class="itemsname">围：</span>
                        </div>
                        <div class="home_list_r_info">
                            <input type="tel" placeholder="胸围" style="width:30px;" /> | 
                            <input type="tel" placeholder="腰围" style="width:30px;" /> | 
                            <input type="tel" placeholder="臀围" style="width:30px;" />
                        </div>
                    </div>
                </li>
                 <li class="start_sign  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">星</span><span class="itemsname">座：</span>
                        </div>
                        <div class="home_list_r_info">
                            <select name="zodiac">
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
                <li class="start_sign  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">罩</span><span class="itemsname">杯：</span>
                        </div>
                        <div class="home_list_r_info">
                                <select name="cup">
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
                 <li class="emontion  right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">情</span><span
                                class="itemsname">感</span><span class="itemsname">状</span><span
                                class="itemsname">态：</span></div>
                        <div class="home_list_r_info">
                                <select name="state">
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
                        <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业：</span>
                        </div>
                        <div class="home_list_r_info">
                            <input name="profession" type="text" placeholder="请输入职业" value="<?= $user->profession; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname short_name">家</span><span
                                class="itemsname">乡：</span></div>
                        <div class="home_list_r_info">
                            <input name="hometown" type="text" placeholder="请输入家乡" value="<?= $user->hometown; ?>"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">所</span><span
                                class="itemsname">在</span><span class="itemsname">地</span><span
                                class="itemsname">区：</span></div>
                        <div class="home_list_r_info">
                            <input name="city" type="text" placeholder="请输入所在地区" value="<?= $user->city; ?>"/>
                        </div>
                    </div>
                </li>
                 <li class='plaintext-box'>
                    <div class="home_items">
                       <div class="home_list_l_info"><span class="itemsname">工</span><span
                                class="itemsname">作</span><span class="itemsname">经</span><span
                                class="itemsname">历：</span>
                        </div>
                        <div class="home_list_r_info  plaintext">
                           <!--  <input name="sign" type="text" placeholder="个性签名" value=""/> -->
                            <div class="plaintext-con" contenteditable="true"><?= $user->career; ?></div>
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
                            <input name="place" type="text" placeholder="请输入地点" value="<?= $user->place; ?>"/>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的美食：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <!-- <input name="food" type="text" placeholder="请输入美食" value="<?= $user->food; ?>"/> -->
                            <div class="plaintext-con" contenteditable="true">请输入美食</div>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的音乐：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <!-- <input name="music" type="text" placeholder="请输入音乐" value="<?= $user->music; ?>"/> -->
                              <div class="plaintext-con" contenteditable="true">请输入音乐</div>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的电影：</span></div>
                        <div class="home_list_r_info  plaintext">
                            <!-- <input name="movie" type="text" placeholder="请输入电影" value="<?= $user->movie; ?>"/> -->
                              <textarea  class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'">请输入电影</textarea>
                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items sport_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的运动<br>/娱乐：</span></div>
                        <div class="home_list_r_info   plaintext">
                            <!-- <input name="sport" type="text" placeholder="运动/娱乐" value="<?= $user->sport; ?>"/> -->
                             <!-- <div class="plaintext-con" contenteditable="true">请输入喜欢的运动/娱乐</div> -->
                             <textarea  class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'">请输入内容</textarea>
                        </div>
                    </div>
                </li>
                <li class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">个性签名：</span></div>
                        <div class="home_list_r_info  plaintext">
                           <!--  <input name="sign" type="text" placeholder="个性签名" value="<?= $user->sign; ?>"/> -->
                            <div class="plaintext-con" contenteditable="true">个性签名</div>
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
                          <?php foreach($user->tags as $tag): ?>
                            <a class='mark'><?= $tag['name']; ?><input type='text' name='tags[_ids][]' value='<?= $tag['id']; ?>' tag-name='<?= $tag['name']; ?>' hidden></a>
                            <?php endforeach; ?>
                    </div>
                </li>
            </ul>
        </div>
        <!--微信号-->
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
    </form>
</div>

<div style="height:62px;"></div>
<!--<a id="submit" class="identify_footer_potion">提交</a>-->
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<?= $this->start('script'); ?>
<script>
    $('#submit').on('tap', function () {
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                console.log(res.datas);
                if (res.status) {
                    window.location.href = '/userc/edit-info';
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


    $('.displaybtn').on('click', function() {

        if($(this).hasClass('choose')) {

            $(this).removeClass('choose');
            $('#show-wx').val('0');

        } else {

            $(this).addClass('choose');
            $('#show-wx').val('1');

        }

    });

    LEMON.sys.back('/userc/edit-info');
    LEMON.sys.setTopRight('保存')
    window.onTopRight = function () {
        $("#submit").trigger('click');
    }
</script>
<?= $this->end('script'); ?>