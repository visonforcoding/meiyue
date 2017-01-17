<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>身份认证</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="identify_info_des">
        <?php if(!($user->idfront) || !($user->idback) || !($user->idperson)): ?>
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
        <?php elseif($user->id_status == UserStatus::NOPASS): ?>
            <div class="identity_audit_pass">
                <i class='iconfont color_error'>&#xe61a;</i>
                <h3 class="jump_tipscon">审核不通过!</h3>
                <p class="audit_des">您的身份证照片可能模糊、遮挡等看不清；或没有参照示例上传；或使用他人照片。请重新上传清晰的本人照片。</p>
            </div>
        <?php elseif($user->id_status == UserStatus::CHECKING): ?>
            <div class="identity_audit_pass">
                <i class='iconfont color_y' style="font-size:2rem">&#xe681;</i>
                <h3 class="jump_tipscon">审核中!</h3>
            </div>
        <?php endif; ?>
    </div>

    <div class="up_identify_box bgff mt40">
        <?php if(($user->id_status == UserStatus::CHECKING) && ($user->idfront) && ($user->idback) && ($user->idperson)): ?>
        <div class="inner">
            <div class="title">
                    <h3 class="color_black">我的身份认证照片</h3>
            </div>
            <div class="fact_identify">
                <dl class="Idcard">
                    <dt>
                        <img id="front_img" src="<?= $user->idfront; ?>" alt="" />
                    </dt>

                </dl>
                <dl class="Idcard">
                    <dt>
                        <img id="back_img" src="<?= $user->idback; ?>" alt="" />
                    </dt>
                </dl>
                <dl class="Idcard personimg">
                    <dt>
                        <img id="person_img" src="<?= $user->idperson; ?>" alt="" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <?php else: ?>
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
    <div class="inner">
            <div class="title">
                <h3 class="color_black">如上图所示请上传认证照片</h3>
            </div>
            <div class="fact_identify">
                <dl class="Idcard id-upload">
                    <dt>
                        <img id="front_img" src="/mobile/images/upimg.png" alt="" />
                        <input id="idfront" name="idfront" type="hidden" />
                    </dt>

                </dl>
                <dl class="Idcard id-upload">
                    <dt>
                        <img id="back_img" src="/mobile/images/upimg.png" alt="" />
                        <input id="idback" name="idback" type="hidden" />
                    </dt>
                </dl>
                <dl class="Idcard personimg id-upload">
                    <dt>
                        <img id="person_img" src="/mobile/images/upimg.png" alt="" />
                        <input id="idperson" name="idperson" type="hidden" />
                    </dt>
                </dl>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div style="height:62px;"></div>
<?php if(!($user->idfront) || !($user->idback) || !($user->idperson)): ?>
    <a id="submit" class="identify_footer_potion">提交审核</a>
<?php elseif($user->id_status == UserStatus::NOPASS): ?>
    <a id="submit" class="identify_footer_potion">重新审核</a>
<?php endif; ?>

<?= $this->start('script'); ?>
<script>
    $('.id-upload img').on('tap', function () {
        $obj = $(this);
        if ($.util.isAPP) {
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
    $('#submit').on('tap', function () {
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
            url: '/user/reg-auth',
            method: 'POST',
            data: {idfront: idfront, idback: idback, idperson: idperson},
            func: function (res) {
                $.util.alert(res.msg);
                if (res.status) {
                    document.location.href = '/userc/edit-info';
                }
            }
        });
    });
</script>
<?= $this->end('script'); ?>