<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>消息</h1>
    </div>
</header>
<div class="wraper">
    <ul class="chatBox">
        <?php foreach ($users as $user): ?>
        <li>
            <a data-accid="meiyue_<?=$user->id?>" data-avatar="<?=$user->avatar?>" data-nick="<?=$user->nick?>"  
               class="ablock flex flex_justify user">
                <div class="chat-left-info flex">
                    <div class="avatar">
                        <img src="<?=$user->avatar?>"/>
                    </div>
                    <div class="chat-text">
                        <h3 class="name"><?=$user->nick?></h3>
                        <span class="last-info line1">晚上不见不散</span>
                    </div>
                </div>
                <time class="smalldes">16/06/03 18:00</time>
            </a>
        </li>
        <?php endforeach;?>
    </ul>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'chat']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    //$.util.showPreloader('前往登录..');
    $('.user').on('tap',function(){
        var param = {};
        var accid = $(this).data('accid');
        var nick = $(this).data('nick');
        var avatar = $(this).data('avatar');
        param['accid'] = accid;
        param['nick'] = nick;
        param['avatar'] = avatar;
        //param = JSON.stringify(param);
        alert(param);
        LEMON.event.imTalk(param);
    })
</script>
<?php $this->end('script'); ?>