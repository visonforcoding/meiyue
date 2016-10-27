<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>美约认证信息填写</h1>
    </div>
</header>
<div class="wraper">
    <div class="identify_img_ifo">
        <ul class="inner">
            <li class="clearfix">
                <span class="fl">个人头像</span>
                <div class="iden_r_box fr">
                    <div id='thumbnail' class="iden_r_pic">
                        <img id='avatar_img' src="/mobile/images/headpic.png" alt="" />
                        <input id='avatar' type="file" name="avatar" class="img-input" 
                               style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
            <li class="clearfix">
                <span class="fl">个人主页封面</span>
                <div class="iden_r_box fr">
                    <div class="iden_r_pic">
                        <img id='cover_img' src="/mobile/images/headpicinfo.png" alt="" />
                        <input id='cover' type="file" name="cover" class="img-input" 
                               style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
        </ul>
    </div>
    <div class="identify_basic_info mt40">
        <ul class="inner">
            <li class="clearfix">
                <a href="#this">
                    <span class="fl">基本信息</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix">
                <a href="#this">
                    <span class="fl">身份认证</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
            <li class="clearfix">
                <a href="#this">
                    <span class="fl">基本照片与视频上传</span>
                    <i class="iconfont right_ico fr">&#xe605;</i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div style="height:62px;"></div>
<a id="submit" class="identify_footer_potion">提交审核</a>
<?= $this->start('script'); ?>
<script>
    $.util.singleImgPreView('avatar', 'avatar_img');
    $.util.singleImgPreView('cover', 'cover_img');
    $('#submit').on('tap', function () {
        var fd = new FormData();
        fd.append('avatar', document.getElementById('avatar').files[0]);
        fd.append('cover', document.getElementById('cover').files[0]);
        $.util.zajax('','POST',fd,function(res){
            console.log(res);
        });
    });
</script>
<?= $this->end('script'); ?>