<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>美约认证信息填写</h1>
    </div>
</header>
<div class="wraper">
    <div class="identify_img_ifo">
        <ul class="inner">
<!--            <li class="clearfix">
                <span class="fl">个人头像</span>
                <div class="iden_r_box fr">
                    <div id='thumbnail' class="iden_r_pic">
                        <img id='avatar_img' src="/mobile/images/headpic.png" alt="" />
                        <input id='avatar' type="file" name="avatar" class="img-input" 
                               style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>-->
            <li class="clearfix">
                <span class="fl">上传头像</span>
                <div class="iden_r_box fr">
                    <div class="iden_r_pic">
                        <img id='avatar_img' src="/mobile/images/headpicinfo.png" alt="" />
                        <input id='avatar' type="file" name="cover" class="img-input" 
                               style="position: absolute;left: 0;top: 0;opacity:0;width:100px;height:100px;" single />
                    </div>
                    <i class="iconfont potion">&#xe605;</i>
                </div>
            </li>
        </ul>
    </div>
</div>
<div style="height:62px;"></div>
<?php if($user->gender=='2'): ?>
<a id="submit" class="identify_footer_potion">下一步</a>
<?php else:?>
<a href="/index/index" class="identify_footer_potion">跳过</a>
<?php endif;?>
<?= $this->start('script'); ?>
<script>
    $.util.singleImgPreView('avatar', 'avatar_img');
    $('#submit').on('tap', function () {
        var avatar = document.getElementById('avatar').files[0];
        if(!avatar){
            return false;
        }
        var fd = new FormData();
        fd.append('avatar', document.getElementById('avatar').files[0]);
        $.util.zajax('','POST',fd,function(res){
            if(res.status){
                document.location.href = '/user/reg-basic-info';
            }else{
                $.util.alert(res.msg);
            }
        });
    });
</script>
<?= $this->end('script'); ?>