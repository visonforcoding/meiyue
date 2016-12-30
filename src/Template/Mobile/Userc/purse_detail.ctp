<!-- <header>
    <div class="header">
        <i class="iconfont toback" onclick="history.back();">&#xe602;</i>
        <h1>账单明细</h1>
    </div>
</header> -->
<div class="wraper">
    <div class="puse_bills">
        <ul id="billcontainer" class="puse_bills_con inner">

        </ul>
    </div>
</div>

<script id="bill-tpl" type="text/html">
{{#flows}}
<li>
    <div class="puse_bills_left">
        <h3>{{type_msg}}</h3>
        <time>{{create_time}}</time>
    </div>
    <span class="puse_bills_right">{{#income}}+{{/income}}{{^income}}-{{/income}}{{amount}}</span>
</li>
{{/flows}}
</script>

<?php $this->start('script'); ?>
<script src="/mobile/js/mustache.min.js"></script>
<script>
    var curpage = 1;
    var isend = false;   //数据是否已经全部请求完毕
    var recept = true;  //请求开关
    init();
    getDatas(curpage, false);
    setTimeout(function () {
        $(window).on("scroll", function () {
            var st = document.body.scrollTop;
            var cbodyH = $('#billcontainer').height() - 550;
            if (st >= cbodyH && !isend && recept) {
                console.log('loading');
                getDatas(curpage, true);
            }
        });
    }, 1000);

    function getDatas(curpage, more) {
        recept = false;
        $.util.asyLoadData({
            gurl: '/userc/get-purses/',
            page: curpage,
            tpl: '#bill-tpl',
            id: '#billcontainer',
            more: more,
            key: 'flows',
            func: function(data) {
                recept = true;
                if(data.flows.length == 0) {
                    isend = true;
                    $.util.alert('没有更多数据了');
                } else {
                    data.income = (data.income == 1)?true:false;
                }
                return data;
            }
        });
    }

    function init() {
        setTimeout(function() {
            window.scrollTo(0, 0);
        }, 1000);
    }

    LEMON.sys.back('/userc/my-purse');
</script>
<?php $this->end('script'); ?>
