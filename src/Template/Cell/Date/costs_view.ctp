<!--弹出层-->
<div class="raper show" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="cost-view-cancel-btn" class="cancel">取消</span>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <ul >
                <li>
                    <i>摄影</i>
                </li>
                <li>
                    <i>摄影</i>
                </li>
                <li>
                    <i>摄影</i>
                </li>
                <li>
                    <i>摄影</i>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>

    $('#cost-view-cancel-btn').on('click', function(){

        $('#<?= $container_id; ?>').hide();

    });

</script>

