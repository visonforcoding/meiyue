 <style type="text/css">
       .checkbwh{position:fixed;bottom:0;max-width:750px;width:100%;height:240px;
                /*background: #fff url(../css/img/line.png) repeat-x  0 85px;*/
                background: #fff;-webkit-transition: height .2s ease;transition: height .2s ease;
                z-index:999;
                 -webkit-transform: translateZ(0);
            }
            .checkbwh .title{width:100%;height:45px;background: #EAB96A;color:#fff;line-height: 45px;}
            .checkbwh .title span{display: block;}
            .checkbwh .hide_date{height:0;-webkit-transition: height .2s ease;transition: height .2s ease-out;}
            .checkbwh .l_box{text-align: center;overflow: auto;
                -webkit-overflow-scrolling: touch;z-index:999;
                width:100%;
                height:170px;margin-top:-10px;}
            .checkbwh .l_box::-webkit-scrollbar,.checkbwh .r_box::-webkit-scrollbar{display: none;}
            .checkbwh li{line-height: 40px;height:40px;width:100%;font-size:14px;color:#ccc;}
            /*.checkdate span{height:30px;line-height: 30px;}*/
            .checkbwh .items{width:100%;overflow:hidden;text-align: center;}
            .checkbwh .c_date{overflow:hidden;}
            .checkbwh .select{font-size:16px;color:#222;}
            .checkbwh .c_date .c_date_head{height:40px;background: #fff;font-size: 15px;position: relative;z-index: 2;}
            .checkbwh .c_date .c_date_head div{text-align: center;}
        </style>
         <div class="checkbwh" id="checkbwh" hidden>
            <div class="title inner flex flex_justify">
                <span class="l_sure" id="cancel-btn">取消</span>
                <span class="r_cancel" id="submit-btn">确定</span>
            </div>
            <div class="c_date">
                <div class="c_date_head bdbottom flex">
                    <div style='width:33%;'>-胸围-</div>
                    <div style='width:33%;'>-腰围-</div>
                    <div style='width:34%;'>-臀围-</div>
                </div>
                <div  class='flex'>
                <div class="l_box bust" style='width:33%;'>
                    <ul class="items">
                        <li></li>
                        <li val='80'>80</li>
                        <li val='81'>81</li>
                        <li val='82'>82</li>
                        <li val='83'>83</li>
                        <li val='84'>84</li>
                        <li val='85'>85</li>
                        <li val='86'>86</li>
                        <li val='87'>87</li>
                        <li val='88'>88</li>
                        <li val='89'>89</li>
                        <li val='90+'>90+</li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <div class="l_box waist" style='width:34%;'>
                    <ul class="items">
                        <li></li>
                        <li val='55'>55</li>
                        <li val='60'>60</li>
                        <li val='61'>61</li>
                        <li val='62'>62</li>
                        <li val='63'>63</li>
                        <li val='64'>64</li>
                        <li val='65'>65</li>
                        <li val='66'>66</li>
                        <li val='67'>67</li>
                        <li val='68'>68</li>
                        <li val='69'>69</li>
                        <li val='69'>70+</li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                    <div class="l_box hips" style='width:33%;'>
                    <ul class="items">
                        <li></li>
                        <li val='80'>80</li>
                        <li val='81'>81</li>
                        <li val='82'>82</li>
                        <li val='83'>83</li>
                        <li val='84'>84</li>
                        <li val='85'>85</li>
                        <li val='86'>86</li>
                        <li val='87'>87</li>
                        <li val='88'>88</li>
                        <li val='89'>89</li>
                        <li val='90+'>90+</li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                </div>
                <div class="c_date_head bdbottom flex" style="height:10px;"></div>
                </div>
            </div>
            <script type="text/javascript">
                var checkBwh = function(o){
                     var opt = {
                        calfun: null, //回调函数
                        bust: 0,  //胸围
                        waist:0, //腰围
                        hips:0  //臀围
                    }
                    $.extend(this, this.opt, o);
                }
                 $.extend(checkBwh.prototype, {
                    init:function(func, bust, waist, hips){
                        this.calfun = func;
                        this.addEvent();
                        this.bust= bust;
                        this.waist= waist;
                        this.hips= hips;
                        var obj = this;
                        if(!bust) {
                            this.bust= '80';
                        }
                        if(!waist) {
                            this.waist= '60';
                        }
                        if(!hips) {
                            this.hips='80';
                        }
                        $('.bust').find('li').each(function(){
                            if($(this).attr('val') == obj.bust){
                                var num = $(this).index()-1;
                                $('.bust').get(0).scrollTop=num*40;
                                $(this).addClass('select');
                                
                            }
                        })
                        $('.waist').find('li').each(function(){
                            if($(this).attr('val') == obj.waist){
                                var num = $(this).index()-1;
                                $('.waist').get(0).scrollTop=num*40;
                                $(this).addClass('select');
                            }
                        })
                        $('.hips').find('li').each(function(){
                            if($(this).attr('val') == obj.hips){
                                var num = $(this).index()-1;
                                $('.hips').get(0).scrollTop=num*40;
                                $(this).addClass('select');
                            }
                        })
                    },
                   show:function(){
                     $('#checkbwh').show();
                   },
                   hide:function(){
                     $('#checkbwh').hide();
                   },
                   submit:function(){
                    var obj = this;
                    if(!obj.bust){
                        $.util.alert("请选择胸围!");
                        return;
                    }
                    if(!obj.waist){
                        $.util.alert("请选择腰围!");
                        return;
                    }
                    if(!obj.hips){
                        $.util.alert("请选择臀围!");
                        return;
                    }
                    if(obj.calfun){
                        var _bust = obj.bust,
                        _waist = obj.waist,
                        _hips = obj.hips;
                        obj.calfun(_bust,_waist,_hips);

                    }
                     obj.hide();
                   },
                   addEvent:function(){
                    var obj = this;
                    $.util.tap($('#submit-btn'), function(){
                           obj.submit();
                    });
                    $.util.tap($('#cancel-btn'), function(){
                        obj.hide();
                    });
                      // 胸围
                    $('.bust').on('scroll', function () {
                        obj.bust = obj.scrollEvent(this, $('.bust li'));
                    });
                      // 腰围
                    $('.waist').on('scroll', function () {
                        obj.waist = obj.scrollEvent(this, $('.waist li'));
                    });
                      // 臀围
                    $('.hips').on('scroll', function () {
                        obj.hips = obj.scrollEvent(this, $('.hips li'));
                    });
                   },
                   scrollEvent: function(em, content) {
                        var scrollTop = $(em).get(0).scrollTop;
                        var height = content.height();
                        var num = Math.floor(scrollTop / height)+1;
                        content.removeClass().eq(num).addClass('select');
                        return content.eq(num).attr('val');
                    }
                 });
                 // var a = new checkbwh();
                 // a.init(null, '81', '62', '82');
                 
            </script>