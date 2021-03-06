<?php $this->start('static') ?>   
<link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
<link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end()  ?> 
<div class="work-copy">
    <?= $this->Form->create($movement, ['class' => 'form-horizontal']) ?>
             <div class="form-group">
            <label class="col-md-2 control-label">用户id</label>
                <div class="col-md-8">
                <?php echo $this->Form->input('user_id', ['label' => false,'options' => $user,'class'=>'form-control']);?>
                      </div>
         </div>
            <div class="form-group">
        <label class="col-md-2 control-label">1:图片动态2.视频动态</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('type', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">动态内容</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('body', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">images</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('images', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">video</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('video', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">video_cover</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('video_cover', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">查看数</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('view_nums', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">点赞数</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('praise_nums', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">1待审核2审核通过3审核不通过</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('status', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">create_time</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('create_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">update_time</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('update_time', ['label' => false, 'class' => 'form-control']);
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
    <script href="/wpadmin/lib/ueditor/lang/zh-cn/zh-cn.js" ></script>-->
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
                            layer.confirm(res.msg, {
                                btn: ['确认', '继续添加'] //按钮
                            }, function () {
                                window.location.href = '/movement/index';
                            }, function () {
                                window.location.reload();
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
