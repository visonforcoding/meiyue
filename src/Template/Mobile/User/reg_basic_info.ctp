<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
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
                            <input id="nick" name="nick" type="text" placeholder="请输入昵称" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname">真</span><span class="itemsname">实</span><span class="itemsname">姓</span><span class="itemsname">名：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input id="truename" name="truename" type="text" placeholder="请输真实姓名" />
                        </div>
                    </div>
                </li>
                <li class="birthdate">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">出</span><span class="itemsname">生</span><span class="itemsname">日</span><span class="itemsname">期：</span></div>
                        <div class="home_list_r_info">
                            <input name="birthday" type="date" placeholder="请输入日期" value="2015-09-24"/>
                         </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">体</span><span class="itemsname">重：</span></div>
                        <div class="home_list_r_info">
                            <input id="width" name="weight" type="text" placeholder="您的体重" />&nbsp;kg
                            <i class="iconfont r_icon">&#xe605;</i>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info required"><span class="itemsname short_name">身</span><span class="itemsname">高：</span><i class="iconfont ico"></i></div>
                        <div class="home_list_r_info">
                            <input id="height" name="height" type="text" placeholder="您的身高" />&nbsp;cm
                            <i class="iconfont r_icon">&#xe605;</i>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">三</span><span class="itemsname">围：</span></div>
                        <div class="home_list_r_info">
                            <input type="tel" placeholder="胸围" style="width:30px;" /> | <input type="tel" placeholder="腰围" style="width:30px;" /> | <input type="tel" placeholder="臀围" style="width:30px;" />
                        </div>
                    </div>
                </li>
                 <li class="start_sign right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">星</span><span class="itemsname">座：</span></div>
                        <div class="home_list_r_info">
                                <select name="zodiac">
                                    <option value="0" selected="selected">星座</option>
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
                <li>
                    <div class="home_items  right-ico">
                        <div class="home_list_l_info"><span class="itemsname">罩</span><span class="itemsname">杯：</span></div>
                        <div class="home_list_r_info" placeholder="请输入罩杯">
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
                 <li class="emontion right-ico">
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">情</span><span class="itemsname">感</span><span class="itemsname">状</span><span class="itemsname">态：</span></div>
                        <div class="home_list_r_info">
                            <div class="select_type">
                                <select name="state">
                                    <option value="1">单身</option>
                                    <option value="2">私密</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">职</span><span class="itemsname">业：</span></div>
                        <div class="home_list_r_info">
                            <input name="profession" type="text" placeholder="请输入职业" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname short_name">家</span><span class="itemsname">乡：</span></div>
                        <div class="home_list_r_info">
                            <input id="hometown" name="hometown" type="text" placeholder="请输入家乡" readonly />
                            <i class="iconfont r_icon">&#xe605;</i>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">所</span><span class="itemsname">在</span><span class="itemsname">地</span><span class="itemsname">区：</span></div>
                        <div class="home_list_r_info">
                            <input id="city" name="city" type="text" placeholder="请输入所在地区" readonly />
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
                        <div class="home_list_l_info"><span class="itemsname">喜欢的美食：</span></div>
                        <div class="home_list_r_info">
                            <!--<input id="food" name="food" type="text" placeholder="请输入美食" />-->
                            <textarea id="food" name="food" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入美食"></textarea>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="home_items sport_items">
                        <div class="home_list_l_info"><span class="itemsname">喜欢的运动/娱乐：</span></div>
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
                <li>
                    <div id="tag-container" class="home_items">
                        <div class="home_list_l_info"><span class="itemsname">个性标签：</span></div>
                        <div class="home_list_r_info">
                            <input name="tag" type="text" placeholder="请选择" readonly="readonly" />
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>
<div style="height:62px;"></div>
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