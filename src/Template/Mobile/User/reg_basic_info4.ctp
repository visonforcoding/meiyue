<div class="wraper fullwraper  bgff pt40">
    <div class="info-header-tips">
         <div class="closed">
            <a onclick="pass2();" class="iconfont">&#xe684;</a>
         </div>
        <h3 class="aligncenter title">完善个人信息<br />可以提高魅力值哦~</h3>
    </div>
    <div class="home_fill_basic_info home_fill_hobby change-home-info mt40">
        <form>
            <ul>
                <!--            <li>
                                <div class="home_items">
                                    <div class="home_list_l_info ">
                                        <span class="itemsname">常出没地点：</span>
                                        <i class="iconfont ico"></i>
                                    </div>
                                    <div class="home_list_r_info">
                                        <input type="text" placeholder="请输入" />
                                        <i class="iconfont r_icon">&#xe605;</i>
                                    </div>
                                </div>
                            </li>-->
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">喜欢的美食：</span>
                        </div>
                        <div class="home_list_r_info   plaintext">

                            <!-- <input name="food" type="text" placeholder="请输入" /> -->
                            <textarea name="food" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的美食"></textarea>

                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span  class="itemsname">喜欢的音乐：</span>
                           
                        </div>
                         <div class="home_list_r_info   plaintext">

                            <!-- <input name="music" type="text" placeholder="请输入" /> -->
                             <textarea name="music" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的音乐"></textarea>

                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">喜欢的电影：</span>
                          
                        </div>
                          <div class="home_list_r_info   plaintext">

                            <!-- <input name="movie" type="text" placeholder="请输入" /> -->
                            <textarea name="movie" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的电影"></textarea>

                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">喜欢的运动<br>/娱乐：</span>
                           
                        </div>
                         <div class="home_list_r_info   plaintext">

                            <!-- <input name="sport" type="text" placeholder="请输入" /> -->
                             <textarea name="sport" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入喜欢的运动/娱乐"></textarea>

                        </div>
                    </div>
                </li>
                <li  class='plaintext-box'>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">个性签名：</span>
                        </div>
                          <div class="home_list_r_info   plaintext">

                            <!-- <input name="sign" type="text" placeholder="请输入" /> -->
                              <textarea name="sign" class="plaintext-con" style="overflow-y:hidden;" onpropertychange="this.style.height=this.scrollHeight + 'px'" oninput="this.style.height=this.scrollHeight + 'px'" placeholder="请输入个性签名"></textarea>
                         </div>
                    </div>
                </li>
                <li class='edit_ability edit_ability-marks marks-line right-ico'>
                    <div class="home_items">
                            <div class="home_list_l_info"><span class="itemsname">个性标签：</span></div>
                            <div class="home_list_r_info ability-marks-box">
                                <div id="tag-container" class="r_info">
                                    <input name="tag" type="text" placeholder="请选择标签" readonly="readonly" />
                                </div>
                            </div>
                    </div>
                </li>
                <li>
                    <div class="home_items">
                        <div class="home_list_l_info ">
                            <span class="itemsname">微信号：</span>
                            <i class="iconfont ico"></i>
                        </div>
                        <div class="home_list_r_info">
                            <input name="wxid" type="text" placeholder="请输入微信号" />
                        </div>
                    </div>
                </li>
            </ul>
        </form>
    </div>
    <div class="other-info-jump">
        <a id="submit" class="color_y">填好了，进入首页 ></a>
    </div>

</div>
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<?= $this->start('script'); ?>
<script>
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


    function pass2() {
        window.location.href = '/index/find-rich-list';
    }

    $('#submit').on('tap', function () {
        if ($('#food').length > 12) {
            $.util.alert('喜欢的美食输入过长');
            return false;
        }
        if ($('#sport').length > 12) {
            $.util.alert('喜欢的美食输入过长');
            return false;
        }
        $.util.showPreloader();
        var form = $('form');
        $.util.ajax({
            data: form.serialize(),
            func: function (res) {
                if (res.status) {
                    window.location.href = '/index/find-rich-list';
                } else {
                    $.util.hidePreloader();
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