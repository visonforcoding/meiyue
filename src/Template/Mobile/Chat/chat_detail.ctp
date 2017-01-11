<?php $this->start('static') ?>
<style>
    #msg-list{
        overflow-y: scroll;
    }
</style>
<script src="/mobile/js/NIM_Web_NIM_v3.2.0.js"></script>
<script src="/mobile/js/mustache.min.js"></script>
<script id="msg-list-tpl" type="text/html">
    {{#msgs}}
    {{#is_out}}
    <li class="pull-right">
        <div class="chat-con flex  box_start">
            {{#is_custom}}
            <div class="chatbox">
                {{{text}}}
            </div>
            {{/is_custom}}
            {{^is_custom}}
            <div class="chatbox">
                {{text}}
            </div>
            {{/is_custom}}
            <div class="avatar">
                <img src="{{avatar}}"/>
            </div>
        </div>
    </li>
    {{/is_out}}
    {{^is_out}}
    <li class="pull-left">
        <div class="chat-con flex  box_start">
            <div class="avatar">
                <img src="{{avatar}}"/>
            </div>
            {{#is_custom}}
            <div class="chatbox">
                {{{text}}}
            </div>
            {{/is_custom}}
            {{^is_custom}}
            <div class="chatbox">
                {{text}}
            </div>
            {{/is_custom}}
        </div>
    </li>
    {{/is_out}}
    {{/msgs}}
</script>
<?php $this->end('static'); ?>
<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1><?= $to_user->nick ?></h1>
        <span class="iconfont r_btn">&#xe65d;</span>
    </div>
</header>
<div class="wraper">
    <ul id="msg-list" class="chart-con-box inner">
    </ul>
    <div class="submit_chat">
        <div class="sub-chat flex box_bottom">
            <div class="icon"><i class="iconfont">&#xe694;</i></div>
            <div class="sub-text">
                <div id="content" class="test_box" contenteditable="true">
                </div>
            </div>
            <div id="send" class="sub-btn">
                发送
            </div>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
setHeight();
var backUnread = {};
var data = {};
var accids = [];   //列表accid
var account = LEMON.db.get('im_accid');
var token = LEMON.db.get('im_token');
var to_account = window.location.href.match(/.*\/chat-detail\/(.*)/)[1];
var to_avatar = '<?= generateImgUrl($to_user->avatar) ?>?w=82&h=82';
var my_avatar = '<?= generateImgUrl($user->avatar) ?>?w=82&h=82';
var nim = NIM.getInstance({
    debug: true,
    appKey: '<?= $imkey ?>',
    account: account,
    token: token,
    onconnect: onConnect,
    onwillreconnect: onWillReconnect,
    ondisconnect: onDisconnect,
    onerror: onError,
    onroamingmsgs: onRoamingMsgs,
    onofflinemsgs: onOfflineMsgs,
    onmsg: onMsg
});
function getHistoryMsgsDone(error, obj) {
    console.log('获取p2p历史消息' + (!error ? '成功' : '失败'));
    console.log(error);
    console.log(obj);
    if (!error) {
        console.log(obj.msgs);
        $('#msg-list').append(getRender(obj.msgs));
        scrollTop();
    }
}
function onConnect() {
    console.log('连接成功');
    nim.getHistoryMsgs({
        scene: 'p2p',
        to: to_account,
        limit: 15,
        asc: true,
        done: getHistoryMsgsDone
    });
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
function onError(error) {
    console.log(error);
}
function onRoamingMsgs(obj) {
    console.log('收到漫游消息', obj);
    pushMsg(obj.msgs);
}
function onOfflineMsgs(obj) {
    console.log('收到离线消息', obj);
    pushMsg(obj.msgs);
}
function onMsg(msg) {
    console.log('收到消息', msg.scene, msg.type, msg);
    if (msg.scene !== 'p2p' || (msg.to !== to_account && msg.from !== to_account)) {
        return false;
    }
    console.log('收到我的消息', msg.scene, msg.type, msg);
    $('#msg-list').append(getRender(msg));
    pushMsg(msg);
    switch (msg.type) {
        case 'custom':
            onCustomMsg(msg);
            break;
        case 'notification':
            // 处理群通知消息
            onTeamNotificationMsg(msg);
            break;
        default:
            break;
    }
}
function pushMsg(msgs) {
    if (!Array.isArray(msgs)) {
        msgs = [msgs];
    }
    var sessionId = msgs[0].sessionId;
    data.msgs = data.msgs || {};
    data.msgs[sessionId] = nim.mergeMsgs(data.msgs[sessionId], msgs);
}
function onCustomMsg(msg) {
    // 处理自定义消息
}
function getUnread(id, num) {
    var total = LEMON.db.get('num' + id) || 0;
    if (num)
        total++;
    LEMON.db.set('num' + id, total);
    return total;
}
function setRead(id) {
    backUnread[id] = 0;
    LEMON.db.set('num' + id, 0);
    $('#chat-' + id).find('.num').html(0).hide();
}

function getRender(msgs) {
    $.each(msgs, function (i, msg) {
        if (msg.flow === 'out') {
            msg['is_out'] = true;
            msg['avatar'] = my_avatar;
        } else {
            msg['is_out'] = false;
            msg['avatar'] = to_avatar;
        }
        msg['is_custom'] = false;
        if (msg.type === 'custom') {
            msg['is_custom'] = true;
            var content = JSON.parse(msg.content);
            console.log(content);
            if (content.type == 6) {
                //礼物
                msg.text = '[礼物]';
            }
            if (content.type == 5) {
                //约单
                if (msg.flow === 'out') {
                    //发出
                    msg.text = content.data.from.msg_prefix + content.data.from.msg_body +
                            '<a href="' + content.data.from.msg_link + '">[' + content.data.from.msg_link_text + ']</a>';
                } else {
                    msg.text = content.data.to.msg_prefix + content.data.to.msg_body +
                            '<a href="' + content.data.to.msg_link + '">[' + content.data.to.msg_link_text + ']</a>';
                }
            }
        }
    })
    var mus_data = {};
    mus_data['msgs'] = msgs;
    var template = $('#msg-list-tpl').html();
    Mustache.parse(template);
    var rendered = Mustache.render(template, mus_data);
    return rendered;
}
$('#send').on('tap', function () {
    var text = $('#content').text();
    sendTextMsg(text);
    scrollTop();
    $('#content').text('');
});

function sendTextMsg(text) {
    var msg = nim.sendText({
        scene: 'p2p',
        to: to_account,
        text: text,
        done: sendMsgDone
    });
    console.log(msg);
    $('#msg-list').append(getRender([msg]));
    console.log('正在发送p2p text消息, id=' + msg.idClient);
    pushMsg(msg);
}
function sendMsgDone(error, msg) {
    console.log(error);
    console.log(msg);
    console.log('发送' + msg.scene + ' ' + msg.type + '消息' + (!error ? '成功' : '失败') + ', id=' + msg.idClient);
    pushMsg(msg);
}
function setHeight() {
    $('#msg-list').height($(window).height() - $('header').height() - $('.submit_chat').height());
}
function scrollTop(){
   $('#msg-list').get(0).scrollTop = $('#msg-list').get(0).scrollHeight; 
}
</script>
<?php $this->end('script'); ?>