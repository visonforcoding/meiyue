<div class="col-xs-12">
    <div class="list">
        <!-- 列表头部 -->
        <!-- 列表项组 -->
        <section class="items">
            <div class="item">
                <div class="item-content">
                    <div class="table-bar form-inline">
                        <div class="form-group">
                            <label for="keywords">IM名片检测</label>
                            <input type="text" name="accid" class="form-control" id="keywords" placeholder="输入accid">
                        </div>
                        <a onclick="doCheckIm();" class="btn btn-info"><i class="icon icon-search"></i>检测</a>
                        <a onclick="updateIm();" class="btn btn-info"><i class="icon icon-save"></i> 更新</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- 列表底部 -->
        <footer>
            <div id="show-result" class="col-lg-12" style="height:200px;background: #000;color: #ffffff">
                
            </div>
        </footer>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
    function doCheckIm(){
        //检测im的名片
        var accid = $('[name="accid"]').val();
        $.ajax({
           url:'/dev/checkNetIm',
           data:{accid:accid},
           method:'post',
           dataType:'json',
           success:function(res){
               if(res){
                   $('#show-result').html(JSON.stringify(res,null,4));
               }
           }
        });
    }
    function updateIm(){
        //检测im的名片
       var accid = $('[name="accid"]').val();
        $.ajax({
           url:'/dev/updateNetIm',
           data:{accid:accid},
           method:'post',
           dataType:'json',
           success:function(res){
               if(res){
                   $('#show-result').html(JSON.stringify(res,null,4));
               }
           }
        });
    }
</script>
<?php $this->end('script');