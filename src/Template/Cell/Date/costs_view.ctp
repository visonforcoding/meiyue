<style type="text/css">
    * {
        margin: 0;
        padding: 0;
    }

    .picker {
        position: fixed;
        bottom: 0;
        max-width: 750px;
        width: 100%;
        height: 180px;
        /*background: #fff url(../css/img/line.png) repeat-x  0 85px;*/
        background: #fff;
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
    }

    .picker .title {
        width: 100%;
        height: 45px;
        background: #EAB96A;
        color: #fff;
        line-height: 45px;
    }

    .picker .title span {
        display: block;
    }

    .hide_date {
        height: 0;
        -webkit-transition: height .2s ease;
        transition: height .2s ease-out;
    }

    .picker .l_box {
        text-align: center;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index: 999;
        width: 100%;
        height: 100px;
    }

    .picker .l_box::-webkit-scrollbar, .r_box::-webkit-scrollbar {
        display: none;
    }

    .picker li {
        line-height: 40px;
        height: 40px;
        width: 100%;
        font-size: 14px;
        color: #ccc;
    }

    /*.checkdate span{height:30px;line-height: 30px;}*/
    .picker .items {
        width: 100%;
        overflow: hidden;
        text-align: center;
    }

    .c_date {
        overflow: hidden;
    }

    .picker .select {
        font-size: 16px;
        color: #222;
    }
</style>
<div class="picker hide_date" id="costs-picker">
    <div class="title inner flex flex_justify">
        <span class="l_sure" id="cost-cancel-btn">取消</span>
        <span class="r_cancel" id="cost-submit-btn">确定</span>
    </div>
    <div class="c_date">
        <div class="l_box" style='width:100%;'>
            <ul class="items">
                <li></li>
                <?php foreach ($list as $item): ?>
                    <li val='<?= $item->id; ?>'><?= $item->money; ?>美币</li>
                <?php endforeach; ?>
                <li></li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">

    var costsPicker = function (o) {

        var opt = {
            calfun: null, //回调函数
            curval: 0,  //当前选中值
        }

        $.extend(this, this.opt, o);
    };

    $.extend(costsPicker.prototype, {

        init: function (func) {
            this.calfun = func;
            this.addEvent();
            this.curval = <?= (isset($list)&&(count($list[0]) > 0))?$list[0]['money']:0; ?>;
        },
        show: function() {
            $("#costs-picker").removeClass('hide_date');
        },
        hide: function() {
            $('#costs-picker').addClass('hide_date');
        },
        addEvent: function () {
            var obj = this;
            $('#cost-submit-btn').on('click', function() {
                if(obj.calfun) {
                    obj.calfun(obj.curval);
                    obj.hide();
                }
            });

            $('#cost-cancel-btn').on('click', function() {
                obj.hide();
            })

            //滑动事件
            $('.l_box').on('scroll', function () {
                var scrollTop = $(this).get(0).scrollTop;
                var height = $('.l_box li').height();
                var num = Math.floor(scrollTop / height) + 1;
                $('.l_box li').removeClass('select').eq(num).addClass('select');
                obj.curval = $('.l_box li').eq(num).attr('val');
            })
        }

    });

</script>

