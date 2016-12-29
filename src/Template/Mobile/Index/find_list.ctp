<?php $this->start('static') ?>
<script src="/mobile/js/mustache.min.js"></script>
<script src="/mobile/js/loopScroll.js" type="text/javascript" charset="utf-8"></script>
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
        <span id="selectMenu" class="r_btn iconfont menu">&#xe639;</span>
    </div>
</header>
<div class="wraper">
    <div class="navbar">
        <ul id="selectSkil" class="inner flex flex_justify">
            <li  class="current"><a data-id="0" href="#this">精选</a></li>
            <?php foreach ($skills as $skill): ?>
                <li ><a data-id="<?= $skill->id ?>"><?= $skill->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="find_list_box">
        <div id="user-list" class="inner">

        </div>
    </div>
</div>
<!--筛选-->
<div id="selectMenu_box" class="raper" hidden>
    <div class="choose_parmes">
        <div class="inner">
            <div class="height flex">
                <span class="height_left color_y">身高 <i class="">(cm)</i></span>
                <div class="scale">
                    <div class="line flex flex_justify">
                        <h1>155</h1><h1>160</h1><h1>165</h1><h1>170</h1><h1>175</h1><h1>180</h1><h1>185+</h1>
                    </div>
                    <div id='height' class="block range">
                        <div class='meaBox'></div>
                        <div data-bar="left" class='mea' style="left: 0"></div>
                        <div data-bar="right" class='mea' style="right: 0"></div>
                    </div>
                </div>
            </div>
            <div class="height flex">
                <span class="height_left color_y">年龄 <i class="">(岁)</i></span>
                <div class="scale">
                    <div class="line flex flex_justify">
                        <h1>18</h1><h1>20</h1><h1>24</h1><h1>26</h1><h1>30</h1><h1>35</h1><h1>40+</h1>
                    </div>
                    <div id='age' class="block range">
                        <div class='meaBox'></div>
                        <div data-bar="left" class='mea' style="left: 0"></div>
                        <div data-bar="right" class='mea' style="right: 0"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inner btlight">
            <span id="search" class="btn surebtn mt40 ">确定</span>
        </div>
    </div>
</div>
<div style="height:1.4rem"></div>
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript">
    var curpage = 1;
    var skill = 0;
    var ageL = 0;
    var ageR = 0;
    var heightL = 0;
    var heightR = 0;
    loadUser(curpage);
    function loadUser(page, more, query) {
        $.util.showPreloader();
        var template = $('#user-list-tpl').html();
        Mustache.parse(template);   // optional, speeds up future uses
        if (!query) {
            url = '/index/get-user-list/' + page;
        } else {
            url = '/index/get-user-list/' + page + query;
        }
        $.getJSON(url, function (data) {
            window.holdLoad = false
            if (data.code === 200) {
                console.log(data.users);
                var rendered = Mustache.render(template, data);
                if (more) {
                    $('#user-list').append(rendered);
                    if (!data.users.length) {
                        window.holdLoad = true;
                    } else {
                        curpage++;
                    }
                } else {
                    $('#user-list').html(rendered);
                }
                $.util.hidePreloader();
            }
        });
    }
    $('#selectSkil li a').on('tap', function () {
        //切换技能筛选
        $(this).parents('#selectSkil').find('li').removeClass('current')
        $(this).parents('li').addClass('current');
        curpage = 1;
        skill = $(this).data('id');
        loadUser(curpage, false, '?skill=' + skill+'&ageL='+ageL+'&ageR='+ageR+'&heightL='+heightL+'&heightR='+heightR);
    });
    $('#selectMenu').on('tap', function () {
        onTopRight();
    });
    window.onTopRight = function(){
        $('#selectMenu_box').toggle();
        if(!window.search_height){
            window.search_height = new ranger({dom:$('#height'), range:[155, 185]});
            window.search_age = new ranger({dom:$('#age'), range:[18, 40]});
        }
    }
    $('#search').on('click',function(){
        $('#selectMenu_box').hide();
        var height = window.search_height.reRange;
        var age = window.search_age.reRange;
        console.log(age);
        heightL = height[0];
        heightR = height[1];
        ageL = age[0];
        ageR = age[1];
        loadUser(1, false, '?skill=' + skill+'&ageL='+ageL+'&ageR='+ageR+'&heightL='+heightL+'&heightR='+heightR);
    });
    setTimeout(function () {
        $(window).on("scroll", function () {
            $.util.listScroll('user-list', function () {
                //window.holdLoad = false;  //打开加载锁  可以开始再次加载
                if (skill) {
                    loadUser(curpage + 1, true, '?skill=' + skill+'&ageL='+ageL+'&ageR='+ageR+'&heightL='+heightL+'&heightR='+heightR);
                } else {
                    loadUser(curpage + 1, true);
                }
            })
        });
    }, 2000)
    LEMON.event.unrefresh();
</script>
<?php $this->end('script'); ?>