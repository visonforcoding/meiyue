<?php $this->start('static') ?>
<script src="/mobile/js/NIM_Web_NIM_v3.2.0.js"></script>
<script src="/mobile/js/mustache.min.js"></script>
<script id="chat-list-tpl" type="text/html">
    {{#sessions}}
    <li id="chat-{{to}}" class="active flex">
        <div data-accid="{{to}}" data-avatar="{{avatar}}" data-nick="{{nick}}"  
             class="ablock flex flex_justify user clickable">
            <div class="chat-left-info flex">
                <div class="avatar">
                    <img src="{{avatar}}"/>
                    <!--<div class="num">{{unread}}</div>-->
                </div>
                <div class="chat-text">
                    <h3 class="name">{{nick}}</h3>
                    <span class="last-info line1">{{lastMsg.text}}</span>
                </div>
            </div>
            <time class="smalldes">{{datetime}}</time>
        </div>
        <div class="r-btn flex">
            <div class="focus">关注</div>
            <div data-accid="{{to}}" class="del clickable">删除</div>
        </div>
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
            <a href="/userc/visitors" class="a-height flex flex_justify">
                <div class="l-info-name">我的访客</div>
                <i class="iconfont rcon">&#xe605;</i>
            </a>
        </li>
        <li>
            <a href="/chat/meiyue-message" class="a-height flex flex_justify">
                <div class="l-info-name">平台消息</div>
                <div class="tips-box"><!--<span class="tips"></span>--><i class="iconfont rcon">&#xe605;</i></div>
            </a>
        </li>
    </ul>
    <ul id="chat-list" class="chatBox chat-bottom-box mt40">
    </ul>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'chat']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
var data = {};
var accids = [];   //列表accid
var account = LEMON.db.get('im_accid');
//var account = 'meiyue_110';
//var token = '89e66f7fc9ac977d0d7298d397e05820';
var token = LEMON.db.get('im_token');
var nim = NIM.getInstance({
    debug: true,
    appKey: '<?=$imkey?>',
    account: account,
    token: token,
    onconnect: onConnect,
    onwillreconnect: onWillReconnect,
    ondisconnect: onDisconnect,
    onerror: onError,
    onsessions: onSessions,
    onupdatesession: onUpdateSession
});
function onConnect() {
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
    $.each(sessions, function (i, n) {
        accids.push(n.to);
    });
    $.util.ajax({
        url: '/chat/getSesList',
        data: {accids: accids},
        func: function (res) {
            $('#chat-list').html(getRender(sessions, res));
        }
    })
    console.log('收到会话列表', sessions);
    data.sessions = nim.mergeSessions(data.sessions, sessions);
    updateSessionsUI();
}
function onUpdateSession(session) {
    console.log('会话更新了', session);
    data.sessions = nim.mergeSessions(data.sessions, session);
    var newSess = session.to;
    if ($.inArray(newSess, accids) == -1) {
        //新会话
        $.util.ajax({
            url: '/chat/getSesList',
            data: {accids: [newSess]},
            func: function (res) {
                //新聊天
                accids.push(newSess);
                $('#chat-list').prepend(getRender([session], res));
            }
        });
    } else {
        //旧会话 新消息
        $obj = $('#chat-' + newSess);
        var index = $obj.index();
        if (index !== 0) {
            //排到最前面
            $obj.remove();
            $obj.find('.num').html(session.unread);
            $obj.find('span.last-info').html(session.lastMsg.text);
            $('#chat-list').prepend($obj);
        } else {
            $obj.find('.num').html(session.unread);
            $obj.find('span.last-info').html(session.lastMsg.text);
        }
    }
    updateSessionsUI();
}
function updateSessionsUI() {
    // 刷新界面
}
function onError(error) {
    console.log(error);
}
$(document).on('click', '.user', function () {
    //聊天
    var param = {};
    var accid = $(this).data('accid');
    var nick = $(this).data('nick');
    var avatar = $(this).data('avatar');
    param['accid'] = accid;
    param['nick'] = nick;
    param['avatar'] = avatar;
    LEMON.event.imTalk(param);
});

$(document).on('click','.del',function(){
   //删除会话 
   var account = $(this).data('accid');
   console.log(account);
   delImSess(account);
});

function delImSess(account) {
    //删除会话方法
    var id = account;
    nim.deleteSession({
        scene: 'p2p',
        to: id,
        done: function (error, obj) {
            if(!error){
              $('#chat-' + id).addClass('remove')
            }
            console.log(error);
            console.log(obj);
            console.log('删除会话' + (!error ? '成功' : '失败'));
        }
    });
}
function getRender(sessions, res) {
    $.each(sessions, function (i, n) {
        sessions[i]['nick'] = '';
        sessions[i]['avatar'] = '';
        $.each(res.users, function (k, v) {
            if (n.to == v.imaccid) {
                sessions[i]['nick'] = v.nick;
                sessions[i]['avatar'] = v.avatar;
                sessions[i]['datetime'] = $.util.getImShowTime(new Date(n.updateTime));
            }
        })
    })
    var mus_data = {};
    mus_data['sessions'] = sessions;
    var template = $('#chat-list-tpl').html();
    Mustache.parse(template);
    var rendered = Mustache.render(template, mus_data);
    return rendered;
}

</script>
<?php $this->end('script'); ?>