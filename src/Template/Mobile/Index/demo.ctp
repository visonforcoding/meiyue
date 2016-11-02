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
            <div data-count='9' id="imageUpBox" class="fact_identify">
                <dl class="Idcard">
                    <dt>
                    <img id='up' src="/mobile/images/upimg.png" alt="" />
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
    $('#up').on('tap', function () {
        alert('去APP选择图片咯..');
        var self = $(this);
        var max = $('#imageUpBox').data('count');
        var param = {};
        param['key'] = 'images';
        param['max'] = max;
        LEMON.event.choosePic(JSON.stringify(param), function (res) {
            res = JSON.parse(res);
            $.each(res.images,function(i,n){
                self.before('<dl class="Idcard">' +
                        '<dt>' +
                        '<img data-id="'+n+'" class="up" src="http://image.com/'+n+'" alt="" />' +
                        '</dt>' +
                        '</dl>');
            })
        });
    })
</script>
<?= $this->end('script'); ?>

