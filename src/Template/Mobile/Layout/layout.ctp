<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="format-detection"content="telephone=no, email=no" />
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title><?= isset($pageTitle) ? $pageTitle : '美约'; ?></title>
        <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="/mobile/js/zepto.min.js"></script>
        <script type="text/javascript" src="/mobile/js/util.js?0908"></script>
        <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm.css">
        <link rel="stylesheet" href="/mobile/css/base.css">
        <?= $this->fetch('css') ?>
        <?= $this->fetch('static') ?>
    </head>
    <body>
        <div class="page-group">
            <div class="page page-current">
                <!-- 你的html代码 -->
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm.js' charset='utf-8'></script>
        <!--如果你用到了拓展包中的组件，还需要引用下面两个-->
        <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/sm-extend.css">
        <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/sm-extend.js' charset='utf-8'></script>
        <?= $this->fetch('script') ?>
    </body>
</html>
