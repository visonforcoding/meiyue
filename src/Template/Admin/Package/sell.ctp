<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="panel">
        <div class="panel-heading">
            <Strong></Strong>
        </div>
        <br>
        <div class="col-xs-12">
            <form id="table-bar-form">
                <div class="table-bar form-inline">
                    <div class="form-group">
                        <label for="keywords">用户名称</label>
                        <input type="text"
                               name="keywords"
                               class="form-control"
                               id="keywords"
                               placeholder="用户名称">
                    </div>
                    &nbsp;
                    <label for="keywords">购买时间</label>
                    <input type="text"
                           name="begin_time"
                           class="form-control date_timepicker_start"
                           id="keywords"
                           placeholder="开始时间">
                    <label for="keywords">到</label>
                    <input type="text"
                           name="end_time"
                           class="form-control date_timepicker_end"
                           id="keywords"
                           placeholder="结束时间">
                    &nbsp;
                    <a onclick="doSearch();" class="btn btn-info">
                        <i class="icon icon-search"></i>
                        搜索
                    </a>
                </div>
            </form>
            <table id="list"><tr><td></td></tr></table>
            <div id="pager"></div>
        </div>
    </div>


<?php $this->start('script'); ?>
    <script src="/wpadmin/lib/jqgrid/js/jquery.jqGrid.min.js"></script>
    <script src="/wpadmin/lib/jqgrid/js/i18n/grid.locale-cn.js"></script>
    <script>
        $(function () {
            $('#main-content').bind('resize', function () {
                $("#list").setGridWidth($('#main-content').width() - 40);
            });
            $(document).keypress(function (e) {
                if (e.which == 13) {
                    doSearch();
                }
            });
            $.zui.store.pageClear(); //刷新页面缓存清除
            $("#list").jqGrid({
                url: "/package/getSellDatas/<?= $id; ?>",
                datatype: "json",
                mtype: "POST",
                colNames:
                    [
                        '用户名称',
                        '聊天名额',
                        '聊天剩余名额',
                        '查看动态名额',
                        '查看动态剩余名额',
                        '价格',
                        '到期时间',
                        '购买时间',
                    ],
                colModel: [
                    {name:'user.nick',editable:true,align:'center'},
                    {name:'chat_num',editable:true,align:'center'},
                    {name:'rest_chat',editable:true,align:'center'},
                    {name:'browse_num',editable:true,align:'center'},
                    {name:'rest_browse',editable:true,align:'center'},
                    {name:'cost',editable:true,align:'center'},
                    {name:'deadline',editable:true,align:'center'},
                    {name:'create_time',editable:true,align:'center'},
                ],
                pager: "#pager",
                rowNum: window._config.showDef,
                rowList: window._config.pages,
                sortname: "id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                autoencode: true,
                caption: '',
                autowidth: true,
                height: 'auto',
                rownumbers: true,
                fixed: true,
                jsonReader: {
                    root: "rows",
                    page: "page",
                    total: "total",
                    records: "records",
                    repeatitems: false,
                    id: "id"
                },
            }).navGrid(
                '#pager',
                {edit: false, add: false, del: false, view: true}
            );
            $('#list').jqGrid('setFrozenColumns');
        });


        function doSearch() {
            //搜索
            var postData = $('#table-bar-form').serializeArray();
            var data = {};
            $.each(postData,function(i,n){
                data[n.name] = n.value;
            });
            $.zui.store.pageSet('searchData', data); //本地存储查询参数 供导出操作等调用
            $("#list").jqGrid('setGridParam', {
                postData: data
            }).trigger("reloadGrid");
        }
    </script>
<?php
$this->end();
