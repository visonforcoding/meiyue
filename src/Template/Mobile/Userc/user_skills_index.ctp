<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>我的技能</h1>
    </div>
</header>
<div class="wraper">
    <div class="ability_items">
        <div class="switchbox flex flex_justify inner">
            <div>全部上线</div>
            <div class="switch <?= $is_all_used?'on':'off' ?> switch-all"><i class="swithbtn"></i></div>
        </div>

    </div>
    <div class="ability_items mt20">
        <ul class="outerblock">
            <?php foreach ($userskills as $item): ?>
                <li class="switchbox flex flex_justify skill-item" item-id="<?= $item['id'];?>">
                    <div><?= $item['skill']['name']; ?></div>
                    <div class="flex">
                        <i class="smalldes"><?= $item['cost']['money']; ?>美币/小时</i>
                        <div class="switch <?= ($item['is_used'] == 1)?'on':'off' ?>" item-id="<?= $item['id'];?>"><i class="swithbtn"></i></div>
                    </div>

                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="inner mt60">
        <div class="inner">
            <a href="/userc/user-skills-view/add" class="btn btn_t_border inner">新增</a>
        </div>
    </div>
</div>

<script>

    $('.toback').on('click', function(){

        history.back();

    })


    $('.skill-item').on('click', function(){

        window.location.href = '/userc/user-skills-view/edit/' + $(this).attr('item-id');

    })


    $('.switch').on('click', function (e) {

        e.stopPropagation();
        //判断此时开关显示状态
        var url = '/userc/update-used-status';
        var selector = $(this);
        if ($(this).hasClass('on')) {

            url += '/' + 0;

        } else {

            url += '/' + 1;

        }

        if(!$(this).hasClass('switch-all')) {

            url += "/" + $(this).attr('item-id')

        }

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {

                        changeSwitchShow(selector);

                    } else {

                        alert(res.msg);

                    }
                }
            }
        });

    })


    //修改按钮显示状态
    function changeSwitchShow($selector) {

        if($selector.hasClass('switch-all')) {

            if ($selector.hasClass('on')) {

                $('.switch').each(function(){
                    $(this).removeClass('on');
                    $(this).addClass('off');
                })

            } else {

                $('.switch').each(function(){
                    $(this).removeClass('off');
                    $(this).addClass('on');
                })

            }

        } else {

            if ($selector.hasClass('on')) {

                $selector.removeClass('on');
                $selector.addClass('off');

            } else {

                $selector.removeClass('off');
                $selector.addClass('on');

            }
            if(isAllSwitchSame()) {

                if ($('.switch-all').hasClass('on')) {

                    $('.switch').each(function(){
                        $(this).removeClass('on');
                        $(this).addClass('off');
                    })

                } else {

                    $('.switch').each(function(){
                        $(this).removeClass('off');
                        $(this).addClass('on');
                    })

                }

            }

        }

    }

    function isAllSwitchSame() {

        var onFlag = false;
        var offFlag = false;
        $('.switch').each(function(){

            if(!$(this).hasClass('switch-all')) {

                if($(this).hasClass('on')) {

                    onFlag = true;

                } else {

                    offFlag = true;

                }

            }

        });
        if(onFlag == offFlag) {

            return false;

        } else {

            return true;

        }

    }

</script>