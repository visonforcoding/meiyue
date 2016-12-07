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
        height: 245px;
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

    .picker .l_box_cost {
        text-align: center;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index: 999;
        width: 100%;
        height: 200px;
    }

    .picker .l_box_cost::-webkit-scrollbar, .r_box::-webkit-scrollbar {
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
<div class='raper show' id="costs-picker" hidden>
<div class="picker">
    <div class="title inner flex flex_justify">
        <span class="l_sure" id="cost-cancel-btn">取消</span>
        <span class="r_cancel" id="cost-submit-btn">确定</span>
    </div>
    <div class="c_date">
        <div class="l_box_cost" style='width:100%;'>
            <ul class="items">
                <li></li>
                <?php foreach ($list as $item): ?>
                    <li val='<?= $item->id; ?>'><?= $item->money; ?>美币</li>
                <?php endforeach; ?>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
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
            this.curval = {
                'cost_id': <?= (isset($list)&&(count($list[0]) > 0))?$list[0]['id']:''; ?>,
                'cost': <?= (isset($list)&&(count($list[0]) > 0))?$list[0]['money']:0; ?>
            };
        },
        show: function() {
            $("#costs-picker").show();
        },
        hide: function() {
            $('#costs-picker').hide();
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
            $('.l_box_cost').on('scroll', function () {
                var scrollTop = $(this).get(0).scrollTop;
                var height = $('.l_box_cost li').height();
                var num = Math.floor(scrollTop / height) + 1;
                $('.l_box_cost li').removeClass('select').eq(num).addClass('select');
                obj.curval.cost_id = $('.l_box_cost li').eq(num).attr('val');
                obj.curval.cost = $('.l_box_cost li').eq(num).text();
            })
        }

    });

</script>

