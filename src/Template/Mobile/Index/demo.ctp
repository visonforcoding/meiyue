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
            <div  class="fact_identify" id="demoImg">
                <dl class="Idcard" data-id="up">
                    <dt><img src="/mobile/images/upimg.png" /></dt>
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
                    <img id="up_video" src="/mobile/images/upimg.png" alt="" />
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

    function choosImgs(id){
        var max=9, dom = $('#'+id); dom.data('max', max);
        dom.on('tap', function(e){
            var target = e.srcElement || e.target, em = target, i = 1;
            if(em.nodeName == 'IMG') em = em.parentNode;
            if(em.nodeName == 'DT') em = em.parentNode;
            if(em.nodeName != 'DL') return;
            var cid = $(em).data('id');
            if(cid == 'up'){
                if(dom.data('max') == 0) return;
                LEMON.event.choosePic({'key':id, 'max':dom.data('max')}, function (res) {
                    res = JSON.parse(res);  res = res[id];
                    var len = max-dom.data('max');

                    if(res.hasOwnProperty('index')){
                        dom.find('img').eq(res.index).attr('src', 'http://image.com/'+id+'/'+res.index);
                        return;
                    }

                    if(res.count){
                        for(var i=0; i<res.count; i++) {
                            var src = $.util.isIOS ? 'src="http://image.com/'+id+'/'+(len+i)+'"' : '';
                            $(em).before('<dl class="Idcard" data-id="'+(len+i)+'"><dt><img '+src+'/></dt></dl>');
                        }
                    }

                    len = dom.find('dl').length-1;
                    dom.data('max', max-len);
                    if(len == max) dom.find("[data-id=up]").hide();
                })
            }
            else if(cid >= 0 && cid < max){
                alert(cid);
                LEMON.event.changePic({'key':id, 'index':cid},function(res){
                    res = JSON.parse(res); res = res[id];
                    dom.find('img').eq(res.index).attr('src', 'http://image.com/'+id+'/'+res.index);
                })

            }
        });

    }

    choosImgs('demoImg');

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
                self.parents('dl.Idcard').before('<dl data-index="' + n + '" id="card_'+n+'" class="Idcard new">' +
                        '<dt>' +
                        '<img data-id="' + n + '" class="up" src="http://image.com/' + key + '/' + n + '" alt="" />' +
                        '</dt>' +
                        '</dl>');
            })
            $('#imageUpBox').data('count', max);
        });
    })
    $('#up_video').on('tap',function(){
        alert('去选择视频');
        var self = $(this);
        var param = {'key':'video'};
        LEMON.event.chooseVideo(param,function(res){
            res = JSON.parse(res);
            self.attr('src','http://video.com/'+res['video'][0]);
        });
    });
    $('#submit').on('tap',function(){
        var param = {};
        param['key'] = 'images';
        param['api'] = 'saveUserBasicPic';
        LEMON.event.uploadPics(param,function(res){
            if(res.status){
                alert('老子成功去上传了');
            }else{
                alert('老子失败去上传了');
            }
        })
    })
//    $('.Idcard').on('tap',function(){
//        alert('我要调试');
//    });
    $(document).on('tap','.Idcard.new', function () {
        var param = {};
        var key = 'images';
        var index = $(this).data('index');
        param['key'] = 'images';
        param['index'] = index;
        LEMON.event.changePic(param,function(res){
            alert(res);
            res = JSON.parse(res);
            alert(res);
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

