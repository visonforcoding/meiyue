<div class="activity_list">
    <div class="date_list">
        <div class="date_list_header">
            <div class="tab-btn alldate current" tab-action="/dates/"><span class="headertab">约会</span></div>
            |
            <div class="tab-btn todate" tab-action=""><span class="headertab">派对</span></div>
            |
            <div class="tab-btn todate" tab-action=""><span class="headertab">头牌</span></div>
        </div>
    </div>
    <div class="activity_list_con">
        <!-- 内容容器 -->
    </div>
</div>

<div style="height:1.6rem"></div>
<!--<div class="activity_tips commonfixed">
    <p>已有47人已处于约会中，剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位···</p>
</div>-->

<div style="height:1.4rem"></div>
<!--底部-->
<?= $this->element('footer', ['active' => 'activity']) ?>

<script id="tpl" type="text/html">
    <div class="date_detail_place inner">
        <h3 class="title"><i class="itemsname color_y">[约吃饭]</i> 海岸城高级西餐厅 美女在等你</h3>
        <div class="place_pic">
                        <span class="place">
                            <img src="../images/date_place.jpg"/>
                        </span>
            <div class="place_info">
                <h3 class="userinfo">范冰冰 <span>23岁</span> <em class="price color_y fr"><i
                            class="lagernum">500</i>元/约会金</em>
                </h3>
                <h3 class="otherinfo">
                    <time class="color_gray"><i class="iconfont">&#xe622;</i> 今日 · 12:00-15:00</time>
                    <address class="color_gray"><i class="iconfont">&#xe623;</i>广东省深圳市福田区 福田口岸</address>
                </h3>
            </div>
        </div>
    </div>
</script>

<script>

    //点击tab的切换动作
    $(".tab-btn").on('click', function(){

        $(".tab-btn").each(function () {

            $(this).removeClass('current');

        });
        $(this).addClass('current');
        var datas = "";
        getNetDatas(action, datas);

    });


    function getNetDatas(action, options) {

        $.ajax({
            url: action,
            type: "POST",
            data: options,
            dataType: "json",
            success:function(res) {

                if(res.status) {

                    $.util.dataToTpl("dates-list-container", "tpl", res.datas, function(d){

                        var start_time = new Date(d.start_time);
                        var end_time = new Date(d.end_time);
                        var timestr = start_time.getFullYear() + "-" + (start_time.getMonth() + 1) + "-" + start_time.getDate() + " " + start_time.getHours() + ":00~" + end_time.getHours() + ":00";

                        var time_tmpstart = (d.start_time).split(" ");
                        var time_tmpend = (d.end_time).split(" ");
                        var year_month_date = time_tmpstart[0];
                        var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
                        var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
                        d.time = year_month_date + " " + start_hour_second + "~" + end_hour_second;
                        d.skill_name = d.skill.name;
                        d.status = statuses[d.status];
                        return d;
                    });

                }

            }

        });

    }

</script>