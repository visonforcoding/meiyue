<style type="text/css">

    @font-face {
        font-family: "iconfont" ;
        src: url('/mobile/font/iconfont.eot'); /* IE9*/
        src: url('/mobile/font/iconfont.eot#iefix') format('embedded-opentype'), /* IE6-IE8 */ url('/mobile/font/iconfont.woff') format('woff'), /* chrome, firefox */ url('/mobile/font/iconfont.ttf') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/ url('/mobile/font/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
        font-family: "iconfont" !important;
        font-size: 16px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;
    }
</style>
<form>
    <label>技能名称：<input type="text" name="name"></label>
    <p>
    <label>技能图标：<i id="iconpreview" class="icon iconfont">&#xe62e;</i><input id="iconvalue" type="text" name="class" class="" value="&#xe62e;" hidden></label>
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
        console.log($('#iconvalue').val());
        return;
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

    $('#iconvalue').on('click', function() {
        iconView();
    });

    function iconView() {
        url = '/mobile/font/skill_icons.html';
        layer.open({
            type: 2,
            title: '选择图标',
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '70%'],
            content: url//iframe的url
        });
    }
</script>