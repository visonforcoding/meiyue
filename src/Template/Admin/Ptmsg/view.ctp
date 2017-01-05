<head>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/zui/css/zui.min.css"/>
    <style>
        th {
            width: 120px;
        }
    </style>
</head>
<body>
<div class="costs view large-9 medium-8 columns content">
    <table class="vertical-table table table-hover table-bordered">

        <tr>
            <th>发送主题</th>
            <td><?= h($ptmsg->title) ?></td>
        </tr>
        <tr>
            <th>发送对象</th>
            <td><?= h(MsgpushType::getToWho($ptmsg->towho)) ?></td>
        </tr>
        <tr>
            <th>消息内容</th>
            <td><?= h($ptmsg->body) ?></td>
        </tr>
        <tr>
            <th>跳转链接</th>
            <td><?= h($ptmsg->to_url) ?></td>
        </tr>
        <tr>
            <th>发送时间</th>
            <td><?= h($ptmsg->create_time) ?></td>
        </tr>
</div>
</body>
