<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="activity view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    <tr>
        <th>大图url</th>
        <td><?= h($activity->big_img) ?></td>
    </tr>
    
    <tr>
        <th>标题</th>
        <td><?= h($activity->title) ?></td>
    </tr>
    
    <tr>
        <th>男性价格</th>
        <td><?= h($activity->male_price) ?></td>
    </tr>
    
    <tr>
        <th>女性价格</th>
        <td><?= h($activity->female_price) ?></td>
    </tr>
    
    <tr>
        <th>描述</th>
        <td><?= h($activity->description) ?></td>
    </tr>
    
    <tr>
        <th>开始时间</th>
        <td><?= h($activity->start_time) ?></td>
    </tr>
    
    <tr>
        <th>结束时间</th>
        <td><?= h($activity->end_time) ?></td>
    </tr>
    
    <tr>
        <th>活动地址</th>
        <td><?= h($activity->site) ?></td>
    </tr>
    
    <tr>
        <th>地址纬度</th>
        <td><?= h($activity->site_lat) ?></td>
    </tr>
    
    <tr>
        <th>地址经度</th>
        <td><?= h($activity->site_lng) ?></td>
    </tr>
    
    <tr>
        <th>活动男性名额</th>
        <td><?= h($activity->male_lim) ?></td>
    </tr>
    
    <tr>
        <th>活动女性名额</th>
        <td><?= h($activity->female_lim) ?></td>
    </tr>
    
    <tr>
        <th>男性剩余名额</th>
        <td><?= h($activity->male_rest) ?></td>
    </tr>
    
    <tr>
        <th>女性剩余名额</th>
        <td><?= h($activity->female_rest) ?></td>
    </tr>
    
    <tr>
        <th>图文详情</th>
        <td><?= h($activity->detail) ?></td>
    </tr>
    
    <tr>
        <th>活动须知</th>
        <td><?= h($activity->notice) ?></td>
    </tr>
    
    <tr>
        <th>活动状态：1#正常进行 2#下架处理</th>
        <td><?= h($activity->status) ?></td>
    </tr>
    
    <tr>
        <th>备注</th>
        <td><?= h($activity->remark) ?></td>
    </tr>
</div>
</body>
