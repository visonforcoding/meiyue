<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
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
            $("#list").jqGrid({
                url: "/suggest/getDataList",
                datatype: "json",
                mtype: "POST",
                colNames: [
                    '用户名称',
                    '意见内容',
                    '操作'
                ],
                colModel: [
                    {name: 'user.nick', editable: true, align: 'center'},
                    {name: 'body', editable: true, align: 'center'},
                    {
                        name: 'actionBtn',
                        align: 'center',
                        viewable: false,
                        sortable: false,
                        frozen: true,
                        formatter: actionFormatter
                    }],
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
            response = '<a title="删除" onClick="delRecord(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-trash"></i> </a>';
            return response;
        }

        function delRecord(id) {
            layer.confirm('确定删除？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/suggest/delete',
                    success: function (res) {
                        layer.msg(res.msg);
                        if (res.status) {
                            $('#list').trigger('reloadGrid');
                        }
                    }
                })
            }, function () {
            });
        }
    </script>
<?php
$this->end();
