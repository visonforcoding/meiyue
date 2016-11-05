<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script id="user-list-tpl" type="text/html">
    {{#users}}
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
    {{/users}}
</script>
<?php $this->end('static') ?>
<header class="fixedhead">
    <div class="header">
        <a href="/index/index"><span class="l_btn">切换地图</span></a>
        <h1>美约</h1>
        <span class="r_btn iconfont menu">&#xe639;</span>
    </div>
</header>
<div class="wraper">
    <div class="navbar">
        <ul class="inner flex flex_justify">
            <li class="current"><a href="#this">约吃饭</a></li>
            <li><a href="#this">约吃饭</a></li>
            <li><a href="#this">约吃饭</a></li>
            <li><a href="#this">约吃饭</a></li>
            <li><a href="#this">约吃饭</a></li>
        </ul>
    </div>
    <div class="find_list_box">
        <div id="user-list" class="inner">

        </div>
    </div>
</div>
<!--筛选-->
<div class="raper" hidden>
    <div  class="choose_parmes">
        <div  class="inner">
            <div class="height flex">
                <span class="height_left color_y">身高 <i class="">(cm)</i></span>
                <div class="scale">
                    <div class="line flex flex_justify">
                        <h1>160</h1> <h1>170</h1> <h1>175</h1>
                    </div>
                    <div class="block" style="position:relative">
                        <input type="range" min="160" max="175" id="scale" />
                        <div class="" id="line" style="position: absolute; height:6px;width:0;bottom:4px;background: #eab96a;border-radius: 15px;">

                        </div>
                    </div>

                </div>
            </div>
            <div class="height flex">
                <span class="height_left color_y">年龄 <i class="">(岁)</i></span>
                <div class="scale">
                    <div class="line flex flex_justify">
                        <h1>12</h1> <h1>18</h1> <h1>24</h1> <h1>30</h1><h1>36</h1><h1>40+</h1>
                    </div>
                    <input type="range" min="12" max="50" id="age" />
                </div>
            </div>

        </div>
        <div class="inner bdtop">
            <span class="btn sure mt40 ">确定</span>
        </div>
    </div>
</div>
<div style="height:1.4rem"></div>
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
var scale = document.getElementById('scale');
var line = document.getElementById('line');
scale.min = 160;
scale.max = 180;
scale.step = 1;
scale.value = 160;
var num = (scale.value - scale.min) / 20 * 100 + '%';
line.style.width = num;
console.log(num);
scale.addEventListener("touchmove", function () {
    console.log(this.value);
    num = (this.value - scale.min) / 20 * 100 + '%';
    console.log(num);
    line.style.width = num;
});
</script>
<script type="text/javascript">
    var curpage = 1;
    loadUser(curpage);
    function loadUser(page, more = false) {
        $.util.showPreloader();
        var template = $('#user-list-tpl').html();
        Mustache.parse(template);   // optional, speeds up future uses
        $.getJSON('/index/get-user-list/' + page, function (data) {
            window.holdLoad = false
            if (data.code === 200) {
                console.log(data.users);
                var rendered = Mustache.render(template, data);
                if (more) {
                    $('#user-list').append(rendered);
                    if(!data.users.length){
                       window.holdLoad = true;
                    }else{
                        curpage++;
                    }
                } else {
                    $('#user-list').html(rendered);
                }
                $.util.hidePreloader();
            }
        });
    }
    setTimeout(function () {
        $(window).on("scroll", function () {
            $.util.listScroll('user-list', function () {
                //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                loadUser(curpage+1, true);
            })
        });
    }, 2000)
</script>
<?php $this->end('script'); ?>