<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <span class="edit-btn r_btn" date-id="<?= $date['id'] ?>">编辑</span>
        <h1>约会详情</h1>
    </div>
</header>
<div class="wraper">
    <div class="date_detail_place inner">
        <h3 class="title"><i class="itemsname color_y">
                <?= $date['user_skill']['skill']['name']?></i> <?= $date['title']?>
        </h3>
        <div class="place_pic">
					<span class="place">
						<img src="/mobile/images/date_place.jpg"/>
					</span>
            <div class="place_info">
                <h3 class="userinfo"><?= $date['user']['nick']?>
                    <span>
                        <?= getAge($date['user']['birthday']);?>
                    </span></h3>
                <h3 class="otherinfo">
                    <time><i class="iconfont color_y">&#xe622;</i>
                        <?= getFormateDT($date['start_time'], $date['end_time']);?></time>
                    <address><i class="iconfont color_y">&#xe623;</i><?= $date['site']?></address>
                </h3>
            </div>
        </div>
    </div>
    <!--约会说明-->
    <div class="date_detail_des mt20">
        <h3 class="commontitle inner">约会说明</h3>
        <div class="detail_des_con">
            <p class="inner"><?= $date['description'] ?></p>
        </div>
    </div>
    <!--我的标签-->
    <?php if(count($date['tags']) > 0): ?>
    <div class="date_detail_des mt20">
        <h3 class="commontitle inner">我的标签</h3>
        <div class="detail_des_mark">
            <?php foreach ($date['tags'] as $item): ?>
            <a class="mark"><?= $item['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="inner">
    <?php if($date['status'] == DateState::NOT_YET): ?>
        <a class="btn btn_cancel mt60">取消发布</a>
        <p class="commontips mt40 color_des aligncenter">点击此按钮后，此约会将从活动-约会模块中移除</p>
    <?php endif; ?>
</div>

<script>

    $(".toback").on('click', function(){
        history.back();
    });


    $(".edit-btn").on('click', function(){
        window.location.href = '/date/edit/' + $(this).attr('date-id');
    })


    $(".btn_cancel").on('click', function(){
        if(confirm("确定取消发布?")) {
            $.ajax({
                type: 'PUT',
                url: '/date/edit/' + <?= $date['id'] ?> + "/3",
                dataType: 'json',
                success: function (res) {
                    if (typeof res === 'object') {
                        if (res.status) {
                            $.util.alert(res.msg);
                            window.location.href = '/date/index';
                        } else {
                            $.util.alert(res.msg);
                        }
                    }
                }
            });
        };

    });

    LEMON.sys.setTopRight('编辑');
    window.onTopRight = function () {
        window.location.href = '/date/edit/<?= $date['id'] ?>';
    }
</script>