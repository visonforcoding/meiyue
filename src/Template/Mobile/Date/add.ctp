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
                            <input id="skill-id-input" name="skill_id" type="text" placeholder="请选择约会主题" value=""
                                   hidden="true"/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input name='title' type="text" value="" placeholder="例：海岸城西餐厅，美女在等你"/>
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
                            <input name="site" type="text" readonly="true" placeholder="选择约会地点" value="老地方测试"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input name="price" id="cost-btn" type="number" readonly="true" placeholder="选择约会价格" value="300"/>
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
                    <textarea name="description" placeholder="您的说明将是屌丝买单的动力"></textarea>
                </div>
            </div>
            <input type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input type="text" name="status" value="2" hidden>
        </form>
    </div>
</div>
<!--弹出层-->
<!--技能选择框-->
<?= $this->cell('Date::skillsView', ['skills-select-view']); ?>
<!--价格选择框-->
<?= $this->cell('Date::costsView', ['costs-select-view']); ?>
<!--标签选择框-->
<?= $this->cell('Date::tagsView', ['tags-select-view']); ?>
<!--日期时间选择器-->
<?= $this->element('checkdate'); ?>

<script>

    $("#cancel-btn").on('click', function () {

        history.back();

    });

    //约会主题选择回调函数
    function chooseSkillCallBack(name, value) {

        $("#skill-id-input").val(value);
        $("#show-skill-name").val(name);

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


    $("#time").on('click', function () {

        new mydateTimePicker().show(choosedateCallBack);

    });


    $("#release-btn").on('click', function () {

        $date_time = $("#time").val();
        if(!$date_time) {

            alert("请选择约会时间!");
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

                        alert(res.msg);
                        window.location.href = '/date/index';

                    } else {

                        alert(res.msg);

                    }
                }
            }
        });

    })

</script>