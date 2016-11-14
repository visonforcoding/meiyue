<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="order-list-tpl" type="text/html">
    {{#orders}}
    <li>
        <div class="date_item_des">
            <div class="flex flex_justify bdbottom">
                <h3 class='maxwid70'><i class="itemsname color_y">[{{user_skill.skill.name}}]</i>{{user_skill.description}}</h3>
                <span class="customer color_y">{{consumer}}</span>
            </div>
            <div class="place_pic flex flex_justify bdbottom">
                <div class="place_info_desc">
                    <span class="place">
                        <img src="{{dater.avatar}}"/>
                    </span>
                    <div class="place_info">
                        <h3 class="userinfo">{{dater_name}}</h3>
                        <h3 class="otherinfo">
                            <time><i class="iconfont color_y">&#xe622;</i>今日 · 12:00-15:00</time>
                            <address><i class="iconfont color_y">&#xe623;</i>{{site}} </address>
                        </h3>
                    </div>
                </div>
                <span class="price">{{amount}}美币</span>
            </div>
            <div class="flex flex_justify">
                <h3 class="pay_desc color_y">已预付：{{pre_pay}}美币</h3>
                <div class="groupbtn">
                    <span class="refuse">拒绝</span>
                    <span class="orders">接单</span>
                </div>
            </div>
        </div>
    </li>
    {{/orders}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>我的订单</h1>
    </div>
</header>
<div class="wraper">
    <div class="date_list">
        <div class="date_list_header order_header">
            <div class="alldate current">
                <span class="headertab">全部</span>
            </div> | 
            <div class="todate">
                <span class="headertab">等待确认<i class="tips_ico"></i></span>
            </div> | 
            <div class="todate">
                <span class="headertab">进行中<i class="tips_ico"></i></span>
            </div>
        </div>
        <div class="date_list_con">
            <!--
            全部订单
            -->
            <section style="display:block">
                <ul id="order-list">

                </ul>
            </section>

        </div>
    </div>
</div>
<!--发布约会-->
<?php if($user->gender=='2'): ?>
<div class="fixed_r_submit">
    <span>发布<br />约会</span>
</div>
<?php endif;?>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/userc/getDateorders/', page: curpage, tpl: '#order-list-tpl', id: '#order-list', key: 'orders'});
setTimeout(function () {
    $(window).on("scroll", function () {
        $.util.listScroll('order-list', function () {
            $.util.asyLoadData({gurl: '/userc/getDateorders/', page: curpage,
                tpl: '#order-list-tpl', id: '#order-list', more: true, key: 'orders'});
        })
    });
}, 2000);
</script>
<?php $this->end('script'); ?>