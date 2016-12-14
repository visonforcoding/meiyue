<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="movement view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>用户id</th>
        <td><?= h($movement->user_id) ?></td>
    </tr>
    
    <tr>
        <th>1:图片动态2.视频动态</th>
        <td><?= h($movement->type) ?></td>
    </tr>
    
    <tr>
        <th>动态内容</th>
        <td><?= h($movement->body) ?></td>
    </tr>
    
    <tr>
        <th>images</th>
        <td><?= h($movement->images) ?></td>
    </tr>
    
    <tr>
        <th>video</th>
        <td><?= h($movement->video) ?></td>
    </tr>
    
    <tr>
        <th>video_cover</th>
        <td><?= h($movement->video_cover) ?></td>
    </tr>
    
    <tr>
        <th>查看数</th>
        <td><?= h($movement->view_nums) ?></td>
    </tr>
    
    <tr>
        <th>点赞数</th>
        <td><?= h($movement->praise_nums) ?></td>
    </tr>
    
    <tr>
        <th>1待审核2审核通过3审核不通过</th>
        <td><?= h($movement->status) ?></td>
    </tr>
    
    <tr>
        <th>create_time</th>
        <td><?= h($movement->create_time) ?></td>
    </tr>
    
    <tr>
        <th>update_time</th>
        <td><?= h($movement->update_time) ?></td>
    </tr>
</div>
</body>
