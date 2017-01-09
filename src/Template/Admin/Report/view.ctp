<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="report view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>举报类型</th>
        <td><?= h($report->type) ?></td>
    </tr>
    
    <tr>
        <th>用户id</th>
        <td><?= h($report->user_id) ?></td>
    </tr>
    
    <tr>
        <th>create_time</th>
        <td><?= h($report->create_time) ?></td>
    </tr>
    
    <tr>
        <th>update_time</th>
        <td><?= h($report->update_time) ?></td>
    </tr>
</div>
</body>
