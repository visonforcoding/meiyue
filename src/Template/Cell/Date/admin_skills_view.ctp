<!--弹出层-->
<div class="raper show skills-container" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="skill-view-cancel-btn" class="cancel">取消</span>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <?php foreach ($skills as $skill): ?>
                <?php if(count($skill->children) > 0): ?>
                <div class="choose_mark__items">
                    <h3 class="commontitle mt20 "><?= $skill->name ?></h3>
                    <ul class="bgff">
                        <?php foreach ($skill['children'] as $item): ?>
                            <li class="skill-item" skill-id="<?= $item['id']?>" skill-name="<?= $item['name'] ?>" >
                                <div class="choose_marks">
                                    <span class="iconfont"><?= $item['class']; ?></span>
                                    <i><?= $item['name'] ?></i>
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

            var skill = {};
            skill['id'] = $(this).attr('skill-id');
            skill['name'] = $(this).attr('skill-name');
            _func(skill);
            $(".skills-container").hide();

        }

    });

</script>

