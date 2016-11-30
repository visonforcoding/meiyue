<header>
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>免费约拍报名</h1>
        <span id="submit-btn" class="r_btn">提交</span>
    </div>
</header>
<div class="wraper">
    <div class="booking_box_list">
        <h3 class="commontitle inner mt20">预约时间</h3>
        <div class="con bgff inner">
            <ul>
                <?php
                foreach($datas as $item): ?>
                <li
                    class="each-item flex flex_justify"
                    data-id="<?= $item->id; ?>">
                    <div class="l_info">
                        <time><?= $item->act_date ?></time><i><?= $item->act_week ?></i>
                    </div>
                    <div class="r_info">
                        <span>剩余名额：</span><i><?= $item->rest_num ?></i>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!--预约信息-->
    <div class="booking_box_info">
        <form>
        <h3 class="commontitle inner mt20">预约信息</h3>
        <ul class="content bgff">
            <li class="flex flex_justify">
                <div class="l_info">姓名</div>
                <input
                    name="name"
                    type="text"
                    data-text='姓名'
                    placeholder="请输入姓名" />
            </li>
            <li class="flex flex_justify">
                <div class="l_info">手机号码</div>
                <input
                    name="phone"
                    data-text='手机号码'
                    type="text"
                    placeholder="请输入手机号码" />
            </li>
            <li class="flex flex_justify">
                <div class="l_info">所在地区</div>
                <input
                    name="area"
                    data-text='所在地区'
                    type="text"
                    placeholder="如：福田区" />
            </li>
            <input
                id="yuepai"
                name="yuepai_id"
                data-text='约拍时间'
                type="number"
                value=""
                hidden />
        </ul>
        </form>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    $('#submit-btn').on('click', function() {

        checkflag = true;
        $("form input").each(function() {
            var text = $(this).data('text');
            var value = $(this).val();
            if($.trim(value) == '') {
                $.util.alert(text + '不能为空！');
                checkflag = false;
                return;
            }
        });
        if(!checkflag) {
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/tracle/yuepai-apply',
            data: $("form").serialize(),
            dataType: 'json',
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {
                        $.util.alert(res.msg);
                        setTimeout(function () {
                            window.location.href = '/userc/my-tracle';
                        }, 1500);
                    } else {
                        $.util.alert(res.msg);
                    }
                }
            }
        });
    });


    $('.each-item').on('click', function() {

        $('.each-item').removeClass('current');
        $(this).addClass('current');
        $('#yuepai').val($(this).data('id'));

    })

    LEMON.event.unrefresh();
    LEMON.sys.setTopRight('提交');
    window.onTopRight = function () {
        $("#submit-btn").trigger('click');
    }
</script>
<?php $this->end(); ?>
