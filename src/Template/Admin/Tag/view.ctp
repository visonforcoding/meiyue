<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="tags view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>标签名</th>
        <td><?= h($tag->name) ?></td>
    </tr>
    
    <tr>
        <th>parent_id</th>
        <td><?= h($tag->parent_id) ?></td>
    </tr>
</div>
</body>
