<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本照片与视频上传</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="upload_more_title">
                <h3 class="color_black">照片和视频认证示范</h3>
                <p>请上传自己的性感、具有诱惑力的照片，注意不能有私密处的裸露。</p>
            </div>
            <div class="fact_identify">
                <dl class="Idcard">
                    <dt>
                    <img src="/mobile/images/avatar.jpg" alt="" />
                    </dt>
                </dl>
                <dl class="Idcard">
                    <dt>
                        <img src="/mobile/images/avatar.jpg" alt="" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <!--示例-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title">
                <h3 class="color_black">如上图所示，上传9张认证照片</h3>
            </div>
            <div  class="fact_identify" id="demoImg">
                <dl class="Idcard" data-id="up">
                    <dt><img src="/mobile/images/upimg.png" /></dt>
                </dl>
            </div>
        </div>
    </div>
    <!--示例-->
   
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title">
                <h3 class="color_black">如上图所示，上传认证视频</h3>
            </div>
            <div class="fact_identify">
                <dl class="Idcard">
                    <dt id="up_video">
                        <img src="/mobile/images/upimg.png" alt="" />
                        <i class="iconfont playbtn">&#xe600;</i>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <!--上传-->
</div>
<div style="height:62px;"></div>
<a href="#this" id='submit' class="identify_footer_potion">提交</a>
<!--<a href="#this" id='submit' class="identify_footer_potion">提交审核</a>-->
<?= $this->start('script'); ?>
<script>
    var user_id = <?=$user->id?>;
    $.util.choosImgs('demoImg');
    $.util.chooseVideo('up_video');

    $('#submit').on('tap',function(){
        if($('#demoImg').data('max') === '0') LEMON.event.uploadPics({key:'demoImg', user_id:user_id, param:'id:123,uid:456'});
        if($('#up_video').data('choosed')) LEMON.event.uploadVideo({key:'up_video', user_id:user_id});
        $.util.alert('完成注册');
        setTimeout(function(){
            location.href = '/index/find-rich-list';
        },1000);
    })


</script>
<?= $this->end('script'); ?>

