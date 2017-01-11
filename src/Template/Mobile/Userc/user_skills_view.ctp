<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>
            <?= isset($userskill) ? '编辑技能' : '添加技能' ?>
        </h1>
        <span class="r_btn release-btn"><?= isset($userskill) ? '重新发布' : '发布' ?></span>
    </div>
</header> -->
<div class="wraper">
    <form>
        <div class="edit_ability bgff mt40">
            <ul class="outerblock">
                <li>
                    <div id="skill-btn" class="items flex flex_justify">
                        <div class='col-importent'>技能名称</div>
                        <div class="r_info">
                        <span id="show-skill-name">
                            <?= isset($userskill) ? $userskill['skill']['name'] : '<span class="color_gray">请选择</span>' ?>
                        </span>
                            <i class="iconfont rcon">&#xe605;</i>
                            <input id="skill-id-input" name="skill_id" type="text"
                                   value="<?= isset($userskill) ? $userskill['skill']['id'] : '' ?>" hidden/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="items flex flex_justify" id="cost-btn">
                        <div class='col-importent'>技能价格</div>
                        <div class="r_info">
                            <span id="show-cost">
                                <?= (isset($userskill) && isset($userskill->cost))?$userskill->cost->money.'<i class="smalldes">美币/小时</i>':'<span class="color_gray">200/h~300/h更受欢迎哦~</span>'; ?>

                            </span>
                            <i class="iconfont rcon">&#xe605;</i>
                            <input
                                id="cost-id-input"
                                type="text"
                                name="cost_id"
                                value="<?= (isset($userskill) && isset($userskill->cost))?$userskill->cost->id:''; ?>"
                                hidden>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="edit_ability edit_ability-marks bgff mt40">
            <ul class="outerblock">
                <li>
                    <div id="choose_tags_btn" class="items flex flex_justify">
                        <div class='col-importent'>个人标签</div>
                         <div class='ability-marks-box'>
                        <div id="tag-container" class="r_info">
                            <?php if (!isset($userskill)): ?>
                                <span class="color_gray">请选择</span>
                                <i class="iconfont rcon">&#xe605;</i>
                            <?php else: ?>
                                <?php foreach ($userskill['tags'] as $item): ?>
                                    <a class="mark">
                                        <?= $item['name'] ?>
                                        <input type="text"
                                               name='tags[_ids][]'
                                               value="<?= $item['id'] ?>"
                                               tag-name="<?= $item['name'] ?>"
                                               hidden/>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                             </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="edit_ability bgff inner mt40">
            <div class="date_text">
                <div class="b_title col-importent">约会说明</div>
                <div class="r_text">
                    <textarea id="description-input" name="description" placeholder="可以描述自己的特长，曾获得过的技能奖项，能给对方带来什么。"><?= empty($userskill['description'])?'':$userskill['description']; ?></textarea>
                </div>
            </div>
        </div>
        <input id="use_status"
               type="text"
               name="is_used"
               value="1"
               hidden>
        <!--<div class="ability_items mt40">
            <div class="switchbox flex flex_justify inner">
                <div class="switch_str col-importent">上线</div>
                <div class="switch
                    <?/*= isset($userskill)?(($userskill['is_used'] ==1)?'on':'off'):'on' */?>">
                    <i class="swithbtn"></i>
                </div>

            </div>
        </div>-->
    </form>
    <?php if(isset($userskill)): ?>
    <div class="inner">
        <a class="btn btn_cancely mt60 mb60 delete-btn">删除</a>
    </div>
    <?php endif; ?>
</div>

<!--弹出层-->
<!--技能选择框-->
<?= $this->cell('Date::adminSkillsView'); ?>
<!--标签选择框-->
<?= $this->cell('Date::tagsView'); ?>
<!--价格选择框-->
<?= $this->cell('Date::costsView'); ?>

<script>

    addEvent();
    $(".release-btn").on('click', function () {
        release();
    })

    function release() {
        var url = '';
        if ('<?= isset($userskill)?'edit':'add' ?>' == 'add') {
            url = '/userc/user-skill-save/';
        } else {
            url = '/userc/user-skill-save/<?= $userskill['id']?>';
        }
        var skill = $('#skill-id-input').val();
        var cost = $('#cost-id-input').val();
        var desc = $('#description-input').val();
        var tag = $('#tag-container').find('input').length;
        if(!skill) {
            $.util.alert('请选择技能名称');
            return;
        }
        if(!cost) {
            $.util.alert('请选择价格');
            return;
        }
        if(!tag) {
            $.util.alert('至少需要一个个人标签');
            return;
        }
        if(!desc) {
            $.util.alert('请填写约会说明');
            return;
        }
        $.util.showPreloader();
        $.ajax({
            type: 'POST',
            url: url,
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                $.util.hidePreloader();
                if (typeof res === 'object') {
                    $.util.alert(res.msg);
                    if (res.status) {
                        setTimeout(function () {
                            window.location.href = '/userc/user-skills-index';
                        }, 1000)
                    }
                }
            },
            error: function(res) {
                $.util.hidePreloader();
            }
        });
    }


    //约会主题选择回调函数
    function chooseSkillCallBack(skill) {
        $("#skill-id-input").val(skill['id']);
        $("#show-skill-name").text(skill['name']);
    }


    $("#skill-btn").on('click', function () {
        new skillsPicker().show(chooseSkillCallBack);
    });


    //标签选择回调函数
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

    $("#choose_tags_btn").on('click', function () {
        var currentDatas = [];
        $("#tag-container").find("input").each(function () {
            currentDatas.push($(this).val());
        })
        new TagsPicker().show(chooseTagsCallBack, currentDatas, 4);
    });


    function chooseCostCB(val) {
        $('#show-cost').text(val.cost + '/小时');
        $('#cost-id-input').val(val.cost_id);
    }
    var cPicker = new costsPicker();
    cPicker.init(chooseCostCB);
    $('#cost-btn').on('tap', function() {
        cPicker.show();
    });

    <?php if(isset($userskill)): ?>
    $('.delete-btn').on('tap', function() {
        $.util.confirm('删除技能', '确定要删除技能吗?',function() {
            $.util.ajax({
                url: '/userc/del-user-skill/<?= $userskill->id?>',
                func: function (res) {
                    $.util.alert(res.msg);
                    if(res.status) {
                        window.location.href='/userc/user-skills-index';
                    }
                }
            }),
            null
        });
    })
    <?php endif; ?>

    function addEvent() {
        $('.toback').on('click', function(){
            history.back();
        })

        $("#description-input").keyup(function(){
            var len = $(this).val().length;
            console.log(len);
            if(len > 100){
                $(this).val($(this).val().substring(0,100));
            }
        });
    }

    var rbtname = '<?= isset($userskill) ? '重新发布' : '发布' ?>';
    LEMON.sys.setTopRight(rbtname)
    window.onTopRight = function () {
        release();
    }
    LEMON.event.unrefresh();
</script>