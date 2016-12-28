<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <div class="form-group">
                    <label for="keywords">关键字</label>
                    <input
                        type="text"
                        name="keywords"
                        class="form-control"
                        id="keywords"
                        placeholder="输入关键字">
                </div>
                <a onclick="doSearch();" class="btn btn-info"><i class="icon icon-search"></i>搜索</a>
                <!--<a onclick="doExport();" class="btn btn-info"><i class="icon icon-file-excel"></i>导出</a>-->
            </div>
        </form>
        <table id="list">
            <tr>
                <td></td>
            </tr>
        </table>
        <div id="pager"></div>
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
            var actid = <?= $actid; ?>;
            var url = "/activity/getJoinList";
            if(actid) {
                url += '?actid=' + actid;
            }
            $("#list").jqGrid({
                url: url,
                datatype: "json",
                mtype: "POST",
                colNames: [
                    '姓名',
                    '性别',
                    '报名费用',
                    '报名时间',
                    '取消时间',
                    '状态',
                    '审核操作'
                ],
                colModel: [
                    {name: 'user.nick', editable: true, align: 'center'},
                    {name: 'user.gender', editable: true, align: 'center', formatter: function(cellvalue, options, rowObject) {
                        cellvalue = parseInt(cellvalue);
                        switch (cellvalue) {
                            case 1:
                                cellvalue = '男';
                                break;
                            case 2:
                                cellvalue = '女';
                                break;
                        }
                        return cellvalue;
                    }},
                    {name: 'cost', editable: true, align: 'center'},
                    {name: 'create_time', editable: true, align: 'center'},
                    {name: 'cancel_time', editable: true, align: 'center'},
                    {name: 'status', editable: true, align: 'center', formatter: function(cellvalue, options, rowObject) {
                        cellvalue = parseInt(cellvalue);
                        switch (cellvalue) {
                            case 1:
                                cellvalue = '正常';
                                break;
                            case 2:
                                cellvalue = '取消';
                                break;
                            case 3:
                                cellvalue = '待审核';
                                break;
                            case 4:
                                cellvalue = '审核不通过';
                                break;
                        }
                        return cellvalue;
                    }},
                    {
                        name: 'actionBtn',
                        align: 'center',
                        viewable: false,
                        sortable: false,
                        frozen: true,
                        formatter: actionFormatter
                    }
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
            }).navGrid('#pager', {edit: false, add: false, del: false, view: true});
            $('#list').jqGrid('setFrozenColumns');
        });

        function actionFormatter(cellvalue, options, rowObject) {
            response = '<a title="待审核" onClick="check(' + rowObject.id + ', '+ 3 +');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-history"></i> </a>';
            response += '<a title="审核通过" onClick="check(' + rowObject.id + ', '+ 1 +');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-check"></i> </a>';
            response += '<a title="审核不通过" onClick="check(' + rowObject.id + ', '+ 4 +');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-times"></i> </a>';
            return response;
        }

        function check(id, cstatus) {
            $.ajax({
                type: 'post',
                data: {id: id, cstatus: cstatus},
                dataType: 'json',
                url: '/activity/check',
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.status) {
                        $('#list').trigger('reloadGrid');
                    }
                }
            })
        }

        function doSearch() {
            //搜索
            var postData = $('#table-bar-form').serializeArray();
            var data = {};
            $.each(postData, function (i, n) {
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