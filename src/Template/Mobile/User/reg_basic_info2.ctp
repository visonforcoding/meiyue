<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>基本信息</h1>
        <span id="next" class="r_btn">提交</span>
    </div>
</header>
<div class="wraper">
    <!--基本信息三步-->
    <div class="basicinfo-header">
        <div class="line-box">
            <div class="info-line flex flex_justify">
                <div class="active"></div>
                <div></div>
            </div>
            <div class="stepnode flex flex_justify">
                <span class="active"></span>
                <span  class="active"></span>
                <span></span>
            </div>
            <div class="step flex flex_justify">
                <h3 class="active">第一步</h3>
                <h3  class="active">第二步</h3>
                <h3>第三步</h3>
            </div>
        </div>
    </div>
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
                    <input id="idfront" name="idfront" type="hidden" />
                    </dt>

                </dl>
                <dl class="Idcard">
                    <dt>
                    <img id="back_img" src="/mobile/images/upimg.png" alt="" />
                    <input id="idback" name="idback" type="hidden" />
                    </dt>
                </dl>
                <dl class="Idcard personimg">
                    <dt>
                    <img id="person_img" src="/mobile/images/upimg.png" alt="" />
                    <input id="idperson" name="idperson" type="hidden" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<?= $this->start('script'); ?>
<script>
    $('.Idcard img').on('tap', function () {
        //alert('点击了图片上传');
        $obj = $(this);
        if ($.util.isAPP) {
            //alert('我要调app的东西了');
            LEMON.event.uploadPic('{"dir":"user/idcard"}', function (data) {
                var data = JSON.parse(data);
                if (data.status === true) {
                    $obj.next('input').val(data.path);
                    $obj.attr('src', data.urlpath);
                } else {
                    $.util.alert('app上传失败');
                }
            });
            return false;
        }
    });
    LEMON.sys.setTopRight('提交')
    window.onTopRight = function () {
        var idfront = $('#idfront').val();
        var idback = $('#idback').val();
        var idperson = $('#idperson').val();
        if (!idfront) {
            $.util.alert('请上传正面照');
            return false;
        }
        if (!idback) {
            $.util.alert('请上传背面照');
            return false;
        }
        if (!idperson) {
            $.util.alert('请上传背面照');
            return false;
        }
        $.util.ajax({
            data: {idfront: idfront, idback: idback, idperson: idperson},
            func: function (res) {
                if (res.status) {
                    document.location.href = '/user/reg-basic-info-3';
                } else {
                    $.util.alert(res.msg);
                }
            }
        });
    }
</script>
<?= $this->end('script'); ?>