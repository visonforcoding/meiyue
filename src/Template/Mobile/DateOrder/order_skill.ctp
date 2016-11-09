<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>约会详情</h1>
        <!--<span class="r_btn">编辑</span>-->
    </div>
</header>
<div class="wraper">
    <div class="find_date_detail">
        <div class="date_top_con flex inner">
            <span class="place"><img src="<?= createImg($data->user->avatar) . '?w=88' ?>"/></span>
            <h3 class="date_top_con_right">
                <span class="date_ability">[<?= $data->skill->name ?>]</span>
                <span class="date_guest"><?= $data->user->nick ?> <i class="iconfont color_y">&#xe61d;</i><i class="age color_y"><?= getAge($data->user->birthday) ?></i></span>
                <span class="date_much"><i><?= $data->cost->money ?></i> 美币/小时</span>
            </h3>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">约会说明</h3>
            <div class="con date_keyword">
                <p><?= $data->description ?></p>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">我的标签</h3>
            <div class="con con_mark">
                <?php foreach ($data->tags as $tag): ?>
                    <a href="#this"><?= $tag->name ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="date_des mt20">
            <h3 class="commontitle inner">邀约时间与地点</h3>
            <div class="con com_choose_time">
                <ul class="outerblock">
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>时间</span>
                            <div id="datetime">
<!--                                <span>09-28 21:00~22:00</span>
                                <i class="iconfont r_con">&#xe605;</i>-->
                                <input id="time" type="text" readonly="true"  value="" placeholder="请选择约会时间" />
                                <input id="start-time" name="start_time" type="text" readonly="true" hidden value=""/>
                                <input id="end-time" name="end_time" type="text" readonly="true" hidden value=""/>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="date_time flex flex_justify">
                            <span>地点</span>
                            <div>
                                <span class="color_gray">请选择</span>
                                <i class="iconfont r_con">&#xe605;</i>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="date_des">
                <h3 class="commontitle inner">总费用</h3>
                <div class="con">
                    <ul class="outerblock">
                        <li>
                            <div class="date_time flex flex_justify">
                                <span>共<i id="lasth" class="color_y">0</i>小时</span>
                                <div>
                                    <span>合计：<i id="total_money" class="lagernum color_y">0</i><i class="color_y">美币</i></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="date_time  flex flex_justify">
                                <span>预约金</span>
                                <div>
                                    <span id="order_money_str">0美币</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <p class="commontips mt10 inner">* 预约金是您对对方的许诺,占总费用的20%;若对方同意后，您爽单，则预约金归对方所有；若对方不同意，则预约金全数退还。</p>
            </div>
            <div class="date_des mt20">
                <h3 class="commontitle inner">支付方式</h3>
                <div class="con">
                    <div class="date_time  flex flex_justify">
                        <span>我的钱包</span>
                        <div class="color_y"><?=$user->money?> 美币</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="height:1.4rem;"></div>
    <div class="bottomblock">
        <div class="flex flex_end">
            <span class="total">预约金：<i class="color_y">￥</i> <span class="color_y"><i id="order_money" class="color_y lagernum">0</i>美币</span></span>
            <a href="javascript:void(0);" class="nowpay">立即支付</a>
        </div>
        <!--日期时间选择器-->
        <?= $this->element('checkdate'); ?>
        <?php $this->start('script'); ?>
        <script>
            //日期选择回调函数
            function choosedateCallBack(start_datetime, end_datetime) {
                 var lasth = new Date(end_datetime).getHours() - new Date(start_datetime).getHours();
                 $('#lasth').html(lasth);
                 var price = <?= $data->cost->money ?>;
                 $('#total_money').html(lasth*price);
                 $('#order_money_str').html(lasth*price+'x20%='+lasth*price*0.2+'美币');
                 $('#order_money').html(lasth*price*0.2);
                var time_tmpstart = (start_datetime).split(" ");
                var time_tmpend = (end_datetime).split(" ");
                var year_month_date = time_tmpstart[0];
                var start_hour_second = (time_tmpstart[1]).substring(0, (time_tmpstart[1]).lastIndexOf(':'));
                var end_hour_second = (time_tmpend[1]).substring(0, (time_tmpend[1]).lastIndexOf(':'));
                $("#time").val(year_month_date + " " + start_hour_second + "~" + end_hour_second);
                $("#start-time").val(start_datetime);
                $("#end-time").val(end_datetime);

            }

            $("#datetime").on('click', function () {

                new mydateTimePicker().show(choosedateCallBack);

            });

        </script>
        <?php $this->end('script'); ?>