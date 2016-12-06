<style type="text/css">
    *{margin:0;padding:0;}
    .picker-modal{
        position:fixed;
        bottom:0;
        max-width:750px;
        width:100%;
        height:200px;
        background: #fff url(/mobile/css/img/line.png) repeat-x  0 40px;
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
        -webkit-box-shadow: 0 0 15px rgba(0,0,0,.2);
        box-shadow: 0 0 15px rgba(0,0,0,.2);
    }
    .modal-hide{
        height:0;
        -webkit-transition: height .2s ease;
        transition: height .2s ease;
    }
    .picker-items-col-wrapper{
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        z-index:999;
        width:50%;
        float:left;
        height:100px;
    }
    .picker-items-col-wrapper ul{
        text-align: center;width:100%;overflow:hidden;
    }
    .picker-items-col-wrapper::-webkit-scrollbar{display: none;}
    .picker-modal li{line-height: 40px;height:40px;width:100%;font-size:14px;color:#999999;}
    .picker-modal-header{height:40px;line-height: 40px; background-color: #eab96a; color:white;}
    .picker-modal-header-btn{text-align: center;width:50%;float:left;}
    .picker-modal-body{overflow:hidden;}
    .picker-modal .select{font-size:16px;color:#222;}


</style>
<div class="picker-modal modal-hide">
    <div class="picker-modal-header">
        <span id="date-cancel-btn" class="picker-modal-header-btn">取消</span>
        <span id="date-submit-btn" class="picker-modal-header-btn">确定</span>
    </div>
    <p></p>
    <div class="picker-modal-body">
        <div id="province-select" class="picker-items-col-wrapper">
            <ul>
                <li ></li>
                <?php foreach ($proviceAreas as $provice): ?>
                    <li <?php if ($provice->name == '安徽'): ?>class="select"<?php endif; ?> data-name="<?= $provice->name ?>" data-id="<?= $provice->id ?>"><?= $provice->name ?></li>
                <?php endforeach; ?>
                <li ></li>
            </ul>
        </div>
        <div id="city-select" class="picker-items-col-wrapper">
            <ul>
            </ul>
        </div>
    </div>
</div>
<script src="/mobile/js/city.js"></script>
<script type="text/javascript">
    var _provice = '';
    var _city = '';
    $.extend($, {
        picker: function (cb) {
            LEMON.sys.hideKeyboard();
            $('#province-select').on('scroll', function () {
                var scrollTop = $(this).get(0).scrollTop;
                var height = $('.picker-items-col-wrapper li').height();
                var num = Math.floor(scrollTop / height) + 1;
                //console.log(num);
                $(this).find('li').removeClass().eq(num).addClass('select');
                provice = $(this).find('li').eq(num).data('name');
                if (_provice != provice) {
                    _provice = provice;
                    (function (str) {
                        setTimeout(function () {
                            if (_provice == str) {
                                $.each(window.citys, function (i, n) {
                                    if (n.name === _provice) {
                                        _citys = n.children;
                                        var html = '<li></li>';
                                        $.each(_citys, function (i, n) {
                                            html += '<li data-name="' + n.name + '">' + n.name + '</li>';
                                        })
                                        html += '<li></li>'
                                        $('#city-select ul').html(html);
                                    }
                                })
                            }
                        }, 300);
                    })(_provice)
                }
            });
            $('#city-select').on('scroll', function () {
                var scrollTop = $(this).get(0).scrollTop;
                var height = $('.picker-items-col-wrapper li').height();
                var num = Math.floor(scrollTop / height) + 1;
                $(this).find('li').removeClass().eq(num).addClass('select');
                city = $(this).find('li').eq(num).data('name')
                if (_city != city) {
                    _city = city;
                }
            });
            $('#date-submit-btn').on('click',function(){
                cb();
                $('.picker-modal').addClass('modal-hide');
            })
            $('#date-cancel-btn').on('click',function(){
                $('.picker-modal').addClass('modal-hide');
            })
        }
    });
//    $.picker(function (a) {
//        console.log(a);
//    })
</script>

