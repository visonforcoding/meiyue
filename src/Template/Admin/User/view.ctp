<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th{
            width:120px;
        }
    </style>
</head>
<body>
<div class="user view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">
    
    <tr>
        <th>手机号</th>
        <td><?= h($user->phone) ?></td>
    </tr>
    
    <tr>
        <th>密码</th>
        <td><?= h($user->pwd) ?></td>
    </tr>
    
    <tr>
        <th>用户标志</th>
        <td><?= h($user->user_token) ?></td>
    </tr>
    
    <tr>
        <th>wx_unionid</th>
        <td><?= h($user->union_id) ?></td>
    </tr>
    
    <tr>
        <th>微信的openid</th>
        <td><?= h($user->wx_openid) ?></td>
    </tr>
    
    <tr>
        <th>app端的微信id</th>
        <td><?= h($user->app_wx_openid) ?></td>
    </tr>
    
    <tr>
        <th>姓名</th>
        <td><?= h($user->truename) ?></td>
    </tr>
    
    <tr>
        <th>等级,1:普通2:专家</th>
        <td><?= h($user->level) ?></td>
    </tr>
    
    <tr>
        <th>职位</th>
        <td><?= h($user->position) ?></td>
    </tr>
    
    <tr>
        <th>邮箱</th>
        <td><?= h($user->email) ?></td>
    </tr>
    
    <tr>
        <th>1,男，2女</th>
        <td><?= h($user->gender) ?></td>
    </tr>
    
    <tr>
        <th>常驻城市</th>
        <td><?= h($user->city) ?></td>
    </tr>
    
    <tr>
        <th>头像</th>
        <td><?= h($user->avatar) ?></td>
    </tr>
    
    <tr>
        <th>账户余额</th>
        <td><?= h($user->money) ?></td>
    </tr>
    
    <tr>
        <th>实名认证状态：1.实名待审核2审核通过0审核不通过</th>
        <td><?= h($user->status) ?></td>
    </tr>
    
    <tr>
        <th>账号状态 ：1.可用0禁用(控制登录)</th>
        <td><?= h($user->enabled) ?></td>
    </tr>
    
    <tr>
        <th>是否假删除：1,是0否</th>
        <td><?= h($user->is_del) ?></td>
    </tr>
    
    <tr>
        <th>注册设备</th>
        <td><?= h($user->device) ?></td>
    </tr>
    
    <tr>
        <th>创建时间</th>
        <td><?= h($user->create_time) ?></td>
    </tr>
    
    <tr>
        <th>修改时间</th>
        <td><?= h($user->update_time) ?></td>
    </tr>
    
    <tr>
        <th>唯一码（用于扫码登录）</th>
        <td><?= h($user->guid) ?></td>
    </tr>
</div>
</body>
