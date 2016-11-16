<?php
    $date_action = '/date/index';  //定义约会请求地址
    $activity_action = '/activity/index';  //定义派对请求地址
?>
<div class="wraper pd45">
    <div class="activity_list">
        <div class="date_list">
            <div class="date_list_header">
                <div class="tab-btn alldate current" tab-action="<?= $date_action; ?>" tpl_id="date_tpl"><span
                        class="headertab">约会</span></div>
                |
                <div class="tab-btn todate" tab-action="<?= $activity_action; ?>" tpl_id="activity_tpl"><span class="headertab">派对</span></div>
                |
                <div class="tab-btn todate" tab-action=""><span class="headertab">头牌</span></div>
            </div>
        </div>
        <div class="activity_list_con">
            <section class="abanner" hidden>
                <!-- 轮播图容器 -->
                <ul>
                    <li><a href="#this"><img src="/mobile/css/icon/banner1.jpg"/></a></li>
                    <li><a href="#this"><img src="/mobile/css/icon/banner2.jpg"/></a></li>
                    <li><a href="#this"><img src="/mobile/css/icon/banner3.jpg"/></a></li>
                </ul>
            </section>
            <section>
                <!-- 内容容器 -->
                <div id="date_list_container" class="list_container" hidden></div>
                <div id="activity_list_container" class="party_content list_container" hidden></div>
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
    <div class="date_detail_place inner mt20" onclick="window.location.href = '/date-order/join/{#id#}'">
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

<script id="activity_banner_tpl" type="text/html">
</script>

<script id="activity_tpl" type="text/html">
<div class="items">
    <div class="items_pic">
        <img src="/mobile/css/icon/party1.jpg"/>
    </div>
    <div class="items_con">
        <h3 class="items_title">{#title#}</h3>
        <div class="items_time flex flex_justify mt20">
            <div>{#ad#}</div>
            <div>
                <i class="iconfont ico">&#xe64b;</i>
                {#time#}
            </div>
        </div>
    </div>
    <div class="items_adress flex flex_justify">
        <div><i class="iconfont ico">&#xe623;</i>{#site#}</div>
        <div class="button btn_dark" onclick="window.location.href='/activity/view/{#id#}'">
            我要报名
        </div>
    </div>
</div>
</script>

<script>
    var date_action = '<?= $date_action; ?>';
    var activity_action = '<?= $activity_action; ?>';
    getNetDatas('date_tpl', date_action, '');

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

                    $('.list_container').hide();
                    $('.abanner').hide();
                    if(action == date_action) {

                        $.util.alert(action);
                        $('#date_list_container').show();
                        $.util.dataToTpl("date_list_container", tpl_id, res.datas, function (d) {
                            d.skill_name = d.user_skill.skill.name;
                            d.status = statuses[d.status];
                            d.user_name = d.user.nick;
                            d.age = ((new Date()).getFullYear() - (new Date(d.user.birthday)).getFullYear());
                            d.total_price = (((new Date(d.end_time)).getHours() - (new Date(d.start_time)).getHours()) * d.price);
                            return d;
                        });

                    } else if(action == activity_action) {

                        $('.abanner').show();
                        $('#activity_list_container').show();
                        $.util.dataToTpl("activity_list_container", tpl_id, res.datas, function (d) {
                            return d;
                        });

                    }

                }

            }

        });

    }

</script>