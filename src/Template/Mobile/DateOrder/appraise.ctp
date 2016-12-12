<header>
    <div class="header">
        <i class="iconfont toback">&#xe602;</i>
        <h1>发表评价</h1>
    </div>
</header>
<div class="wraper">
    <div class="judge_container">
        <div class="avatar">
            <img src="<?= $order->dater->avatar ?>"/>
        </div>
        <h3 class="date_title">[<?= $order->user_skill->skill->name ?>] <?= $order->dater->nick ?></h3>
        <ul class="jude_list" id="judeBox">
            <li data-score="5" id="ontime">
                <span>准时赴约</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="5" id="similar">
                <span>相符程度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
            <li data-score="5" id="attitude">
                <span>服务态度</span>
                <i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont">&#xe62a;</i><i class="iconfont color_y">&#xe62a;</i>
            </li>
        </ul>
        <div class="submit_jude">
            <h3>我要评论</h3>
            <textarea id="comment" name="" rows="" cols="" placeholder="请在此输入评论内容"></textarea>
            <a class="commontips alignright" href="tel:888888">我要投诉</a>
        </div>
    </div>
</div>
<a id="submit" class="identify_footer_potion">提交评价</a>
<!--约Ta弹出层-->
<div class="raper show flex flex_center" style="display:none">
    <!--约Ta弹出层-->
    <div class="popup" style="display: block;">
        <div class="popup_con">
            <p class="aligncenter">投诉电话</p>
            <h3 class="aligncenter lagernum">888888</h3>
        </div>
        <div class="popup_footer flex flex_justify">
            <span class="footerbtn color_y">呼叫</span>
            <span class="footerbtn gopay">取消</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    judge('ontime');
    judge('attitude');
    judge('similar');
    function judge(parent) {
        var parentNode = $('#' + parent);
        var liList = parentNode.children('i');
        var num = 5;
        liList.each(function (index) {
            $(this).on('tap', function () {
                for (var j = 0; j <= index; j++) {
                    liList[j].style.color = '#eab96a';
                }
                for (var j = index + 1; j < liList.length; j++) {
                    liList[j].style.color = '#999';
                }
                num = index + 1;
                parentNode.data('score',num);
                console.log("您得了" + (num) + "颗星");
            })

        })
    }
</script>
<?php $this->start('script'); ?>
<script>
    $('#submit').on('tap',function(){
       var appraise_time    = $('#ontime').data('score');
       var appraise_match   = $('#similar').data('score');
       var appraise_service  = $('#attitude').data('score');
       var appraise_body = $('#comment').val();
       $.util.ajax({
          data:{
              appraise_time:appraise_time,
              appraise_match:appraise_match,
              appraise_service:appraise_service,
              appraise_body:appraise_body
          },
          func:function(res){
              if(res.status){
                  $.util.alert('感谢您的评价');
                  setTimeout(function(){
                      window.history.go(-1);
                  },300);
              }
          }
       });
    });
</script>
<?php $this->end('script'); ?>