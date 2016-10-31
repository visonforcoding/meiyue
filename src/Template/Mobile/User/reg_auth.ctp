<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>身份认证</h1>
    </div>
</header>
<div class="wraper">
    <div class="identify_info_des">
        <div class="inner">
            <ul>
                <li>
                    <h3><i class="iconfont color_y">&#xe604;</i>为什么要身份认证？</h3>
                    <div class="con">
                        <p>美约作为一个真实的高端红人工作交友平台，希望给大家提供一个真诚的工作交友环境。请放心您上传的身份证照片仅供审核，仅自己可见，其他无法看到。</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!--示例-->
    <div class="up_identify_box">
        <div class="inner">
            <div class="title">
                <h3>示例<i>（请务必按照示例上传清晰的照片）</i></h3>
            </div>
            <div class="example_identify">
                <dl class="Idcard">
                    <dt>
                    <img src="/mobile/images/face.jpg" alt="" />
                    <span class="tips">参考图例</span>
                    </dt>
                    <dd>身份证正面照</dd>
                </dl>
                <dl class="Idcard">
                    <dt>
                    <img src="/mobile/images/reverse.jpg" alt="" />
                    <span class="tips">参考图例</span>
                    </dt>
                    <dd>身份证背面照</dd>
                </dl>
                <dl class="Idcard personimg">
                    <dt>
                    <img src="/mobile/images/person.jpg" alt="" />
                    <span class="tips">参考图例</span>
                    </dt>
                    <dd>手持身份证正面照</dd>
                </dl>
            </div>
        </div>
    </div>
    <!--上传-->
    <div class="up_identify_box bgff mt40">
        <div class="inner">
            <div class="title">
                <h3 class="color_black">如上图所示请上传认证照片</h3>
            </div>
            <div class="fact_identify">
                <dl class="Idcard">
                    <dt>
                    <img id="front_img" src="/mobile/images/upimg.png" alt="" />
                    <input id="front" type="file" />
                    </dt>

                </dl>
                <dl class="Idcard">
                    <dt>
                    <img id="back_img" src="/mobile/images/upimg.png" alt="" />
                    <input id="back" type="file" />
                    </dt>

                </dl>
                <dl class="Idcard personimg">
                    <dt>
                    <img id="person_img" src="/mobile/images/upimg.png" alt="" />
                    <input id="person" name="ID" type="file" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<div style="height:62px;"></div>
<a id="submit" class="identify_footer_potion">开始审核</a>
<?= $this->start('script'); ?>
<script>
    $.util.singleImgPreView('front', 'front_img');
    $.util.singleImgPreView('back', 'back_img');
    $.util.singleImgPreView('person', 'person_img');
    $('#submit').on('tap', function () {
        var front = document.getElementById('front').files[0];
        var back = document.getElementById('back').files[0];
        var person = document.getElementById('person').files[0];
        if(!front){
            $.util.alert('请上传正面照');
            return false;
        }
        if(!back){
            $.util.alert('请上传背面照');
            return false;
        }
        if(!person){
            $.util.alert('请上传背面照');
            return false;
        }
        var fd = new FormData();
        fd.append('front', front);
        fd.append('back', back);
        fd.append('person', person);
        $.util.zajax('','POST',fd,function(res){
            if(res.status){
                document.location.href = '/user/reg-basic-pic';
            }else{
                $.util.alert(res.msg);
            }
        });
    });
</script>
<?= $this->end('script'); ?>