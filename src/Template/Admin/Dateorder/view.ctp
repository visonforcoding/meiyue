<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    </head>
    <body>
        <table class="table">
            <thead>
                <tr>
                    <th>时间</th>
                    <th>事件</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $dateorder->create_time ?></td>
                    <td>男方创建订单</td>
                </tr>
                <?php if ($dateorder->prepay_time): ?>
                    <tr>
                        <td><?= $dateorder->prepay_time ?></td>
                        <td>男方支付预约金</td>
                    </tr>
                <?php endif; ?>
                <?php if ($dateorder->receive_time): ?>
                    <tr>
                        <td><?= $dateorder->receive_time ?></td>
                        <td>女方接受约单</td>
                    </tr>
                <?php endif; ?>
                <?php if ($dateorder->w_go_time): ?>
                    <tr>
                        <td><?= $dateorder->w_go_time ?></td>
                        <td>女方确认到达时间</td>
                    </tr>
                <?php endif; ?>
                <?php if ($dateorder->m_go_time): ?>
                    <tr>
                        <td><?= $dateorder->m_go_time ?></td>
                        <td>男方确认到达时间</td>
                    </tr>
                <?php endif; ?>
                <?php if ($dateorder->close_time): ?>
                    <tr>
                        <td><?= $dateorder->close_time ?></td>
                        <td>关闭时间</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <h3>受理投诉</h3>
        <form class="form-horizontal">
            <div class="form-group">
                <label for="is_complain" class="col-sm-2">是否受理</label>
                <div class="col-md-6 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="is_complain"  id="is_complain">
                            确认受理
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2">处理结果</label>
                <div class="col-md-6 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input name="result" value="1" checked="checked" type="radio">
                            投诉成功
                        </label>
                        <label>
                            <input name="result" value="2" type="radio">
                            投诉失败
                        </label>
                        <label>
                            <input name="result" value="3" type="radio">
                            维持原来
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2">退回金额</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" required="required" name="m_p" id="m_p" placeholder="退回男性百分比">
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" required="required" name="w_p" id="w_p" placeholder="退回女性百分比">
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-2">投诉原因及处理结果</label>
                <div class="col-sm-8">
                    <textarea name="complain_result" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button data-price="<?= $dateorder->amount ?>" id="submit" type="button" class="btn btn-default btn-primary">确认</button>
                </div>
            </div>
        </form>
        <script src="/wpadmin/js/jquery.js"></script>
        <script>
            $('#submit').on('click', function () {
                if (!$('#is_complain').is(':checked')) {
                    parent.layer.msg('未确认受理')
                    return false;
                }
                var $form = $('form');
                var w_p = $('[name="w_p"]').val();
                var m_p = $('[name="m_p"]').val();
                if (!w_p || !m_p) {
                    parent.layer.msg('退款占比未填写');
                }
                var amount = $(this).data('price');
                var msg = '确认此操作？系统将会退回' + amount * m_p / 100 + '美币给男性用户,退回' + amount * w_p / 100 + '美币给女性用户';
                parent.layer.confirm(msg, {btn: ['确认', '继续添加']}, function () {
                    $.ajax({
                        type: 'post',
                        url: '/dateorder/hand-complain/<?= $dateorder->id ?>',
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function (res) {
                            if (res.status) {
                                parent.layer.msg(msg);
                                setTimeout(function () {
                                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                    parent.layer.close(index); //再执行关闭   
                                }, 1500)
                            }

                        }
                    });
                }, function () {

                });
            });
        </script>
    </body>
</html>