<?php $this->start('static') ?>   
<link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
<link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end() ?> 
<div class="work-copy">
    <?= $this->Form->create($user, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
        <label class="col-md-2 control-label">手机号</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('phone', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">密码</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('pwd', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">用户标志</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('user_token', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">wx_unionid</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('union_id', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">微信的openid</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('wx_openid', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">app端的微信id</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('app_wx_openid', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">姓名</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('truename', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">等级,1:普通2:专家</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('level', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">职位</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('position', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">邮箱</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('email', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">1,男，2女</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('gender', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">常驻城市</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('city', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">头像</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('avatar', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">账户余额</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('money', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">实名认证状态：1.实名待审核2审核通过0审核不通过</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('status', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">账号状态 ：1.可用0禁用(控制登录)</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('enabled', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">是否假删除：1,是0否</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('is_del', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">注册设备</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('device', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">创建时间</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('create_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">修改时间</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('update_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">唯一码（用于扫码登录）</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('guid', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <input type='submit' id='submit' class='btn btn-primary' value='保存' data-loading='稍候...' /> 
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php $this->start('script'); ?>
<script type="text/javascript" src="/wpadmin/lib/jqform/jquery.form.js"></script>
<script type="text/javascript" src="/wpadmin/lib/jqupload/jquery.uploadfile.js"></script>
<script type="text/javascript" src="/wpadmin/lib/jqvalidation/js/languages/jquery.validationEngine-zh_CN.js"></script>
<script type="text/javascript" src="/wpadmin/lib/jqvalidation/js/jquery.validationEngine.js"></script>
<!--<script src="/wpadmin/lib/ueditor/ueditor.config.js" ></script>
<script src="/wpadmin/lib/ueditor/ueditor.all.js" ></script>
<script href="/wpadmin/lib/ueditor/lang/zh-cn/zh-cn.js" ></script>    -->
<script>
    $(function () {
        // initJqupload('cover', '/wpadmin/util/doUpload', 'jpg,png,gif,jpeg'); //初始化图片上传
        //var ue = UE.getEditor('content'); //初始化富文本编辑器
        $('form').validationEngine({focusFirstField: true, autoPositionUpdate: true, promptPosition: "bottomRight"});
        $('form').submit(function () {
            var form = $(this);
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (typeof res === 'object') {
                        if (res.status) {
                            layer.alert(res.msg, function () {
                                window.location.href = '/user/index';
                            });
                        } else {
                            layer.alert(res.msg, {icon: 5});
                        }
                    }
                }
            });
            return false;
        });
    });
</script>
<?php
$this->end();
