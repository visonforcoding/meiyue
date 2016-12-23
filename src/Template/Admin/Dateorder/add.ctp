<?php $this->start('static') ?>   
<link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
<link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
<?php $this->end()  ?> 
<div class="work-copy">
    <?= $this->Form->create($dateorder, ['class' => 'form-horizontal']) ?>
             <div class="form-group">
            <label class="col-md-2 control-label">男方</label>
                <div class="col-md-8">
                <?php echo $this->Form->input('consumer_id', ['label' => false,'options' => $buyer,'class'=>'form-control']);?>
                      </div>
         </div>
            <div class="form-group">
        <label class="col-md-2 control-label">消费者姓名</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('consumer', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
             <div class="form-group">
            <label class="col-md-2 control-label">女方</label>
                <div class="col-md-8">
                <?php echo $this->Form->input('dater_id', ['label' => false,'options' => $dater,'class'=>'form-control']);?>
                      </div>
         </div>
            <div class="form-group">
        <label class="col-md-2 control-label">服务提供者姓名</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('dater_name', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
             <div class="form-group">
            <label class="col-md-2 control-label">对应约会</label>
                <div class="col-md-8">
                <?php echo $this->Form->input('date_id', ['label' => false,'options' => $date,'class'=>'form-control']);?>
                      </div>
         </div>
                 <div class="form-group">
            <label class="col-md-2 control-label">用户技能id</label>
                <div class="col-md-8">
                <?php echo $this->Form->input('user_skill_id', ['label' => false,'options' => $userSkill,'class'=>'form-control']);?>
                      </div>
         </div>
            <div class="form-group">
        <label class="col-md-2 control-label">订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('status', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('operate_status', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">约会地点</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('site', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">约会地点纬度</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('site_lat', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">约会地点经度</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('site_lng', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">价格</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('price', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">总金额</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('amount', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">是否被投诉</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('is_complain', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">预约金</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('pre_pay', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">预约金占比</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('pre_precent', ['label' => false, 'class' => 'form-control']);
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
        <label class="col-md-2 control-label">约会总时间</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('date_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">支付预约金时间点</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('prepay_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">是否已被阅读</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('is_read', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">0未删除1男性2女性删除3双方删除</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('is_del', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">评价准时得分</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('appraise_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">评价匹配程度</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('appraise_match', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">评价服务得分</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('appraise_service', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">评价内容</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('appraise_body', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">美女接单时间点</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('receive_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">生成时间</label>
        <div class="col-md-8">
                        <?php
            echo $this->Form->input('create_time', ['label' => false, 'class' => 'form-control']);
            ?>
        </div>
    </div>
        <div class="form-group">
        <label class="col-md-2 control-label">订单更新时间</label>
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
                                window.location.href = '/dateorder/index';
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
