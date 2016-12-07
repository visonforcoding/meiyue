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
    .l_box_date{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:50%;
        float:left;
        height:100px;
    }
    .r_box_date_1{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:25%;
        float:left;
        height:100px;
    }
    .r_box_date_2{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:25%;
        float:left;
        height:100px;
    }
    .l_box_date::-webkit-scrollbar,.r_box_date_1::-webkit-scrollbar,.r_box_date_2::-webkit-scrollbar{display: none;}
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
<div class='raper show' id="lm-datepicker" hidden>
    <div class="checkdate">
        <div class="bottom_btn">
            <span id="date-cancel-btn" class="l_sure">取消</span>
            <span id="date-submit-btn" class="r_cancel">确定</span>
        </div>
        <p></p>
        <div class="c_date">
            <div class="l_box_date">
                <ul class="month-date">
                </ul>
            </div>
            <div class="r_box_date_1">
                <ul class="start-time">
                    <!--<li val='00:00:00'>00:00</li>
                    <li val='01:00:00'>01:00</li>
                    <li val='02:00:00'>02:00</li>
                    <li val='03:00:00'>03:00</li>
                    <li val='04:00:00'>04:00</li>
                    <li val='05:00:00'>05:00</li>
                    <li val='06:00:00'>06:00</li>
                    <li val='07:00:00'>07:00</li>-->
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
                    <!--<li val='21:00:00'>21:00</li>
                    <li val='22:00:00'>22:00</li>
                    <li val='23:00:00'>23:00</li>-->
                    <li ></li>
                    <li ></li>
                </ul>
            </div>
            <div class="r_box_date_2">
                <ul class="end-time">
                    <!--<li val='00:00:00'>00:00</li>
                    <li val='01:00:00'>01:00</li>
                    <li val='02:00:00'>02:00</li>
                    <li val='03:00:00'>03:00</li>
                    <li val='04:00:00'>04:00</li>
                    <li val='05:00:00'>05:00</li>
                    <li val='06:00:00'>06:00</li>
                    <li val='07:00:00'>07:00</li>
                    <li val='08:00:00'>08:00</li>
                    <li val='09:00:00'>09:00</li>
                    <li val='10:00:00'>10:00</li>-->
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
</div>

<script type="text/javascript">

    var mydateTimePicker = function(o) {
        var opt = {
            calfun: null,  //回调函数
            _year_month_date: null,
            _start_time: '08:00:00',
            _end_time: '11:00:00'
        }
        $.extend(this, this.opt, o);
    };

    $.extend(mydateTimePicker.prototype, {
        init: function(func) {
            this.calfun = func;
            LEMON.sys.hideKeyboard();

            var currentDate = new Date();
            this._year_month_date = currentDate.getFullYear()
                + "/"
                + (currentDate.getMonth() + 1)
                + "/"
                + currentDate.getDate();
            this._start_time = '08:00:00';
            this._end_time = '11:00:00';

            //获取当前时间
            var date = new Date();
            var tem = date.getTime();
            var getMonthDateHtml = function(hs) {
                var d = new Date(hs);
                return "<li val='"
                    + d.getFullYear()
                    + "/"
                    + (d.getMonth() + 1)
                    +"/"
                    + d.getDate()
                    + "'>"
                    + (d.getMonth() + 1)
                    + "月"
                    + d.getDate()
                    + "日</li>";
            };
            //初始化时间选择器
            var str = "";
            for (var i = 0; i < 30; i ++) {
                str += getMonthDateHtml(tem + i * 3600 * 24 * 1000);
            }
            $(".month-date").html(str);

            this.addEvent();
        },
        addEvent() {
            var obj = this;
            // 月日
            $('.l_box_date').on('scroll', function () {
                obj._year_month_date = obj.scrollEvent(this, $('.l_box_date li'));
                /*var scrollTop = $(this).get(0).scrollTop;
                var height = $('.l_box_date li').height();
                var num = Math.floor(scrollTop / height);
                $('.l_box_date li').removeClass().eq(num).addClass('select');
                obj._year_month_date = $('.l_box_date li').eq(num).attr('val');*/
            })


            // 开始时间
            $('.r_box_date_1').on('scroll', function () {
                obj._start_time = obj.scrollEvent(this, $('.r_box_date_1 li'));
                /*var scrollTop = $(this).get(0).scrollTop;
                var height = $('.r_box_date_1 li').height();
                var num = Math.floor(scrollTop / height);
                $('.r_box_date_1 li').removeClass().eq(num).addClass('select');
                obj._start_time = $('.r_box_date_1 li').eq(num).attr('val');*/
            });


            // 结束时间
            $('.r_box_date_2').on('scroll', function () {
                obj._end_time = obj.scrollEvent(this, $('.r_box_date_2 li'));
                /*var scrollTop = $(this).get(0).scrollTop;
                var height = $('.r_box_date_2 li').height();
                var num = Math.floor(scrollTop / height);
                $('.r_box_date_2 li').removeClass().eq(num).addClass('select');
                obj._end_time = $('.r_box_date_2 li').eq(num).attr('val');*/
            });

            $('#date-cancel-btn').on('click', function() {
                obj.hide();
            });

            $('#date-submit-btn').on('click', function() {
                obj.submit();
            });
        },
        show: function() {
            //显示
            $('#lm-datepicker').show();
        },
        hide: function() {
            $('#lm-datepicker').hide();
        },
        submit: function() {
            var obj = this;
            if(obj.calfun){
                var start_datetime = obj._year_month_date + " " + obj._start_time;
                var end_datetime = obj._year_month_date + " " + obj._end_time;

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
                obj.calfun(start_datetime, end_datetime);
            }
            obj.hide();
        },
        scrollEvent: function(em, content) {
                var scrollTop = $(em).get(0).scrollTop;
                var height = content.height();
                var num = Math.floor(scrollTop / height);
                content.removeClass().eq(num).addClass('select');
                return content.eq(num).attr('val');
        }
    });
</script>

