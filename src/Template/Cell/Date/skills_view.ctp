<!--弹出层-->
<div class="raper show skills-container" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="skill-view-cancel-btn" class="cancel">取消</span>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <?php foreach ($list as $item): ?>
            <div class="choose_mark__items">
                <h3 class="commontitle mt20"><?= $item['name']?></h3>
                <ul class="bgff flex flex_justify">
                    <?php foreach ($item['children'] as $i): ?>
                        <li class="skill-item" val="<?= $i['id'] ?>" name="<?= $i['name'] ?>">
                            <div class="choose_marks">
                                <span class="iconfont">&#xe624;</span>
                                <i><?= $i['name'] ?></i>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>

    $('#skill-view-cancel-btn').on('click', function(){

        $(".skills-container").hide();

    });


    var skillsPicker = function() {};


    var _func;
    skillsPicker.prototype.show = function(func) {

        _func = func;
        $(".skills-container").show();

    };


    $('.skill-item').on('click', function(){

        if(_func) {

            _func($(this).attr('name'), $(this).attr('val'));
            $(".skills-container").hide();

        }

    });

</script>

