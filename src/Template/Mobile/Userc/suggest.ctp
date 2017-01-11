<header>
    <div class="header">
        <span class="l_btn">取消</span>
        <h1>意见反馈</h1>
        <span class="r_btn" onclick="release();">提交</span>
    </div>
</header>
<div class="wraper">
    <div class="submit_box_textarea suggest_area">
        <form>
        <div class="inner">
            <textarea name="body" rows="" cols="" placeholder="请简要描述您的问题。。。。"></textarea>
        </div>
        </form>
    </div>
</div>

<script>
    LEMON.sys.setTopRight('提交')
    window.onTopRight = function () {
        release();
    }

    function release() {
        $.util.confirm(
            '意见反馈',
            '确定要提交吗？',
            function() {
                $.util.showPreloader();
                $.ajax({
                    type: 'POST',
                    url: '/userc/suggest',
                    data: $("form").serialize(),
                    dataType: 'json',
                    success: function (res) {
                        $.util.hidePreloader();
                        if (typeof res === 'object') {
                            $.util.alert(res.msg);
                            setTimeout(function() {
                                if (res.status) {
                                    window.location.href = '/user/index';
                                }
                            }, 1000)
                        }
                    }
                });
            }
        )
    }
</script>