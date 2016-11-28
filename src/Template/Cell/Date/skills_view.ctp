<!--弹出层-->
<div class="raper show skills-container" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="skill-view-cancel-btn" class="cancel">取消</span>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <?php foreach ($topSkills as $top): ?>
                <div class="choose_mark__items">
                    <h3 class="commontitle mt20 "><?= $top->name ?></h3>
                    <ul class="bgff">
                        <?php foreach ($userSkills as $skill): ?>
                            <?php if ($top->id == $skill->skill->parent_id): ?>
                                <li class="skill-item"
                                    user-skill-id="<?= $skill['id']?>"
                                    skill-name="<?= $skill['skill']['name'] ?>"
                                    cost="<?= $skill['cost']['money'] ?>">
                                    <div class="choose_marks">
                                        <span class="iconfont">&#xe624;</span>
                                        <i><?= $skill['skill']['name'] ?></i>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>

    $('#skill-view-cancel-btn').on('click', function () {

        $(".skills-container").hide();

    });


    var skillsPicker = function () {
    };


    var _func;
    skillsPicker.prototype.show = function (func) {

        _func = func;
        $(".skills-container").show();

    };


    $('.skill-item').on('click', function () {

        if (_func) {

            var userSkill = {};
            userSkill['id'] = $(this).attr('user-skill-id');
            userSkill['skill_name'] = $(this).attr('skill-name');
            userSkill['cost'] = $(this).attr('cost');
            _func(userSkill);
            $(".skills-container").hide();

        }

    });

</script>

