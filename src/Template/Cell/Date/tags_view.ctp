<!--弹出层-->
<div class="raper show tags-container" hidden>
    <div class="choose_account choose_mark">
        <div class="title">
            <span id="tag-view-cancel-btn" class="cancel">取消</span>
            <div class="r_btn">
                <span class="complete">完成</span>
            </div>
        </div>
        <!--内容-->
        <div class="choose_mark_con inner">
            <?php foreach ($list as $item): ?>
                <div class="choose_mark__items">
                    <h3 class="commontitle mt20"><?= $item['name']?></h3>
                    <ul class="bgff">
                        <?php foreach ($item['children'] as $i): ?>
                            <li class="tag-item" tag-id="<?= $i['id']?>" tag-name="<?= $i['name'] ?>">
                                <div class="choose_marks">
                                    <span class="iconfont">&#xe624;</span>
                                    <i><?= $i['name'] ?></i>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>

    $('#tag-view-cancel-btn').on('click', function(){

        $(".tags-container").hide();

    });


    var TagsPicker = function() {};


    var _func;  //回调函数
    var _max;   //最大选择数量
    TagsPicker.prototype.show = function(func, datas, limit) {

        _func = func;
        _max = limit;

        //初始化显示
        $(".tag-item").each(function(){

            if(datas.indexOf($(this).attr('tag-id')) != -1) {

                $(this).addClass("choosed");

            }

        })

        $(".tags-container").show();

    };


    $('.tag-item').on('click', function(){

        if($(this).hasClass('choosed')) {

            $(this).removeClass("choosed");

        } else {

            $(this).addClass("choosed");

        }


    });


    $(".complete").on("click", function(){


        var tagsData = [];
        $(".tag-item").each(function(){

            if($(this).hasClass('choosed')) {

                var tmp = new Array();
                tmp['id'] = $(this).attr('tag-id');
                tmp['name'] = $(this).attr('tag-name');
                tagsData.push(tmp);

            }

        })

        if(_func) {

            if(tagsData.length > _max) {

                alert("标签不能超过");

            }
            _func(tagsData);
            $(".tags-container").hide();

        }

    });

</script>

