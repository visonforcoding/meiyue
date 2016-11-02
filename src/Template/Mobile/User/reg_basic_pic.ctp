<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本照片与视频上传</h1>
    </div>
</header>
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
            <div id="imageUpBox" class="fact_identify">
                <dl class="Idcard">
                    <dt>
                    <img id="up_img_0" src="/mobile/images/upimg.png" alt="" />
                    <input id="up_0" type="file" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title">
                <h3 class="color_black">如上图所示，上传认证视频</h3>
            </div>
            <div class="fact_identify">
                <dl class="Idcard">
                    <dt>
                    <img src="/mobile/images/upimg.png" alt="" />
                    <input type="file" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<div style="height:62px;"></div>
<a href="#this" class="identify_footer_potion">提交审核</a>
<?= $this->start('script'); ?>
<script>
    var flag = 0;
    $.util.singleImgPreView('up_0', 'up_img_0',cloneUp);
//    $.util.singleImgPreView('up_1', 'up_img_1',cloneUp);
    function cloneUp(id){
       var elm =  $('#'+id).parents('dl').clone(false);
        flag++;
        elm.find('input').attr('id','up_'+flag);
        elm.find('img').attr('id','up_img_'+flag);
        $('#imageUpBox').append(elm);
        //$.util.singleImgPreView('up_'+flag,'up_img_'+flag,cloneUp(id)); 
    }
</script>
<?= $this->end('script'); ?>

