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
                    ['label' => false, 'class' => 'form-control', 'default' => $carousel->position]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">上传图片</label>
            <div class="col-md-8">
                <div style="width:160px;height:160px;"  class="img-thumbnail input-img"  single>
                    <img width="160px" height="160px" style="width:160px;height:160px;"   src="<?= $carousel->url; ?>"/>
                </div>
                <?php
                echo $this->Form->hidden('url',['label' => false,'class' => 'form-control']);
                ?>
                <div id="url" w="160" h="160" class="jqupload">上传</div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">跳转链接</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('to_url', ['label' => false, 'class' => 'form-control']);
                ?>
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
    <script>
        $(function () {
            initJqupload('url', '/wpadmin/util/doUpload?dir=carousel', 'jpg,png,gif,jpeg'); //初始化图片上传

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
