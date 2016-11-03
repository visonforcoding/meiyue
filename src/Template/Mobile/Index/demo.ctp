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
<a href="#this" id='submit' class="identify_footer_potion">提交</a>
<!--<a href="#this" id='submit' class="identify_footer_potion">提交审核</a>-->
<?= $this->start('script'); ?>
<script>

    $('#up').on('tap', function () {
        var self = $(this);
        var max = $('#imageUpBox').data('count');
        var param = {};
        var key = 'images';
        param['key'] = 'images';
        param['max'] = max;
        LEMON.event.choosePic(param, function (res) {
            res = JSON.parse(res);
            $.each(res.images, function (i, n) {
                max--;
                self.parents('dl.Idcard').before('<dl data-index="' + n + '"  class="Idcard new">' +
                        '<dt>' +
                        '<img data-id="' + n + '" class="up" src="http://image.com/' + key + '/' + n + '" alt="" />' +
                        '</dt>' +
                        '</dl>');
            })
            $('#imageUpBox').data('count', max);
        });
    })
//    $('.Idcard').on('tap',function(){
//        alert('我要调试');
//    });
    $(document).on('tap','.Idcard.new', function () {
        alert('我要去更换图片');
        var param = {};
        var key = 'images';
        var index = $(this).data('index');
        param['key'] = 'images';
        param['index'] = index;
        console.log(param);
        LEMON.event.changePic(param,function(res){
            res = JSON.parse(res);
            $('#card_'+param['index']).find('img').attr('src','http://image.com/'+key+'/'+res[key][0]);
        })
    });
//    res = '{"images":[0, 1, 2]}';
//    res = JSON.parse(res);
//    renderImgs(res);
    function renderImgs(res) {
        var max = 9;
        console.log(max);
        //res = JSON.parse(res);
        var key = 'images';
        $.each(res.images, function (i, n) {
            max--;
            $('#up').parents('dl.Idcard').before('<dl data-index="' + n + '"  class="Idcard new">' +
                    '<dt>' +
                    '<img data-id="' + n + '" class="up" src="http://image.com/' + key + '/' + n + '" alt="" />' +
                    '</dt>' +
                    '</dl>');
        })
    }
</script>
<?= $this->end('script'); ?>

