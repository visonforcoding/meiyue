<?php $this->start('static') ?>
<script src="/mobile/js/NIM_Web_NIM_v3.2.0.js"></script>
<?php $this->end('static');?>
<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>范美美</h1>
        <span class="iconfont r_btn">&#xe65d;</span>
    </div>
</header>
<div class="wraper">
    <ul class="chart-con-box inner">
        <li class="split-time"><time>16:09</time></li>
        <li class="pull-left">
            <div class="chat-con flex  box_start">
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
                <div class="chatbox">
                    您好，在吗？今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗？
                </div>
            </div>
        </li>
        <li class="pull-left">
            <div class="chat-con flex box_start">
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
                <div class="chatbox">
                    <div class="gift-box">
                        <img src="/mobile/images/gift01.png"/>
                    </div>
                    <div class="gift-num aligncenter">
                        飞吻 x <i>1</i>
                    </div>
                    <div class="beauty-num aligncenter">
                        魅力：<i class='color_y'>+50</i>
                    </div>
                </div>
            </div>
        </li>
        <li class="pull-left">
            <div class="chat-con flex box_start">
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
                <div class="chatbox">
                    <div class="gift-box">
                        <img src="/mobile/images/gift02.png"/>
                    </div>
                    <div class="gift-num aligncenter">
                        爱心 x <i>1</i>
                    </div>
                    <div class="beauty-num aligncenter">
                        魅力：<i class='color_y'>+50</i>
                    </div>
                </div>
            </div>
        </li>
        <li class="split-time"><time>17:09</time></li>
        <li class="pull-right">
            <div class="chat-con flex">
                <div class="chatbox">
                    有空。约不？
                </div>
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
            </div>
        </li>
        <li class="split-time"><time>17:09</time></li>
        <li class="split-time"><time>20:09</time></li>
        <li class="pull-left">
            <div class="chat-con flex">
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
                <div class="chatbox">
                    您好，在吗？
                </div>
            </div>
        </li>
        <li class="split-time"><time>21:09</time></li>
        <li class="pull-right">
            <div class="chat-con flex">
                <div class="chatbox">
                    您好，在吗？今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗今晚有空吗？
                </div>
                <div class="avatar">
                    <img src="/mobile/images/avatar.jpg"/>
                </div>
            </div>
        </li>
    </ul>
    <div style="height:70px;"></div>
    <div class="submit_chat">
        <div class="sub-chat flex box_bottom">
            <div class="icon"><i class="iconfont">&#xe694;</i></div>
            <div class="sub-text">
                <div class="test_box" contenteditable="true">
                </div>
            </div>
            <div class="sub-btn">
                发送
            </div>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script type="text/javascript">
    var backUnread = {};
    var data = {};
    var accids = [];   //列表accid
    var account = LEMON.db.get('im_accid');
    var token = LEMON.db.get('im_token');
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


//function getUnread (id, num){
//    var total=0, old = backUnread.hasOwnProperty(id) ? backUnread[id] : LEMON.db.get('num'+id);
//    old = parseInt(old) ? parseInt(old) : 0;
//    if(!backUnread.hasOwnProperty(id)) backUnread[id] = old;
//    if(num || old){
//        //total = num + old;
//        if(num) total++;
//        LEMON.db.set('num'+id, total);
//    }
//    return total;
//}
//function setRead (id){
//    backUnread[id] = 0;
//    LEMON.db.set('num'+id, 0);
//    $('#chat-' + id).find('.num').html(0).hide();
//}
</script>
<?php $this->end('script'); ?>