<!--弹出层-->
<div class="raper show skills-container" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="skill-view-cancel-btn" class="cancel">取消</span>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <?php foreach ($skills as $item): ?>
                <?php if(count($item[1]) > 0): ?>
                <div class="choose_mark__items">
                    <h3 class="commontitle mt20 "><?= $item[0]['name'] ?></h3>
                    <ul class="bgff">
                        <?php foreach ($item[1] as $sitem): ?>
                            <li class="skill-item"
                                user-skill-id="<?= $sitem['id']?>"
                                skill-name="<?= $sitem['skill']['name'] ?>"
                                skill-id="<?= $sitem['skill']['id'] ?>"
                                cost="<?= $sitem['cost']['money'] ?>">
                                <div class="choose_marks">
                                    <span class="iconfont">&#xe624;</span>
                                    <i><?= $sitem['skill']['name'] ?></i>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
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
            userSkill['skill_id'] = $(this).attr('skill-id');
            _func(userSkill);
            $(".skills-container").hide();
        }

    });

</script>

