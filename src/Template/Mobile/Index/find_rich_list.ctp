<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="user-list-tpl" type="text/html">
    {{#richs}}
    <dl>
        <a href="/index/homepage/{{id}}">
            <dt>
            <img src="{{avatar}}" alt="" />
            <h1 class="alignright"><time>{{login_time}}</time> | <i>{{distance}}</i></h1>
            </dt>
            <dd class="flex flex_justify find_list_con">
                <span class="username">{{nick}}</span>
                <span class="userinfo"><i class="iconfont color_y">&#xe61d;</i><i class="age">{{age}}</i><i class="job">{{profession}}</i></span>
            </dd>
        </a>
    </dl>
    {{/richs}}
</script>
<?php $this->end('static') ?>
<header>
    <div class="header">
        <h1>土豪财富榜</h1>
    </div>
</header>
<div class="wraper bgff">
    <h3 class="rich_header"></h3>
    <!--土豪第一名-->
    <div class="rich_list_first inner flex">
        <div class="rich_first_left">
            <div class="first_info">
                <div class="first_info_img">
                    <img src="/mobile/images/richman.png" class="richman"/>
                </div>
                <div class="first_info_bg"></div>
            </div>
            <span class="coast color_friends">已消费：37778</span>
        </div>
        <div class="rich_first_right">
            <div class="first_r_info beauty">魅力值 <i class='iconfont color_active'>&#xe61e;</i></div>
            <span class="color_active lagernum">37779999</span>
        </div>
    </div>
    <!--土豪list-->
    <div class="rich_list">
        <ul class="voted_list outerblock"> 
            <li>
                <div class="voted_con flex flex_justify">
                    <div class="flex">
                        <span class="voted_place silver">2</span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                            <h3>
                                <span class="voted_name">范冰冰</span>
                                <span class="voted_number color_gray">已消费：304857美币</span>
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="alignright"><i class='iconfont color_active'>&#xe61e;</i></div>
                        <div class="alignright"><i class='lagernum color_active'>8888888</i></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="voted_con flex flex_justify">
                    <div class="flex">
                        <span class="voted_place silver">3</span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                            <h3>
                                <span class="voted_name">范冰冰</span>
                                <span class="voted_number color_gray">已消费：304857美币</span>
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="alignright"><i class='iconfont color_active'>&#xe61e;</i></div>
                        <div class="alignright"><i class='lagernum color_active'>8888888</i></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="voted_con flex flex_justify">
                    <div class="flex">
                        <span class="voted_place">4</span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                            <h3>
                                <span class="voted_name">范冰冰</span>
                                <span class="voted_number color_gray">已消费：304857美币</span>
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="alignright"><i class='iconfont color_active'>&#xe61e;</i></div>
                        <div class="alignright"><i class='lagernum color_active'>8888888</i></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="voted_con flex flex_justify">
                    <div class="flex">
                        <span class="voted_place">5</span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                            <h3>
                                <span class="voted_name">范冰冰</span>
                                <span class="voted_number color_gray">已消费：304857美币</span>
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="alignright"><i class='iconfont color_active'>&#xe61e;</i></div>
                        <div class="alignright"><i class='lagernum color_active'>8888888</i></div>
                    </div>
                </div>
            </li>
            <li>
                <div class="voted_con flex flex_justify">
                    <div class="flex">
                        <span class="voted_place">6</span>
                        <div class="voted_place_info">
                            <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                            <h3>
                                <span class="voted_name">范冰冰</span>
                                <span class="voted_number color_gray">已消费：304857美币</span>
                            </h3>
                        </div>
                    </div>
                    <div>
                        <div class="alignright"><i class='iconfont color_active'>&#xe61e;</i></div>
                        <div class="alignright"><i class='lagernum color_active'>8888888</i></div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script>
var curpage = 1;
$.util.asyLoadData({gurl: '/index/get-rich-list/', page: curpage, tpl: '#order-list-tpl', id: '#order-list', 
    key: 'orders',func:calFunc});
setTimeout(function () {
    //滚动加载
    $(window).on("scroll", function () {
        $.util.listScroll('order-list', function () {
            $.util.asyLoadData({gurl: '/userc/getDateorders/', page: curpage,
                tpl: '#order-list-tpl', id: '#order-list', more: true, key: 'orders',func:calFunc});
        })
    });
}, 2000);
function calFunc(data){
    //返回格式化回调
    if(data.orders.length){
        $.each(data.orders,function(i,n){
           if($.inArray(n.status,[3])!==-1){
               data.orders[i]['finish_prepay'] = true;  //男方支付完预约金 等待女方确认
           } 
           if($.inArray(n.status,[7])!==-1){
               data.orders[i]['finish_receive'] = true;  //女方确认接单 等待支付尾款
           } 
        });
    }
    console.log(data);
    return data;
}
</script>
<?php $this->end('script'); ?>