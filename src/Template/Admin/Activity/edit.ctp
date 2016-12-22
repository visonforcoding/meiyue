<?php $this->start('static') ?>
    <link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
    <link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end() ?>
    <div class="work-copy">
        <?= $this->Form->create($activity, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
            <label class="col-md-2 control-label">派对名称</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('title', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">男性报名费</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('male_price', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">女性出场费</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('female_price', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">退出活动扣除比例</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('punish_percent', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">派对简介</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('description', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">开始时间</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('start_time', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">结束时间</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('end_time', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">地点</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('site', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">地址纬度</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('site_lat', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">地址经度</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('site_lng', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">男性报名名额</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('male_lim', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">女性出场名额</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('female_lim', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">派对状态</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('status', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">活动须知</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('notice', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">备注</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('remark', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">取消截止天数</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('cancelday', ['label' => false, 'class' => 'form-control', 'default' => 3]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">活动详细说明</label>
            <!--<div class="col-md-8">
                <?php
/*                echo $this->Form->input('detail', ['label' => false, 'class' => 'form-control']);
                */?>
            </div>-->

            <div class="col-md-8">
                <script
                    name='detail'
                    id='detail'
                    rows='2'
                    type="text/plain"
                    class='form-control-editor'>
                    <?= $activity->detail ?>
                </script>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">封面图</label>
            <div class="col-md-8">
                <div  class="img-thumbnail input-img"  single>
                    <img src="<?= $activity->big_img; ?>"/>
                </div>
                <!--<div style="color:red">请上传宽为690，高小于388的封面图</div>-->
                <input name="big_img" value="<?= $activity->big_img; ?>" type="hidden"/>
                <div id="big_img" w="690" h="388" class="jqupload">上传</div>
                <span class="notice">支持格式jpg,png,jpeg</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">广告语</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('ad', ['label' => false, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type='submit' id='submit' class='btn btn-primary' value='保存' data-loading='稍候...'/>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

<?php $this->start('script'); ?>
    <script type="text/javascript" src="/wpadmin/lib/jqform/jquery.form.js"></script>
    <script type="text/javascript" src="/wpadmin/lib/jqupload/jquery.uploadfile.js"></script>
    <script type="text/javascript"
            src="/wpadmin/lib/jqvalidation/js/languages/jquery.validationEngine-zh_CN.js"></script>
    <script type="text/javascript" src="/wpadmin/lib/jqvalidation/js/jquery.validationEngine.js"></script>
    <script src="/wpadmin/lib/ueditor/ueditor.config.js" ></script>
    <script src="/wpadmin/lib/ueditor/ueditor.all.js" ></script>
    <script href="/wpadmin/lib/ueditor/lang/zh-cn/zh-cn.js" ></script>
    <script>
        $(function () {
            initJqupload('big_img', '/wpadmin/util/doUpload?dir=activitycover', 'jpg,png,gif,jpeg'); //初始化图片上传

            var ue = UE.getEditor('detail'); //初始化富文本编辑器
            $('form').validationEngine({
                focusFirstField: true,
                autoPositionUpdate: true,
                promptPosition: "bottomRight"
            });
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
                                    window.location.href = '/activity/index';
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
