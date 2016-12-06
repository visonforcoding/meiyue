<header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>已报名</h1>
    </div>
</header>
<div class="wraper">
    <ul class="praised_list mt20 bgff">
        <?php if(isset($actres)): ?>
            <?php foreach ($actres as $item): ?>
                <li>
                    <a href="/index/homepage/<?= $item['user']['id']; ?>" class="praised_block">
                        <div class="praised_list_left">
                            <span class="avatar"><img src="<?= $item['user']['avatar']; ?>" alt="" /></span>
                            <h3>
                                <div class="username"><?= $item['user']['nick']; ?>
                                    <span class="age color_y"><i class="iconfont color_y">&#xe61c;</i><?= getAge($item['user']['birthday']); ?>岁</span>
                                </div>
                               <div class="smallnum color_y">魅力值：<i class="">3000</i></div>
                            </h3>
                        </div>
                        <div class="praised_list_right">
                           <span class="support_num">报名数量 <i class="lagernum color_friends">50</i></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>