<header>
    <div class="header">
        <span class="l_btn">取消</span>
        <h1>添加动态</h1>
        <span id="send" class="r_btn">发布</span>
    </div>
</header>
<div class="wraper">
    <div class="submit_box_textarea">
        <div class="inner">
            <textarea id="body" name="" rows="" cols="" placeholder="说一下这一刻你的想法。。。。"></textarea>
        </div>
        <!--示例-->
        <div class="up_identify_box bgff">
            <div class="inner">
                <div  class="fact_identify" id="add_tracle">
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
            <a href="/tracle/tracle_order" class="btn btn_dark_t mt20">免费约拍</a>
        </div>
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    var user_id = <?= $user->id ?>;
    $.util.choosImgs('add_tracle');
    LEMON.sys.setTopRight('发送')
    window.onTopRight = function () {
        var tracle_body = $('#body').val();
        var param = {};
        param['action'] = 'add_tracle_pic';
        param['tracle_body'] = tracle_body;
        param['create_time'] = $.util.getFormatTime();
        param = JSON.stringify(param);
        if ($('#add_tracle').data('max') === '0') {
            LEMON.event.uploadPics({key: 'add_tracle', user_id: user_id, param: param},function(res){
                if(res){
                    $.util.alert('动态已发送,等待平台审核');
                }
            });
        }
    }
</script>
<?= $this->end('script'); ?>