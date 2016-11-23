
<header>
    <div class="header">
        <span class="iconfont toback">&#xe602;</span>
        <h1>我的动态</h1>
    </div>
</header>
<div class="wraper">
    <div class="tracle_list">
        <section>
            <div class="title inner flex">
                <div class="tracle_title_left">
                    <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                    <h3 class="user_info">
                        <span>魅惑动人</span>
                        <time>8月13日 13:12</time>
                    </h3>
                </div>
            </div>
            <div class="con inner">
                <p class="text">不了解你最终要表达的意思，按常理来说，几天就是3~5天，一天24个小时，具体情况具体分析，发个写真照。</p>
                <ul class="piclist_con">
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                    <li><img src="/mobile/images/user.jpg"/></li>
                </ul>
            </div>
            <div class="tracle_footer flex flex_justify inner">
                <div><span class="tracle_footer_info"><i class="iconfont">&#xe65c;</i> 2000</span><span class="tracle_footer_info"><i class="iconfont">&#xe633;</i> 2000</span></div>
                <div class="tracle_footer_info"><i class="iconfont">&#xe650;</i></div>
            </div>
        </section>
        <section class="mt20">
            <div class="title inner flex">
                <div class="tracle_title_left">
                    <span class="avatar"><img src="/mobile/images/avatar.jpg"/></span>
                    <h3 class="user_info">
                        <span>魅惑动人</span>
                        <time>8月13日 13:12</time>
                    </h3>
                </div>
            </div>
            <div class="con inner">
                <p class="text">不了解你最终要表达的意思，按常理来说，几天就是3~5天，一天24个小时，具体情况具体分析，发个写真照。</p>
                <div class="piclist_con videolist">
                    <img src="../css/icon/party_detail.jpg" alt="" />
                    <i class="iconfont playbtn">&#xe652;</i>
                </div>
            </div>
            <div class="tracle_footer flex flex_justify inner">
                <div><span class="tracle_footer_info"><i class="iconfont">&#xe65c;</i> 2000</span><span class="tracle_footer_info"><i class="iconfont">&#xe633;</i> 2000</span></div>
                <div class="tracle_footer_info"><i class="iconfont">&#xe650;</i></div>
            </div>
        </section>
    </div>
</div>
<!--发布约会-->
<div class="footer_submit_btn">
    <div class="submit_ico_group">
        <div class="submit_ico2 submit_ico" id="picbtn">
            <a href="/userc/tracle-pic"><span class="iconfont">&#xe767;</span></a>
        </div>
        <div class="submit_ico3 submit_ico" id="videobtn">
            <span class="iconfont">&#xe652;</span>
        </div>
        <div class="submit_ico1 submit_ico" id="submitbtn" data-type='0'>
            <span>发布<br />动态</span>
        </div>
    </div>
</div>

<!--约Ta弹出层-->
<div class="raper hide flex flex_center">
    <!--约Ta弹出层-->
    <div class="popup" style="display: none;">
        <div class="popup_con">
            <h3 class="aligncenter">确认删除此动态？</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn color_y">确认</span>
            <span class="footerbtn gopay">取消</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#submitbtn').on('tap', function () {
        var data = $(this).data('type');
        switch (data) {
            case '0':
                $('#videobtn').removeClass('moveright').addClass('moveleft');
                $('#picbtn').removeClass('movedown').addClass('moveup');
                $(this).html('<i class="iconfont">&#xe653;</i>');
                $(this).attr('data-type', '1');
                break;
            case '1':
                $('#videobtn').removeClass('moveleft').addClass('moveright');
                $('#picbtn').removeClass('moveup').addClass('movedown');
                $(this).html('<span>发布<br />动态</span>');
                $(this).attr('data-type', '0');
                break;
            default:
                break;
        }
    })
</script>
