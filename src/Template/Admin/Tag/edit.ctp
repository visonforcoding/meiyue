<form>
    <label>标签名称：<input type="text" name="name" value="<?= $tag['name']?>"></label>
    <label>标签分类：
        <select name="type">
            <?php $types = getTagType(); ?>
            <?php foreach ($types as $key => $value): ?>
                <option value="<?= $key?>" <?php if($tag['type'] == $key){ echo 'selected';}; ?>><?= $value?></option>
            <?php endforeach;?>
        </select>
    </label>
    <input id="submit" type="button" value="确定">
</form>

<script src="/wpadmin/js/jquery.js" ></script>
<script src="/wpadmin/lib/layer/layer.js" ></script>
<script>

    $("#submit").on('click', function(){
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        var options = $('form').serialize();
        $.ajax({
            type: 'POST',
            url: '/tag/edit/' + <?= $tag['id'] ?>,
            dataType: 'json',
            data: options,
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {

                        parent.window.location.reload();

                    } else {

                        layer.alert(res.msg);

                    }
                }
            }
        });

    })


</script>