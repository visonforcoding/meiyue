<div class="work-copy">
    <?= $this->Form->create($setting, ['class' => 'form-horizontal']) ?>
    <div class="form-group">
        <label class="col-md-2 control-label">约会分享描述</label>
        <div class="col-md-8">
            <?php
            echo $this->Form->input('content', ['label' => false, 'class' => 'form-control', 'type' => 'textarea']);
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

<script src="/wpadmin/js/jquery.js" ></script>
<script src="/wpadmin/lib/layer/layer.js" ></script>
<script src="/wpadmin/js/global.js" ></script>
<script>
    $(function () {
        $('form').submit(function () {
            var form = $(this);
            $.ajax({
                data: $(form).serialize(),
                dataType: 'json',
                method: 'POST',
                success: function (res) {
                    if (typeof res === 'object') {
                        if (res.status) {
                            layer.alert(res.msg);
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