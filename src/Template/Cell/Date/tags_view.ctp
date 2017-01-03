<!--弹出层-->
<div class="raper show tags-container" hidden>
    <div class="choose-date-mark">
        <div class="title">
            <span id="tag-view-cancel-btn" class="cancel">取消</span>
            <div class="r_btn">
                <span class="complete">完成</span>
            </div>
        </div>
        <div class="mark-content">
            <?php foreach ($list as $item): ?>
                <div class="marks-box">
                    <h3 class="nav-title"><?= $item['name']?></h3>
                    <div class="nav-con">
                        <ul>
                            <?php foreach ($item['children'] as $i): ?>
                            <li class="tag-item" tag-id="<?= $i['id']?>" tag-name="<?= $i['name'] ?>">
                                <?= $i['name'] ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
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
    var _curnum;  //当前选择数量
    TagsPicker.prototype.show = function(func, datas, limit) {
        _func = func;
        _max = (limit)?limit:4;
        _curnum = 0;
        //初始化显示
        $(".tag-item").each(function(){
            if(datas.indexOf($(this).attr('tag-id')) != -1) {
                $(this).addClass("active");
                _curnum ++;
            }
        })
        $(".tags-container").show();
    };

    $('.tag-item').on('click', function(){
        if($(this).hasClass('active')) {
            $(this).removeClass("active");
            _curnum --;
        } else {
            if(_curnum < 4) {
                _curnum ++;
                $(this).addClass("active");
            } else {
                $.util.alert('最多选择四个标签');
            }
        }
    });

    $(".complete").on("click", function(){
        var tagsData = [];
        $(".tag-item").each(function(){
            if($(this).hasClass('active')) {
                var tmp = new Array();
                tmp['id'] = $(this).attr('tag-id');
                tmp['name'] = $(this).attr('tag-name');
                tagsData.push(tmp);
            }
        })

        if(_func) {
            if(tagsData.length > _max) {
                $.util.alert("标签不能超过" + _max + "个!");
                return;
            }
            _func(tagsData);
            $(".tags-container").hide();
        }
    });

</script>

