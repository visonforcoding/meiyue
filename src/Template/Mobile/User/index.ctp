<header class="bar bar-nav">
    <h1 class='title'>我的</h1>
</header>
<?= $this->element('nav') ?>
<div class="content">
    <div class="list-block media-list" style="margin-top:0px">
        <ul>
            <li class="item-content item-link">
                <div class="item-media">
                    <img class="img-circle" src="http://gqianniu.alicdn.com/bao/uploaded/i4//tfscom/i3/TB10LfcHFXXXXXKXpXXXXXXXXXX_!!0-item_pic.jpg_250x250q60.jpg" width="60">
                    <i class="icon icon-f7"></i>
                </div>
                <div class="item-inner">
                    <div class="item-title-row">
                        <div class="item-title">绾儿</div>
                    </div>
                    <div class="item-subtitle">ID1000425</div>
                </div>
            </li>
        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script src='/mobile/js/jquery-1.11.1.js'></script>
<script>
    $.getJSON("https://api.github.com/users/jeresig?callback=?", function (json) {
        console.log(json);
    });
    function jsonpCallback(res) {
        console.log(res);
    }
    $.ajax({
        type: 'post',
        url: 'http://m.chinamatop.com/activity/test',
        dataType: 'jsonp',
        jsonpCallback: "jsonpCallback"
    });
</script>
<?php $this->end('script'); ?>