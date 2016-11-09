<style type="text/css">
    *{margin:0;padding:0;}
    .checkdate{
        position:fixed;
        bottom:0;
        max-width:750px;
        width:100%;
        height:200px;
        background: #fff url(/mobile/css/img/line.png) repeat-x  0 40px;
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
        -webkit-box-shadow: 0 0 15px rgba(0,0,0,.2);
        box-shadow: 0 0 15px rgba(0,0,0,.2);
    }
    .hide_date{
        height:0;
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
    }
    .l_box{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:50%;
        float:left;
        height:100px;
    }
    .r_box_1{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:25%;
        float:left;
        height:100px;
    }
    .r_box_2{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:25%;
        float:left;
        height:100px;
    }
    .l_box::-webkit-scrollbar,.r_box_1::-webkit-scrollbar,.r_box_2::-webkit-scrollbar{display: none;}
    .checkdate li{line-height: 40px;height:40px;width:100%;font-size:14px;color:#ccc;}
    .month-date{width:100%;overflow:hidden;text-align: center;}
    .start-time{text-align: center;width:100%;overflow:hidden;}
    .end-time{text-align: center;width:100%;overflow:hidden;}
    .bottom_btn{height:40px;line-height: 40px; background-color: #eab96a; color:white;
    }
    .l_sure{text-align: center;width:50%;float:left;}
    .r_cancel{text-align: center;width:50%;float:left;}
    .c_date{overflow:hidden;}
    .checkdate .select{font-size:16px;color:#222;}


</style>
<div class="wraper">
</div>
<div class="checkdate hide_date">
    <div class="bottom_btn">
        <span class="l_sure" onclick="hideDialog()">取消</span>
        <span class="r_cancel" onclick="submitDialog()">确定</span>
    </div>
    <p></p>
    <div class="c_date">
        <div class="l_box">
            <ul class="month-date">
            </ul>
        </div>
        <div class="r_box_1">
            <ul class="start-time">
                <li val='00:00:00'>00:00</li>
                <li val='01:00:00'>01:00</li>
                <li val='02:00:00'>02:00</li>
                <li val='03:00:00'>03:00</li>
                <li val='04:00:00'>04:00</li>
                <li val='05:00:00'>05:00</li>
                <li val='06:00:00'>06:00</li>
                <li val='07:00:00'>07:00</li>
                <li val='08:00:00'>08:00</li>
                <li val='09:00:00'>09:00</li>
                <li val='10:00:00'>10:00</li>
                <li val='11:00:00'>11:00</li>
                <li val='12:00:00'>12:00</li>
                <li val='13:00:00'>13:00</li>
                <li val='14:00:00'>14:00</li>
                <li val='15:00:00'>15:00</li>
                <li val='16:00:00'>16:00</li>
                <li val='17:00:00'>17:00</li>
                <li val='18:00:00'>18:00</li>
                <li val='19:00:00'>19:00</li>
                <li val='20:00:00'>20:00</li>
                <li val='21:00:00'>21:00</li>
                <li val='22:00:00'>22:00</li>
                <li val='23:00:00'>23:00</li>
                <li ></li>
                <li ></li>
            </ul>
        </div>
        <div class="r_box_2">
            <ul class="end-time">
                <li val='00:00:00'>00:00</li>
                <li val='01:00:00'>01:00</li>
                <li val='02:00:00'>02:00</li>
                <li val='03:00:00'>03:00</li>
                <li val='04:00:00'>04:00</li>
                <li val='05:00:00'>05:00</li>
                <li val='06:00:00'>06:00</li>
                <li val='07:00:00'>07:00</li>
                <li val='08:00:00'>08:00</li>
                <li val='09:00:00'>09:00</li>
                <li val='10:00:00'>10:00</li>
                <li val='11:00:00'>11:00</li>
                <li val='12:00:00'>12:00</li>
                <li val='13:00:00'>13:00</li>
                <li val='14:00:00'>14:00</li>
                <li val='15:00:00'>15:00</li>
                <li val='16:00:00'>16:00</li>
                <li val='17:00:00'>17:00</li>
                <li val='18:00:00'>18:00</li>
                <li val='19:00:00'>19:00</li>
                <li val='20:00:00'>20:00</li>
                <li val='21:00:00'>21:00</li>
                <li val='22:00:00'>22:00</li>
                <li val='23:00:00'>23:00</li>
                <li ></li>
                <li ></li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">

    var currentDate = new Date();
    var _year_month_date = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate(),
        _start_time = '00:00:00',
        _end_time = '03:00:00',
        _func;


    // 月日
    $('.l_box').on('scroll', function () {
        var scrollTop = $(this).get(0).scrollTop;
        var height = $('.l_box li').height();
        var num = Math.floor(scrollTop / height);
        $('.l_box li').removeClass().eq(num).addClass('select');
        _year_month_date = $('.l_box li').eq(num).attr('val');
    })


    // 开始时间
    $('.r_box_1').on('scroll', function () {
        var scrollTop = $(this).get(0).scrollTop;
        var height = $('.r_box_1 li').height();
        var num = Math.floor(scrollTop / height);
        $('.r_box_1 li').removeClass().eq(num).addClass('select');
        _start_time = $('.r_box_1 li').eq(num).attr('val');
    });


    // 结束时间
    $('.r_box_2').on('scroll', function () {
        var scrollTop = $(this).get(0).scrollTop;
        var height = $('.r_box_2 li').height();
        var num = Math.floor(scrollTop / height);
        $('.r_box_2 li').removeClass().eq(num).addClass('select');
        _end_time = $('.r_box_2 li').eq(num).attr('val');
    })


    var mydateTimePicker = function() {};


    mydateTimePicker.prototype.show = function(func) {

        _cfunc = func;
        LEMON.sys.hideKeyboard();
        //获取当前时间
        var date = new Date();

        var tem = date.getTime();

        var getMonthDateHtml = function(hs) {

            var d = new Date(hs);
            return "<li val='"+ d.getFullYear() + "-" + (d.getMonth() + 1) +"-"+ d.getDate() + "'>" + (d.getMonth() + 1) + "月" + d.getDate() + "日</li>";

        };

        //初始化时间选择器
        var str = "";
        for (var i = 0; i < 30; i ++) {

            str += getMonthDateHtml(tem + i * 3600 * 24 * 1000);

        }

        //显示
        $('.checkdate').removeClass('hide_date');
        $(".month-date").html(str);
    }


    // 确定
    function submitDialog() {

        if(_cfunc){

            var start_datetime = _year_month_date + " " + _start_time;
            var end_datetime = _year_month_date + " " + _end_time;

            current = new Date().getTime();
            start = new Date(start_datetime).getTime();
            end = new Date(end_datetime).getTime();

            if(current >= start) {

                $.util.alert("约会时间不能小于当前时间!");
                return;

            }
            if(((end - start) / (1000 * 60 * 60)) < 3) {

                $.util.alert("约会时长最少3个小时!");
                return;

            }

            _cfunc(start_datetime, end_datetime);
        }
        hideDialog();

    }

    // 隐藏时间选择器
    function hideDialog() {
        $('.checkdate').addClass('hide_date');
    }
</script>

