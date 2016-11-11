<form>
    <label>技能名称：<input type="text" name="name"></label>
    <p>
    <label>技能图标：<input type="text" name="class" class=""></label>
    <p>
    <label>地址关键字（选填）：<input type="text" name="q_key">
        <br>
        <span style="font-size: small; color: grey;">(例如：百度大厦、中关村。多个关键字之间使用'$'隔开，最多10个关键字)</span>
    </label>
    <p>
    <label>POI分类：
        <select name="poi_cls">
            <?php $types = getBaiduPOICF(); ?>
            <?php foreach ($types as $key => $value): ?>
                <option value="<?= $value?>"><?= $value?></option>
            <?php endforeach;?>
        </select>
    </label>
    <p>
    <label>是否显示在‘发现’筛选框中：
        <select name="is_shown">
            <option value="1">是</option>
            <option value="0">否</option>
        </select>
    </label>
    <p>
    <label>在‘发现’筛选框中的排序：
        <input type="number" name="shown_order" value="0">
        <span style="font-size: small; color: grey;">(数值越小越靠前)</span>
    </label>
    <p>
    <input name="parent_id" value="<?= $skill['parent_id']; ?>" hidden>
    <input id="submit" type="button" value="确定">
</form>

<script src="/wpadmin/js/jquery.js" ></script>
<script src="/wpadmin/lib/layer/layer.js" ></script>
<script src="/wpadmin/js/global.js" ></script>
<script>

    $("#submit").on('click', function(){
        var options = $('form').serialize();
        $.ajax({
            type: 'POST',
            url: '/skill/add/<?= $skill['parent_id']; ?>',
            dataType: 'json',
            data: options,
            success: function (res) {
                if (typeof res === 'object') {
                    if (res.status) {

                        history.back();

                    } else {

                        alert(res.msg);

                    }
                }
            }
        });

    })


</script>