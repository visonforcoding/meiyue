<div class="footer">
    <ul class="clearfix">
        <li <?php if($active=='find'): ?>class="active"<?php endif;?>>
            <span class="bar-find">
                <a href="/index/index">
                    <i class="iconfont">&#xe613;</i>发现
                </a>
            </span>
        </li>
        <li <?php if($active=='activity'): ?>class="active"<?php endif;?>>
            <span class="bar-activity">
                <?php if(isset($user)): ?>
                    <?php if($user->gender == 1): ?>
                        <a href="/activity/index">
                            <i class="iconfont">&#xe64a;</i>活动
                        </a>
                    <?php else: ?>
                        <a href="/activity/findex">
                            <i class="iconfont">&#xe64a;</i>活动
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/activity/index">
                        <i class="iconfont">&#xe64a;</i>活动
                    </a>
                <?php endif; ?>
            </span>
        </li>
        <li <?php if($active=='chat'): ?>class="active"<?php endif;?>>
            <span class="bar-chat">
                <a href="/chat/chat-list">
                    <i class="iconfont">&#xe603;</i>私聊
                </a>
            </span>
        </li>
        <li <?php if($active=='me'): ?>class="active"<?php endif;?>>
            <span class="bar-home">
                <a href="/user/index">
                    <i class="iconfont">&#xe616;</i>我的
                </a>
            </span>
        </li>
    </ul>
</div>
