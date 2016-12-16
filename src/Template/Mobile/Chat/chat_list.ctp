<?php $this->start('static') ?>
<script src="/mobile/js/NIM_Web_NIM_v3.2.0.js"></script>
<script src="/mobile/js/mustache.min.js"></script>
<script id="chat-list-tpl" type="text/html">
    {{#sessions}}
    <li>
        <a data-accid="{{to}}" data-avatar="{{avatar}}" data-nick="{{nick}}"  
           class="ablock flex flex_justify user">
            <div class="chat-left-info flex">
                <div class="avatar">
                    <img src="{{avatar}}"/>
                </div>
                <div class="chat-text">
                    <h3 class="name">{{nick}}</h3>
                    <span class="last-info line1">{{lastMsg.text}}</span>
                </div>
            </div>
            <time class="smalldes">{{updateTime}}</time>
        </a>
    </li>
    {{/sessions}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>消息</h1>
        <span class="r_btn">忽略全部</span>
    </div>
</header>
<div class="wraper">
    <ul class="chatBox">
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">邀请注册</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">我的访客</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="#this" class="a-height flex flex_justify">
                <div class="l-info-name">平台消息</div>
                <div class="tips-box"><span class="tips"></span><i class="iconfont rcon">&#xe605;</i></div>
            </a>
        </li>
    </ul>
    <ul id="chat-list" class="chatBox mt40">
            <?php foreach ($users as $user): ?>
            <li>
                <a data-accid="<?= $user->imaccid ?>" data-avatar="<?= $user->avatar ?>" data-nick="<?= $user->nick ?>"  
                   class="ablock flex flex_justify user">
                    <div class="chat-left-info flex">
                        <div class="avatar">
                            <img src="<?= $user->avatar ?>"/>
                        </div>
                        <div class="chat-text">
                            <h3 class="name"><?= $user->nick ?></h3>
                            <span class="last-info line1">晚上不见不散</span>
                        </div>
                    </div>
                    <time class="smalldes">16/06/03 18:00</time>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'chat']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    var data = {};
    var nim = NIM.getInstance({
        debug: true,
        appKey: '9e0e349ffbcf4345fdd777a65584fb68',
        account: 'meiyue_88',
        token: 'e659ccb75a0da8cbb047b2fdbc82b977',
        onconnect: onConnect,
        onwillreconnect: onWillReconnect,
        ondisconnect: onDisconnect,
        onerror: onError,
        onsessions: onSessions,
        onupdatesession: onUpdateSession
    });
    function onConnect() {
        alert('连接成功');
        console.log('连接成功');
    }
    function onWillReconnect(obj) {
        // 此时说明 SDK 已经断开连接, 请开发者在界面上提示用户连接已断开, 而且正在重新建立连接
        console.log('即将重连');
        console.log(obj.retryCount);
        console.log(obj.duration);
    }
    function onDisconnect(error) {
        // 此时说明 SDK 处于断开状态, 开发者此时应该根据错误码提示相应的错误信息, 并且跳转到登录页面
        console.log('丢失连接');
        console.log(error);
        if (error) {
            switch (error.code) {
                // 账号或者密码错误, 请跳转到登录页面并提示错误
                case 302:
                    break;
                    // 被踢, 请提示错误后跳转到登录页面
                case 'kicked':
                    break;
                default:
                    break;
            }
        }
    }
    function onSessions(sessions) {
        var accids = [];
        $.each(sessions, function (i, n) {
            accids.push(n.to);
        });
        $.util.ajax({
            url: '/chat/getSesList',
            data: {accids: accids},
            func: function (res) {
                $.each(sessions, function (i, n) {
                    sessions[i]['nick'] = '';
                    sessions[i]['avatar'] = '';
                    $.each(res.users, function (k, v) {
                        if (n.to == v.imaccid) {
                            sessions[i]['nick'] = v.nick;
                            sessions[i]['avatar'] = v.avatar;
                        }
                    })
                })
                var data = {};
                data['sessions'] = sessions;
                var template = $('#chat-list-tpl').html();
                Mustache.parse(template);
                var rendered = Mustache.render(template, data);
//                $('#chat-list').html(rendered);
                
            }
        })
        console.log('收到会话列表', sessions);
        data.sessions = nim.mergeSessions(data.sessions, sessions);
        updateSessionsUI();
    }
    function onUpdateSession(session) {
        console.log('会话更新了', session);
        data.sessions = nim.mergeSessions(data.sessions, session);
        updateSessionsUI();
    }
    function updateSessionsUI() {
        // 刷新界面
    }
    function onError(error) {
        console.log(error);
    }
    $('.user').on('click', function () {
        var param = {};
        var accid = $(this).data('accid');
        var nick = $(this).data('nick');
        var avatar = $(this).data('avatar');
        param['accid'] = accid;
        param['nick'] = nick;
        param['avatar'] = avatar;
        param['msgtype'] = 'finsh_prepay';
        //param = JSON.stringify(param);
        alert(param);
        LEMON.event.imTalk(param);
    })
</script>
<?php $this->end('script'); ?>