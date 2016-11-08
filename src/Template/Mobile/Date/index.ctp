<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>约会管理</h1>
    </div>
</header>
<div class="wraper">
    <div class="date_list">
        <div class="date_list_header">
            <div class="date-tab alldate current" tab-action="all"><span class="headertab">全部</span></div> |
            <div class="date-tab todate" tab-action="to"><span class="headertab">待抢单</span></div>
        </div>
        <div class="date_list_con">
            <section style="display: block">
                <!--约会列表显示位置-->
                <ul id="dates-list-container">


                </ul>
            </section>
        </div>
    </div>
</div>
<!--发布约会-->
<div class="fixed_r_submit">
    <span id="publish-date-info">发布<br />约会</span>
</div>

<script type="text/html" id="tpl">
    <li class="date-item" date-id="{#id#}">
        <div class="date_item_des">
            <div class="flex flex_justify bdbottom">
                <h3 class='maxwid70'><i class="itemsname color_y">[{#skill_name#}]</i>{#title#}</h3>
                <span class="price">{#price#}</span>
            </div>
            <div class="flex flex_justify">
                <h3>
                    <time><i class="iconfont">&#xe622;</i>{#time#}</time>
                    <address><i class="iconfont">&#xe623;</i>{#site#}</address>
                </h3>
                <span class="date_type color_error">{#status#}</span>
            </div>
        </div>
    </li>
</script>

<script type="text/javascript">

    //首次获取列表数据
    getNetDatas("");

    $(".toback").on('click', function(){

        history.back();

    });

    var statuses = <?= getDateStatStr(); ?>;
    $("#publish-date-info").on('click', function(){

        location.href = "/date/add";

    });


    //点击tab的切换效果
    $(".date-tab").on('click', function(){

        $(".date-tab").each(function () {

            $(this).removeClass('current');

        });
        $(this).addClass('current');
        var datas = "";
        if($(this).attr('tab-action') == 'to') {

            datas += "status=2";

        }
        getNetDatas(datas);

    });


    function getNetDatas(options) {

        $.ajax({
            url: "/date/index/" + <?= $user->id ?>,
            type: "POST",
            data: options,
            dataType: "json",
            success:function(res) {

                if(res.status) {

                    $.util.dataToTpl("dates-list-container", "tpl", res.datas, function(d){
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

    $(document).on("click", ".date-item", function() {

        window.location.href = '/date/view/' + $(this).attr('date-id');

    });

</script>