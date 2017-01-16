<nav class="bar bar-tab">
    <a class="tab-item <?php if($active=='find'): ?>active<?php endif;?>" href="/index/find-list">
        <span class="icon icon-home"></span>
        <span class="tab-label">发现</span>
    </a>
    <a class="tab-item <?php if($active=='activity'): ?>active<?php endif;?>" href="#">
        <span class="icon icon-gift"></span>
        <span class="tab-label">活动</span>
    </a>
    <a class="tab-item <?php if($active=='msg'): ?>active<?php endif;?>" href="#">
        <span class="icon icon-message"></span>
        <span class="tab-label">消息</span>
    </a>
    <a class="tab-item <?php if($active=='me'): ?>active<?php endif;?>" href="/user/index">
        <span class="icon icon-me"></span>
        <span class="tab-label">我</span>
    </a>
</nav>
