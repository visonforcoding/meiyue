<?php $this->start('static') ?>
<script src="/mobile/js/NIM_Web_NIM_v3.2.0.js"></script>
<script src="/mobile/js/mustache.min.js"></script>
<script id="chat-list-tpl" type="text/html">
    {{#sessions}}
    <li id="chat-{{to}}" class="active flex">
        <div data-accid="{{to}}" data-id="{{user_id}}" data-avatar="{{avatar}}" data-nick="{{nick}}"  
             class="ablock flex flex_justify user clickable">
            <div class="chat-left-info flex">
                <div class="avatar">
                    <img src="{{avatar}}"/>
                    <div class="num" {{unreadst}} {{unread}}></div>
                </div>
                <div class="chat-text">
                    <h3 class="name">{{nick}}</h3>
                    <span class="last-info line1">{{lastMsg.text}}</span>
                </div>
            </div>
            <time class="smalldes">{{datetime}}</time>
        </div>
        <div class="r-btn flex">
            <?php if ($user->gender == 1): ?>
                <!--<div data-id="{{user_id}}" class="focus clickable">关注</div>-->
            <?php endif; ?>
            <div data-accid="{{to}}" class="del clickable">删除</div>
        </div>
    </li>
    {{/sessions}}
</script>
<?php $this->end('static') ?>
<!-- <header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>消息</h1>
        <span class="r_btn">忽略全部</span>
    </div>
</header> -->
<div class="wraper">
    <ul class="chatBox">
        <li>
            <a href="/user/share" class="a-height flex flex_justify">
                <div class="l-info-name">邀请好友注册</div>
                <div> <span class='color_gray'>成为合伙人</span> <i class="iconfont rcon">&#xe605;</i></div>
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
                <div class="tips-box"><?php if ($unread): ?><span class="tips"></span><?php endif; ?><i class="iconfont rcon">&#xe605;</i></div>
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
var backUnread = {};
var sessList = [];
var render;
var data = {};
var accids = [];   //列表accid
//var account = LEMON.db.get('im_accid');
var account = '<?=$user->imaccid?>';
//var token = LEMON.db.get('im_token');
var token = '<?=$user->imtoken?>';
var nim = NIM.getInstance({
    debug: true,
    appKey: '<?= $imkey ?>',
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
    console.log('收到会话列表', sessions);
    sessList = sessions;
    $.each(sessions, function (i, n) {
        accids.push(n.to);
    });
    nim.getUsers({
        accounts: accids,
        done: getUsersDone
    });
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
        sessList = [session];
        accids.push(newSess);
        nim.getUsers({
            accounts: [newSess],
            done: getNewUsersDone
        });
    } else {
        //旧会话 新消息
        $obj = $('#chat-' + newSess);
        if (!session.lastMsg.text) {
            var content = JSON.parse(session.lastMsg.content);
            switch (content.type) {
                case 5:
                    session.lastMsg.text = '[约单]';
                    break;
                case 6:
                    session.lastMsg.text = '[礼物]';
                    break;
            }
        }
        var index = $obj.index();
        if (index !== 0) {
            //排到最前面
            $obj.remove();
            $('#chat-list').prepend($obj);
        }
        session.unread = getUnread(session.to, session.unread);
        session.unread > 0 && $obj.find('.num').html('').show();
        $obj.find('span.last-info').html(session.lastMsg.text);
        $obj.find('time').html($.util.getImShowTime(new Date(session.updateTime)));
    }
    updateSessionsUI();
}
function getUsersDone(error, users) {
    //获取初始话列表
    console.log(error);
    console.log(users);
    console.log(sessList);
    var res = {users:users};
    render = getRender(sessList, res);
     $('#chat-list').html(render);
    console.log('获取用户名片数组' + (!error ? '成功' : '失败'));
    if (!error) {
        onUsers(users);
    }
}
function getNewUsersDone(error, users) {
    //获取新会话 
    console.log(error);
    console.log(users);
    console.log(sessList);
    var res = {users:users};
    render = getRender(sessList, res);
    $('#chat-list').prepend(render);
    console.log('获取用户名片数组' + (!error ? '成功' : '失败'));
    if (!error) {
        onUsers(users);
    }
}
function onUsers(users) {
    console.log('收到用户名片列表', users);
    data.users = nim.mergeUsers(data.users, users);
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
    var avatar = '<?=$domain?>'+$(this).data('avatar');
    var user_id = $(this).data('id');
    param['imaccid'] = accid;
    param['nick'] = nick;
    param['avatar'] = avatar;
    param['id'] = user_id;
    var res = {obj:param};
    $.util.openTalk(res);
    setRead(accid);
});

//$(document).on('click', '.focus', function () {
//    //关注
//     var user_id = $(this).data('id');
//     var obj = $(this);
//    $.util.ajax({
//        url: '/user/follow',
//        data: {id: user_id},
//        func: function (res) {
//            if (res.status) {
//                if(res.action=='focus'){
//                    obj.text('取消关注');
//                }else{
//                    obj.text('关注');
//                }
//            }
//            $.util.alert(res.msg);
//        }
//    })
//});

$(document).on('click', '.del', function () {
    //删除会话
    var id = $(this).data('accid');
    setRead(id);
    nim.deleteSession({
        scene: 'p2p',
        to: id,
        done: function (error, obj) {
            if (!error) {
                $('#chat-' + id).addClass('remove')
            }
        }
    });
})

function getRender(sessions, res) {
    $.each(sessions, function (i, n) {
        sessions[i]['nick'] = '';
        sessions[i]['avatar'] = '';
        $.each(res.users, function (k, v) {
            if (n.to == v.account) {
                var custom = JSON.parse(v.custom);
                n.unread = getUnread(n.to, n.unread);
                sessions[i]['nick'] = v.nick;
                sessions[i]['avatar'] = v.avatar;
                sessions[i]['datetime'] = $.util.getImShowTime(new Date(n.updateTime));
                sessions[i]['unreadst'] = n.unread > 0 ? '' : 'hidden';
                sessions[i]['user_id'] = custom.id;
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

function getUnread(id, num) {
    var total = LEMON.db.get('num' + id) || num || 0;
    if (num > 0)
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