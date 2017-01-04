<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>我的技能</h1>
    </div>
</header> -->
<div class="wraper">
    <?php if(count($userskills)): ?>
    <div class="ability_items">
        <div class="switchbox flex flex_justify inner">
            <div>全部上线</div>
            <div class="switch-btn switch <?= $is_all_used?'on':'off' ?> switch-all"><i class="swithbtn"></i></div>
        </div>
    </div>
    <?php endif; ?>
    <div class="ability_items mt20">
        <ul class="outerblock">
            <?php foreach ($userskills as $item): ?>
                <li class="switchbox flex flex_justify skill-item" item-id="<?= $item['id'];?>">
                    <div><?= $item['skill']['name']; ?></div>
                    <div class="flex">
                        <i class="smalldes"><?= $item['cost']['money']; ?>美币/小时</i>
                        <?php if($item->is_checked == 1): ?>
                        <div
                            class="switch-btn switch <?= ($item['is_used'] == 1)?'on':'off' ?>"
                            item-id="<?= $item['id'];?>">
                            <i class="swithbtn"></i>
                        </div>
                        <?php elseif($item->is_checked == 2): ?>
                            <div class="switch color_friends">
                                审核中
                            </div>
                        <?php elseif($item->is_checked == 0): ?>
                            <div class="switch color_friends">
                                审核不通过
                            </div>
                        <?php endif; ?>
                    </div>

                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="inner mt60">
        <div class="inner">
            <a href="/userc/user-skills-view/add" id="add-skill" class="btn btn_t_border inner">新增</a>
        </div>
    </div>
</div>

<script>

    $('.toback').on('click', function(){
        history.back();
    })
    LEMON.sys.back('/user/index');

    $('.skill-item').on('click', function(){
        window.location.href = '/userc/user-skills-view/edit/' + $(this).attr('item-id');
    })
    $('#add-skill').bind('click',function(event){
        event.preventDefault();
        var url = $(this).attr('href');
        $.util.ajax({
            url:'/userc/check-user-status',
            func:function(res){
                if(!res.status){
                    $.util.alert(res.msg);
                }else{
                    document.location.href = url;
                }
            }
        })
    });

    $('.switch-btn').on('click', function (e) {
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
                $('.switch-btn').each(function(){
                    $(this).removeClass('on');
                    $(this).addClass('off');
                })
            } else {
                $('.switch-btn').each(function(){
                    $(this).removeClass('off');
                    $(this).addClass('on');
                })
            }
        } else {
            if($selector.hasClass('on')) {
                $selector.removeClass('on');
                $selector.addClass('off');
            } else {
                $selector.removeClass('off');
                $selector.addClass('on');
            }
            if(isAllSwitchSame() == 3) {
                $('.switch-all').addClass('on');
                $('.switch-all').removeClass('off');
            } else {
                $('.switch-all').addClass('off');
                $('.switch-all').removeClass('on');
            }
        }
    }

    /**
     * 检查按钮状态
     * 1#有开有关 2#全部都关闭 3#全部都打开
     * @returns {boolean}
     */
    function isAllSwitchSame() {
        var onFlag = false;
        var offFlag = false;
        $('.switch-btn').each(function(){
            if(!$(this).hasClass('switch-all')) {
                if($(this).hasClass('on')) {
                    onFlag = true;
                } else {
                    offFlag = true;
                }
            }
        });
        if(onFlag == offFlag) {
            return 1;
        } else if(offFlag) {
            return 2;
        } else if(onFlag) {
            return 3;
        }
    }
</script>