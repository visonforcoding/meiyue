<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="userSkills view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>名称</th>
        <td><?= h($userSkill->skill_id) ?></td>
    </tr>
    
    <tr>
        <th>费用/小时</th>
        <td><?= h($userSkill->cost_id) ?></td>
    </tr>
    
    <tr>
        <th>约会说明</th>
        <td><?= h($userSkill->description) ?></td>
    </tr>
    
    <tr>
        <th>是否上架</th>
        <td><?= h($userSkill->is_used) ?></td>
    </tr>
</div>
</body>
