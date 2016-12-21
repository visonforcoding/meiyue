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
                <h3 class="color_black">上传9张认证照片</h3>
            </div>
            <div  class="fact_identify" id="demoImg">
                <dl class="Idcard" data-id="up">
                    <dt><img src="/mobile/images/upimg.png" /></dt>
                </dl>
            </div>
        </div>
    </div>
    <!--示例-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title">
                <h3 class="color_black">上传单张图片</h3>
            </div>
            <div  class="fact_identify" id="demoImg2">
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
                    <dt id="up_video">
                    <img src="/mobile/images/upimg.png" alt="" />
                    <i class="iconfont playbtn">&#xe600;</i>
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="LEMON.event.getLocation(cbfun)">
                <h3 class="color_black">获取地理位置LEMON.event.getLocation(cbfun)</h3>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="alert(LEMON.sys.getSex())">
                <h3 class="color_black">获取用户性别LEMON.sys.getSex()</h3>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.sys.setSex('man'))">
                <h3 class="color_black">设置用户性别LEMON.sys.setSex('man')</h3>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.sys.setSex('falame'))">
                <h3 class="color_black">设置用户性别LEMON.sys.setSex('falame')</h3>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.event.login(cbfun))">
                <h3 class="color_black">登录LEMON.event.login(cbfun)</h3>
            </div>
        </div>
    </div>


    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <a href="/mobile/html/sub_test.html">
                <h3 class="color_black">设置右上角文字 和onTopRight关联</h3>
                <h3 class="color_black">LEMON.sys.setTopRight('确定')</h3>
            </a>
        </div>
    </div>


    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.show.shareBanner())">
                <h3 class="color_black">分享图标LEMON.show.shareBanner()</h3>
            </div>
        </div>
    </div>
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.event.imList())">
                <h3 class="color_black">打开聊天记录LEMON.event.imList()</h3>
            </div>
        </div>
    </div>


    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title" onclick="(LEMON.event.imTalk(12))">
                <h3 class="color_black">和id12的人聊天LEMON.event.imTalk(12)</h3>
            </div>
        </div>
    </div>

    <iframe src="http://www.baidu.com" width="300" height="100"></iframe>

<!--    上传
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="upload_more_title" onclick="(LEMON.sys.setTopRight('确定'))">
                <h3 class="color_black">设置右上角文字 和onTopRight关联</h3>
                <h3 class="color_black">LEMON.sys.setTopRight('确定')</h3>
            </div>
        </div>
    </div>-->

</div>
<div style="height:62px;"></div>
<a href="#this" id='submit' class="identify_footer_potion">提交</a>

<!--<a href="#this" id='submit' class="identify_footer_potion">提交审核</a>-->
<?= $this->start('script'); ?>
<script>
    $.util.choosImgs('demoImg');
    //$.util.choosImgs('demoImg2');
    $.util.chooseVideo('up_video');
    //$.util.chooseVideo('up_video2');

    $('#submit').on('tap', function () {
        if ($('#demoImg').data('max') === '0')
            LEMON.event.uploadPics({key: 'demoImg', user_id: '3', param: 'id:123,uid:456'});
        if ($('#demoImg2').data('max') === '0')
            LEMON.event.uploadPics({key: 'demoImg2', user_id: '3', param: '{id:12322,uid:45644}'});
        if ($('#up_video').data('choosed'))
            LEMON.event.uploadVideo({key: 'up_video', user_id: '3'});
        if ($('#up_video2').data('choosed'))
            LEMON.event.uploadVideo({key: 'up_video2', user_id: '3'});
    })

    $('#demoImg2').on('click', function () {
        LEMON.event.uploadPic('{"dir":"user/avatar"}', function (res) {
            alert(res);

        })
    })

    function cbfun(p) {
        alert(p);
    }
    window.onTopRight = function () {
        alert('window.onTopRight');
    }

</script>
<?= $this->end('script'); ?>

