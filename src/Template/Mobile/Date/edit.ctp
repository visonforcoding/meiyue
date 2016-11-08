<header>
    <div class="header">
        <span class="l_btn cancel-btn">取消</span>
        <span class="r_btn release-btn" date-id="<?= $date['id']?>">重新发布</span>
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
                            <input id="show-skill-name" type="text" value="<?= $date['skill']['name'] ?>" readonly/>
                            <input id="skill-id-input" type="text" name="skill_id" value="<?= $date['skill']['id'] ?>" hidden>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会标题</h3>
                        <div class="edit_r_con">
                            <input type="text" name="title" value="<?= $date['title'] ?>"/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40 outerblock">
                <li>
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会时间</h3>
                        <div class="edit_r_con">
                            <input id="time" type="text" value="<?= getFormateDT($date['start_time'], $date['end_time']) ?>" readonly />
                            <input id="start-time" type="text" name="start_time" value="<?= $date['start_time'] ?>" hidden/>
                            <input id="end-time" type="text" name="end_time" value="<?= $date['end_time'] ?>" hidden/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会地点</h3>
                        <div class="edit_r_con">
                            <input name="site" value="约会地点暂时待定" type="text" readonly/>
                        </div>
                    </div>
                </li>
                <li class="noafter">
                    <div class="edit_date_items flex">
                        <h3 class="edit_l_con">约会价格</h3>
                        <div class="edit_r_con">
                            <input type="number" name="price" value="300" readonly/>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="mt40">
                <li>
                    <div class="edit_date_items flex flex_justify marks_edit">
                        <span class="edit_l_con">个人标签</span>
                        <div class="edit_r_con edit_r_marks" id="tag-container">
                            <?php foreach ($date['tags'] as $item): ?>
                                <a class="mark"><?= $item['name']?><input type="text" name='tags[_ids][]'
                                                                          value="<?= $item['id']?>" tag-name="<?= $item['name']?>" hidden/></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="mt40 inner edit_date_desc">
                <h3 class="title">约会说明</h3>
                <div class="text_con">
                    <textarea>100字以内</textarea>
                </div>
            </div>
            <input type="text" name="user_id" value="<?= $user->id ?>" hidden>
            <input type="text" name="status" value="2" hidden>
        </form>
    </div>
    <div class="inner">
        <a class="btn btn_cancely mt60 mb60 delete-btn">删除</a>
    </div>
</div>
<!--弹出层-->
<!--技能选择框-->
<?= $this->cell('Dates::skillsView', ['skills-select-view']); ?>
<!--价格选择框-->
<?= $this->cell('Dates::costsView', ['costs-select-view']); ?>
<!--标签选择框-->
<?= $this->cell('Dates::tagsView', ['tags-select-view']); ?>
<!--日期时间选择器-->
<?= $this->element('checkdate'); ?>

<script>

    $(".cancel-btn").on('click', function () {

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


    $(".release-btn").on('click', function () {

        //验证开始日期
        var start_time = new Date($("#start-time").val());
        var current_time = new Date();
        if(Date.parse(start_time) < Date.parse(current_time)) {

            alert("约会时间不能早于当前时间!");
            return;

        }

        $.ajax({
            type: 'POST',
            url: '/date/edit/' + $(this).attr('date-id'),
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


    $(".delete-btn").on('click', function () {

        if(confirm("确定删除?")) {
            $.ajax({
                type: 'POST',
                url: '/date/delete/' + <?= $date['id']?>,
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
        }

    })

</script>