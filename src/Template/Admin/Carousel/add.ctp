<?php $this->start('static') ?>   
<link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
<link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end() ?> 
<div class="work-copy">
    <?= $this->Form->create($carousel, ['class' => 'form-horizontal']) ?>
    <div class="form-group">
        <label class="col-md-2 control-label">标题</label>
        <div class="col-md-8">
        <?php
            echo $this->Form->input('title', ['label' => false, 'class' => 'form-control']);
        ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">位置</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->select(
                'position',
                CarouselPosition::getStr(),
                ['label' => false, 'class' => 'form-control']
            );
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">上传图片</label>
        <div class="col-md-8">
            <div id="upload-img" style="width:160px;height:160px;"  class="img-thumbnail input-img"  single>
                <img width="160px" height="160px" style="width:160px;height:160px;"   src=""/>
            </div>
            <?php
            echo $this->Form->hidden('url',['label' => false,'class' => 'form-control']);
            ?>
            <div id="url" w="160" h="160" class="jqupload">上传</div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">图文详情</label>
        <div class="col-md-8">
            <script
                name='page'
                id='page'
                rows='2'
                type="text/plain"
                class='form-control-editor'>
                </script>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">备注</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->input('remark', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">状态</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->select(
                'status',
                CarouselStatus::getStatus(),
                ['label' => false, 'class' => 'form-control']
            );
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">分享标题</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->input('share_title', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">分享描述</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->input('share_desc', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);
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
<script src="/wpadmin/lib/ueditor/ueditor.config.js" ></script>
<script src="/wpadmin/lib/ueditor/ueditor.all.js" ></script>
<script href="/wpadmin/lib/ueditor/lang/zh-cn/zh-cn.js" ></script>
<script>
    $(function () {
        initJqupload('url', '/wpadmin/util/doUpload?dir=carousel', 'jpg,png,gif,jpeg'); //初始化图片上传
        var ue = UE.getEditor('page'); //初始化富文本编辑器
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
                                window.location.href = '/carousel/index';
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
