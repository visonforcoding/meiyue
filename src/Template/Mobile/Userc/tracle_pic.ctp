<div>
    <div class="header">
        <span class="l_btn">取消</span>
        <h1>添加动态</h1>
        <span class="r_btn">发布</span>
    </div>
</div>
<div class="wraper">
    <div class="submit_box_textarea">
        <div class="inner">
            <textarea name="" rows="" cols="" placeholder="说一下这一刻你的想法。。。。"></textarea>
        </div>
        <!--示例-->
        <div class="up_identify_box bgff">
            <div class="inner">
                <div  class="fact_identify" id="demoImg">
                    <dl class="Idcard" data-id="up">
                        <dt><img src="/mobile/images/upimg.png" /></dt>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <p class="commontitle aligncenter mt20">注意要发布个人性感、具有诱惑力的性感私房照，且必须发9张</p>
    <div class="inner mt100">
        <p class="commontitle aligncenter color_y">没有性感照片?</p>
        <div class="inner">
            <a href="#this" class="btn btn_dark_t mt20">免费约拍</a>
        </div>
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    var user_id = <?= $user->id ?>;
    $.util.choosImgs('demoImg');

    $('#submit').on('tap', function () {
        if ($('#tracle_imgs').data('max') === '0') {
            LEMON.event.uploadPics({key: 'add_tracle', user_id: user_id, param: 'id:123,uid:456'});
        }
        $.util.alert('完成注册');
        setTimeout(function () {
            location.href = '/index/index';
        }, 1000);
    })
</script>
<?= $this->end('script'); ?>