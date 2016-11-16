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
                                <span class="username"><?= $item['user']['nick']; ?></span>
                                <span class="usersex"><i class="iconfont color_y">&#xe61c;</i><?= getAge($item['user']['birthday']); ?>岁</span>
                            </h3>
                        </div>
                        <div class="praised_list_right">
                            <span class="attractive ">魅力值<i class="numbers">3000</i></span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>