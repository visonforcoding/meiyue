<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>她的技能</h1>
    </div>
</header>
<div class="wraper">
    <div class="find_ability">
        <div class="choose_mark_con">
            <?php foreach ($topSkills as $top): ?>
                <?php foreach ($userSkills as $skill): ?>
                    <?php if ($top->id == $skill->skill->parent_id): ?>
                        <div class="choose_mark__items">
                            <h3 class="commontitle mt20  inner"><?= $top->name ?></h3>
                            <ul class="bgff">
                                <li>
                                    <a href="/date-order/order-skill/<?= $skill->id ?>">
                                        <div class="choose_marks">
                                            <span class="iconfont">&#xe624;</span>
                                            <i><?= $skill->skill->name ?></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div style='height:1rem;'></div>