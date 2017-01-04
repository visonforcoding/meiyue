<?php $this->start('static') ?>
    <link href="/wpadmin/lib/jqupload/uploadfile.css" rel="stylesheet">
    <link href="/wpadmin/lib/jqvalidation/css/validationEngine.jquery.css" rel="stylesheet">
    <link href="/wpadmin/lib/select2/css/select2.min.css" rel="stylesheet">
<?php $this->end() ?>
    <div class="work-copy">
        <?= $this->Form->create($ptmsg, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
            <label class="col-md-2 control-label">消息主题</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('title', ['label' => false, 'class' => 'form-control', 'empty' => '请填写消息主题']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">消息内容</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('body', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">跳转链接</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->input('to_url', ['label' => false, 'class' => 'form-control', 'type' => 'url', 'required' => false]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">推送类型</label>
            <div class="col-md-8">
                <?php
                $sizes = MsgpushType::getToWho();
                echo $this->Form->select('towho', $sizes, ['default' => MsgpushType::CUSTOM, 'class' => 'form-control']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">推送对象</label>
            <div class="col-md-8">
                <?php
                echo $this->Form->select('user_id[]', [], ['class' => 'form-control', 'id'=>'select-user']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type='submit' id='submit' class='btn btn-primary' value='确定推送' data-loading='稍候...'/>
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
    <script src="/wpadmin/lib/select2/js/select2.full.min.js" ></script>
    <script>
        $(function () {
            // initJqupload('cover', '/wpadmin/util/doUpload', 'jpg,png,gif,jpeg'); //初始化图片上传
            //var ue = UE.getEditor('content'); //初始化富文本编辑器
            $("#select-user").select2({
                ajax: {
                    url: "/ptmsg/find-user",
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            key: params.term,
                        };
                    },
                    processResults: function (data) {
                        console.log(data.datas);
                        return {
                            results: data.datas
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 1,
                multiple: true,
                templateResult: function(repo) {
                    return repo.nick
                },
                templateSelection: function(repo) {return repo.nick}
            });

            $('form').validationEngine({
                focusFirstField: true,
                autoPositionUpdate: true,
                promptPosition: "bottomRight"
            });
            $('form').submit(function () {
                var reslist=$("#select-user").select2("data");    //多选
                if(reslist.length == 0) {
                    layer.alert('至少需要选择一个发送对象');
                    return false;
                } else {
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
                                        window.location.href = '/ptmsg/index';
                                    }, function () {
                                        window.location.reload();
                                    });
                                } else {
                                    layer.alert(res.msg, {icon: 5});
                                }
                            }
                        }
                    });
                }
                return false;
            });
        });
    </script>
<?php
$this->end();
