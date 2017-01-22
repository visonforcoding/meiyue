<?php $this->start('static') ?>
    <link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
    <link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end() ?>
    <div class="work-copy">
        <?= $this->Form->create($package, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
            <label class="col-md-2 control-label">套餐名称</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'title',
                    [
                        'label' => false,
                        'type' => 'text',
                        'value' => '',
                        'class' => 'form-control',
                    ]
                );
                ?>
            </div>
        </div>
        <!--<div class="form-group">
            <label class="col-md-2 control-label">荣誉称号</label>
            <div class="col-md-8">
                <?php
/*                echo $this->Form->input(
                    'honour_name',
                    [
                        'label' => false,
                        'type' => 'text',
                        'value' => '',
                        'class' => 'form-control',
                    ]
                );
                */?>
            </div>
        </div>-->
        <div class="form-group">
            <label class="col-md-2 control-label">套餐类型</label>
            <div class="col-md-8">
            <?php
                echo $this->Form->input(
                    'type',
                    [
                        'label' => false,
                        'type' => 'select',
                        "options" => PackType::getPackageType(),
                        'class' => 'form-control'
                    ]
                );
            ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">聊天名额</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'chat_num',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
            <label>
                无限
                <?php echo $this->Form->checkbox('chat_endless');?>
            </label>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">查看动态名额</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'browse_num',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
            <label>
                无限
                <?php echo $this->Form->checkbox('browse_endless');?>
            </label>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">派对折扣</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'act_dct',
                    [
                        'label' => false,
                        'class' => 'form-control',
                        'value' => 10
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">折扣派对类型</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'dct4act_type',
                    [
                        'label' => false,
                        'type' => 'select',
                        "options" => ActType::getWorkType(),
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">派对赠送数量</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'act_send_num',
                    [
                        'label' => false,
                        'class' => 'form-control',
                        'value' => 0
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">赠送派对类型</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'send4act_type',
                    [
                        'label' => false,
                        'type' => 'select',
                        "options" => ActType::getWorkType(),
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">充值</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'vir_money',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">价格</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'price',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">库存</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'stock',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">有效期(单位:天)</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'vali_time',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">显示顺序</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input(
                    'show_order',
                    [
                        'label' => false,
                        'class' => 'form-control'
                    ]
                );
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type='submit'
                       id='submit'
                       class='btn btn-primary'
                       value='保存'
                       data-loading='稍候...'/>
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
    <script>
        $(function () {
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
                                layer.confirm(res.msg, {
                                    btn: ['确认', '继续添加'] //按钮
                                }, function () {
                                    window.location.href = '/package/index';
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
