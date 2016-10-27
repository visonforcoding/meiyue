<header class="bar bar-nav">
    <h1 class='title'>我的</h1>
</header>
<?= $this->element('nav',['active' => 'me']) ?>
<div class="content">
    <div class="list-block media-list" style="margin-top:0px">
        <ul>
            <li>
                <a href="/user/userinfo" class="item-link item-content">
                <div class="item-media">
                    <img class="img-circle" src="/imgs/user/avatar/avatar.jpg" width="60"/>
                    <i class="icon icon-f7"></i>
                </div>
                <div class="item-inner">
                    <div class="item-title-row">
                        <div class="item-title">绾儿</div>
                    </div>
                    <div class="item-subtitle">ID1000425</div>
                </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
</script>
<?php $this->end('script'); ?>