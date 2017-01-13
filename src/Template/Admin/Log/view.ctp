<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="log view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>flag</th>
        <td><?= h($log->flag) ?></td>
    </tr>
    
    <tr>
        <th>msg</th>
        <td><?= h($log->msg) ?></td>
    </tr>
    
    <tr>
        <th>data</th>
        <td><?= h($log->data) ?></td>
    </tr>
    
    <tr>
        <th>create_time</th>
        <td><?= h($log->create_time) ?></td>
    </tr>
</div>
</body>
