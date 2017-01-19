<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <a href="/activity/add" class="btn btn-small btn-warning">
                    <i class="icon icon-plus-sign"></i>添加
                </a>
                <div class="form-group">
                    <label for="keywords">关键字</label>
                    <input
                        type="text"
                        name="keywords"
                        class="form-control"
                        id="keywords"
                        placeholder="输入关键字">
                </div>
                <div class="form-group">
                    <label for="statuskw">状态</label>
                    <select name="statuskw" class="form-control">
                        <option value="0">全部</option>
                        <option value="1">正常</option>
                        <option value="2">下架</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keywords">时间</label>
                    <input
                        type="text"
                        name="begin_time"
                        class="form-control date_timepicker_start"
                        id="keywords"
                        placeholder="开始时间">
                    <label for="keywords">到</label>
                    <input
                        type="text"
                        name="end_time"
                        class="form-control date_timepicker_end"
                        id="keywords"
                        placeholder="结束时间">
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
            $("#list").jqGrid({
                url: "/activity/getDataList",
                datatype: "json",
                mtype: "POST",
                colNames: ['派对名称', '时间', '地点', '男性报名费用', '男性剩余名额/总名额', '女性出场费', '女性剩余名额', '活动退出扣钱比例', '报名情况', '派对状态', '取消截止天数', '操作'],
                colModel: [
                    {name: 'title', editable: true, align: 'center'},
                    {name: 'start_time', editable: true, align: 'center'},
                    {name: 'site', editable: true, align: 'center'},
                    {name: 'male_price', editable: true, align: 'center'},
                    {name: 'male_rest', editable: true, align: 'center'},
                    {name: 'female_price', editable: true, align: 'center'},
                    {name: 'female_rest', editable: true, align: 'center'},
                    {name: 'punish_percent', editable: true, align: 'center'},
                    {name: 'status', editable: true, align: 'center'},
                    {name: 'status', editable: true, align: 'center',
                        formatter: function(cellvalue, options, rowObject) {
                            switch (cellvalue) {
                                case 1:
                                    cellvalue = '正常';
                                    break;
                                case 2:
                                    cellvalue = '下架';
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    {name: 'cancelday', editable: true, align: 'center'},
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
            response = '<a title="删除" onClick="delRecord(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-trash"></i> </a>';
            response += '<a title="查看" onClick="doView(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-eye-open"></i> </a>';
            response += '<a title="编辑" href="/activity/edit/' + rowObject.id + '" class="grid-btn "><i class="icon icon-pencil"></i> </a>';
            response += '<a title="置顶" onClick="setTop(' + rowObject.id + ');" class="grid-btn "><i class="icon icon-arrow-up"></i></a>';
            return response;
        }

        function setTop(id) {
            layer.confirm('确定置顶？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/activity/set-top',
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

        function delRecord(id) {
            layer.confirm('确定删除？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/activity/delete',
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

        function doExport() {
            //导出excel
            var sortColumnName = $("#list").jqGrid('getGridParam', 'sortname');
            var sortOrder = $("#list").jqGrid('getGridParam', 'sortorder');
            var searchData = $.zui.store.pageGet('searchData') ? $.zui.store.pageGet('searchData') : {};
            searchData['sidx'] = sortColumnName;
            searchData['sort'] = sortOrder;
            var searchQueryStr = $.param(searchData);
            $("body").append("<iframe src='/activity/exportExcel?" + searchQueryStr + "' style='display: none;' ></iframe>");
        }

        function doView(id) {
            //查看明细
            url = '/activity/join-index/' + id;
            location.href=url;
        }
    </script>
<?php
$this->end();
