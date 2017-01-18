<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <a href="/user/add" class="btn btn-small btn-warning">
                    <i class="icon icon-plus-sign"></i>添加
                </a>
                <div class="form-group">
                    <label for="keywords">关键字</label>
                    <input type="text" name="keywords" class="form-control" id="keywords" placeholder="输入关键字">
                </div>
                <div class="form-group">
                    <label for="statuskw">审核状态</label>
                    <select name="statuskw" class="form-control">
                        <option value="100">全部</option>
                        <option value="3">正在申请</option>
                        <option value="1">审核通过</option>
                        <option value="2">审核不通过</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keywords">时间</label>
                    <input type="text" name="begin_time" class="form-control date_timepicker_start" id="keywords" placeholder="开始时间">
                    <label for="keywords">到</label>
                    <input type="text" name="end_time" class="form-control date_timepicker_end" id="keywords" placeholder="结束时间">
                </div>
                <a onclick="doSearch();" class="btn btn-info"><i class="icon icon-search"></i>搜索</a>
            </div>
        </form>
        <table id="list"><tr><td></td></tr></table>
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
                url: "/user/get-agentlist",
                datatype: "json",
                mtype: "POST",
                colNames:
                    [
                        '用户编号',
                        '用户昵称',
                        '手机号码',
                        '邀请数量',
                        '收入提成',
                        '审核状态',
                        '审核操作',
                        '操作',
                    ],
                colModel: [
                    {name: 'id', editable: true, align: 'center'},
                    {name: 'nick', editable: true, align: 'center'},
                    {name: 'phone', editable: true, align: 'center'},
                    {name: 'invitnum', editable: true, align: 'center'},
                    {name: 'income', editable: true, align: 'center'},
                    {name: 'is_agent', editable: true, align: 'center', formatter: function(cellvalue, options, rowObject) {
                        switch(cellvalue) {
                            case 1:
                                cellvalue = '审核通过';
                                break;
                            case 2:
                                cellvalue = '未申请'
                                break;
                            case 3:
                                cellvalue = '<span style="color:red">正在申请</span>'
                                break;
                        }
                        return cellvalue;
                    }},
                    {name: 'checkBtn', align: 'center', viewable: false, sortable: false, frozen: true, formatter: checkFormatter},
                    {name: 'actionBtn', align: 'center', viewable: false, sortable: false, frozen: true, formatter: actionFormatter}
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
            response = '<a title="删除" onClick="delRecord(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-trash"></i> </a>';
            return response;
        }

        function checkFormatter(cellvalue, options, rowObject) {
            response = '';
            switch(rowObject.is_agent) {
                case 1:
                    response = '<a title="取消资格" onClick="check(' + rowObject.id + ', 2);" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-times"></i> </a>';
                    break;
                case 3:
                    response = '<a title="申请通过" onClick="check(' + rowObject.id + ', 1);" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-check"></i> </a>';
                    break;
            }
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
                    url: '/user/delete',
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


        function check(id, status) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/user/check-agent/' + id + '/' + status,
                success: function (res) {
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
