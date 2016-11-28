<?php
    use Cake\I18n\Time;
?>
<header>
    <div class="header">
        <span class="l_btn" id="cancel-btn">取消</span>
        <span class="r_btn" id="release-btn">发布</span>
    </div>
</header>
<div class="wraper">
    <div class="edit_date_box">
        <form>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会主题</h3>
                        <div class="edit_r_con">
                            <input id="show-skill-name" type="text" placeholder="请选择约会主题" value="" readonly="true"/>
                            <input id="skill-id-input" name="user_skill_id" type="text" placeholder="请选择约会主题" value=""
                                   hidden="true"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input id="title" name='title' type="text" value="" placeholder="例：海岸城西餐厅，美女在等你"/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会时间</h3>
                        <div class="edit_r_con">
                            <input id="time" type="text" readonly="true"  value="" placeholder="请选择约会时间" />
                            <input id="start-time" name="start_time" type="text" readonly="true" hidden value=""/>
                            <input id="end-time" name="end_time" type="text" readonly="true" hidden value=""/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会地点</h3>
                        <div class="edit_r_con">
                            <input id="site" name="site" type="text" readonly="true" placeholder="选择约会地点" value="老地方测试"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input id="cost-btn" type="text" readonly="true" placeholder="无需手动填写" value=""/>
                            <input id="cost-input" name="price" type="number" readonly="true" value="" hidden/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40">
                <li>
                    <div class="edit_date_items flex flex_justify marks_edit">
                        <span class="edit_l_con">个人标签</span>
                        <div class="edit_r_con edit_r_marks" id="tag-container">
                            <!--标签容器-->
                        </div>
                    </div>
                </li>
            </ul>
            <div class="mt40 inner edit_date_desc">
                <h3 class="title">约会说明</h3>
                <div class="text_con">
                    <textarea id="description" name="description" placeholder="您的说明将是屌丝买单的动力"></textarea>
                </div>
            </div>
            <input id="user-id" type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input id="status" type="text" name="status" value="2" hidden>
        </form>
    </div>
</div>
<!--弹出层-->
<!--技能选择框-->
<?= $this->cell('Date::skillsView', ['user_id' => $user->id]); ?>
<!--价格选择框-->
<?= $this->cell('Date::costsView'); ?>
<!--标签选择框-->
<?= $this->cell('Date::tagsView'); ?>
<!--日期时间选择器-->
<?= $this->element('checkdate'); ?>

<script>

    restoreDatas();

    $("#cancel-btn").on('click', function () {

        history.back();

    });

    //约会主题选择回调函数
    function chooseSkillCallBack(userSkill) {

        $("#skill-id-input").val(userSkill['id']);
        $("#show-skill-name").val(userSkill['skill_name']);
        $('#cost-btn').val(userSkill['cost'] + " 美币/小时");
        $('#cost-input').val(userSkill['cost']);

    }

    $("#show-skill-name").on('click', function () {

        new skillsPicker().show(chooseSkillCallBack);

    });


    //标签选择回调函数
    function chooseTagsCallBack(tagsData) {

        var html = "";
        for(key in tagsData) {

            var item = tagsData[key];
            html += "<a class='mark'>" + item['name'] +
                "<input type='text' name='tags[_ids][]' value='" + item['id']
                + "' tag-name='"+ item['name'] +"' hidden></a>";

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


    //日期选择回调函数
    function choosedateCallBack(start_datetime, end_datetime) {

        var time_tmpstart = (start_datetime).split(" ");
        var time_tmpend = (end_datetime).split(" ");
        var year_month_date = time_tmpstart[0];
        var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
        var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
        $("#time").val(year_month_date + " " + start_hour_second + "~" + end_hour_second);
        $("#start-time").val(start_datetime);
        $("#end-time").val(end_datetime);

    }

    var dPicker = new mydateTimePicker();
    dPicker.init(choosedateCallBack);
    $("#time").on('click', function () {
        dPicker.show();
    });


    $("#release-btn").on('click', function () {

        $date_time = $("#time").val();
        if(!$date_time) {
            $.util.alert("请选择约会时间!");
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/date/add',
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {
                        $.util.alert(res.msg);
                        window.location.href = '/date/index';
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });
    })


    //点击跳转到选择地址的页面并将原数据保存到cookie中
    $('#site').on('click', function () {

        var tags = {};
        $('#tag-container input').each(function(){
            var tag_id = $(this).val();
            var tag_name = $(this).attr('tag-name');
            tags[tag_name] = tag_id;
        });
        var datas = {};
        datas['show-skill-name'] = $('#show-skill-name').val();
        datas['skill-id-input'] = $('#skill-id-input').val();
        datas['title'] = $('#title').val();
        datas['time'] = $('#time').val();
        datas['start-time'] = $('#start-time').val();
        datas['end-time'] = $('#end-time').val();
        datas['site'] = $('#site').val();
        datas['cost-btn'] = $('#cost-btn').val();
        datas['tags'] = tags;
        datas['description'] = $('#description').val();
        datas['user-id'] = $('#user-id').val();
        datas['status'] = $('#status').val();
        $.util.setCookie('date_add_datas_keeper', JSON.stringify(datas));

    })


    //将cookie中数据重现页面
    function restoreDatas() {
        var datas = $.util.getCookie('date_add_datas_keeper');
        if(datas) {
            var datas = JSON.parse(datas);
            for(key in datas) {
                if('tags' != key) {
                    $("#" + key).val(datas[key]);
                }
            }
            var html = '';
            for(tag_key in datas['tags']) {
                html += "<a class='mark'>" + tag_key +
                    "<input type='text' name='tags[_ids][]' value='" + datas['tags'][tag_key]
                    + "' tag-name='"+ tag_key +"' hidden></a>";
            }
            $("#tag-container").html(html);
            $.util.setCookie('date_add_datas_keeper', '');
        }
    }
    LEMON.sys.setTopRight('发布');
    window.onTopRight = function () {
        window.location.href = '';
    }
</script>