<div class="wraper pd45">
    <div class="activity_list">
        <div class="date_list">
            <div class="date_list_header">
                <div class="tab-btn alldate current" tab-action="/date/index" tpl_id="date_tpl"><span
                        class="headertab">约会</span></div>
                |
                <div class="tab-btn todate" tab-action=""><span class="headertab">派对</span></div>
                |
                <div class="tab-btn todate" tab-action=""><span class="headertab">头牌</span></div>
            </div>
        </div>
        <div class="activity_list_con">
            <section id="activity_list_container">
                <!-- 内容容器 -->
            </section>
        </div>
    </div>

    <div style="height:1.6rem"></div>
    <!--<div class="activity_tips commonfixed">
        <p>已有47人已处于约会中，剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位剩余10X个席位···</p>
    </div>-->

    <div style="height:1.4rem"></div>
</div>
<!--底部-->
<?= $this->element('footer', ['active' => 'activity']) ?>

<script id="date_tpl" type="text/html">
    <div class="date_item date_detail_place inner" date-id="{#id#}">
        <h3 class="title"><i class="itemsname color_y">{#skill_name#}</i>{#title#}</h3>
        <div class="place_pic">
                        <span class="place">
                            <img src="/mobile/images/date_place.jpg"/>
                        </span>
            <div class="place_info">
                <h3 class="userinfo">{#user_name#}<span>{#age#}岁</span> <em class="price color_y fr"><i
                            class="lagernum">{#total_price#}</i>元/约会金</em>
                </h3>
                <h3 class="otherinfo">
                    <time class="color_gray"><i class="iconfont">&#xe622;</i>{#time#}</time>
                    <address class="color_gray"><i class="iconfont">&#xe623;</i>{#site#}</address>
                </h3>
            </div>
        </div>
    </div>
</script>

<script>
    getNetDatas('date_tpl', '/date/index', '');

    //点击tab的切换动作
    $(".tab-btn").on('click', function () {

        $(".tab-btn").each(function () {

            $(this).removeClass('current');

        });
        $(this).addClass('current');
        var options = "";
        var actionstr = $(this).attr('tab-action');
        var tpl_id = $(this).attr('tpl_id');
        getNetDatas(tpl_id, actionstr, options);

    });

    var statuses = <?= getDateStatStr()?>;
    function getNetDatas(tpl_id, action, options) {

        $.ajax({
            url: action,
            type: "POST",
            data: options,
            dataType: "json",
            success: function (res) {

                if (res.status) {

                    $.util.dataToTpl("activity_list_container", tpl_id, res.datas, function (d) {

                        console.log(res.datas);
                        var start_time = new Date(d.start_time);
                        var end_time = new Date(d.end_time);
                        var timestr = start_time.getFullYear() + "-" + (start_time.getMonth() + 1) + "-" + start_time.getDate() + " " + start_time.getHours() + ":00~" + end_time.getHours() + ":00";

                        d.time = timestr;
                        d.skill_name = d.user_skill.skill.name;
                        d.status = statuses[d.status];
                        d.user_name = d.user.nick;
                        d.age = ((new Date()).getFullYear() - (new Date(d.user.birthday)).getFullYear());
                        d.total_price = (((new Date(d.end_time)).getHours() - (new Date(d.start_time)).getHours()) * d.price);
                        return d;
                    });

                }

            }

        });

    }

    $(document).on('click', '.date_item', function(){

        var date_id = $(this).attr("date-id");
        window.location.href = "/date-order/join/" + date_id;

    })

</script>