<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="dateorder view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>男方</th>
        <td><?= h($dateorder->consumer_id) ?></td>
    </tr>
    
    <tr>
        <th>消费者姓名</th>
        <td><?= h($dateorder->consumer) ?></td>
    </tr>
    
    <tr>
        <th>女方</th>
        <td><?= h($dateorder->dater_id) ?></td>
    </tr>
    
    <tr>
        <th>服务提供者姓名</th>
        <td><?= h($dateorder->dater_name) ?></td>
    </tr>
    
    <tr>
        <th>对应约会</th>
        <td><?= h($dateorder->date_id) ?></td>
    </tr>
    
    <tr>
        <th>用户技能id</th>
        <td><?= h($dateorder->user_skill_id) ?></td>
    </tr>
    
    <tr>
        <th>订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败</th>
        <td><?= h($dateorder->status) ?></td>
    </tr>
    
    <tr>
        <th>用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单</th>
        <td><?= h($dateorder->operate_status) ?></td>
    </tr>
    
    <tr>
        <th>约会地点</th>
        <td><?= h($dateorder->site) ?></td>
    </tr>
    
    <tr>
        <th>约会地点纬度</th>
        <td><?= h($dateorder->site_lat) ?></td>
    </tr>
    
    <tr>
        <th>约会地点经度</th>
        <td><?= h($dateorder->site_lng) ?></td>
    </tr>
    
    <tr>
        <th>价格</th>
        <td><?= h($dateorder->price) ?></td>
    </tr>
    
    <tr>
        <th>总金额</th>
        <td><?= h($dateorder->amount) ?></td>
    </tr>
    
    <tr>
        <th>是否被投诉</th>
        <td><?= h($dateorder->is_complain) ?></td>
    </tr>
    
    <tr>
        <th>预约金</th>
        <td><?= h($dateorder->pre_pay) ?></td>
    </tr>
    
    <tr>
        <th>预约金占比</th>
        <td><?= h($dateorder->pre_precent) ?></td>
    </tr>
    
    <tr>
        <th>开始时间</th>
        <td><?= h($dateorder->start_time) ?></td>
    </tr>
    
    <tr>
        <th>结束时间</th>
        <td><?= h($dateorder->end_time) ?></td>
    </tr>
    
    <tr>
        <th>约会总时间</th>
        <td><?= h($dateorder->date_time) ?></td>
    </tr>
    
    <tr>
        <th>支付预约金时间点</th>
        <td><?= h($dateorder->prepay_time) ?></td>
    </tr>
    
    <tr>
        <th>是否已被阅读</th>
        <td><?= h($dateorder->is_read) ?></td>
    </tr>
    
    <tr>
        <th>0未删除1男性2女性删除3双方删除</th>
        <td><?= h($dateorder->is_del) ?></td>
    </tr>
    
    <tr>
        <th>评价准时得分</th>
        <td><?= h($dateorder->appraise_time) ?></td>
    </tr>
    
    <tr>
        <th>评价匹配程度</th>
        <td><?= h($dateorder->appraise_match) ?></td>
    </tr>
    
    <tr>
        <th>评价服务得分</th>
        <td><?= h($dateorder->appraise_service) ?></td>
    </tr>
    
    <tr>
        <th>评价内容</th>
        <td><?= h($dateorder->appraise_body) ?></td>
    </tr>
    
    <tr>
        <th>美女接单时间点</th>
        <td><?= h($dateorder->receive_time) ?></td>
    </tr>
    
    <tr>
        <th>生成时间</th>
        <td><?= h($dateorder->create_time) ?></td>
    </tr>
    
    <tr>
        <th>订单更新时间</th>
        <td><?= h($dateorder->update_time) ?></td>
    </tr>
</div>
</body>
