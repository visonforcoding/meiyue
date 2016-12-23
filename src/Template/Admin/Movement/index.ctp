<?php $this->start('static') ?>   
<link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
<link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?> 
<div  class="col-xs-12">
    <div id="list-bar" data-spy="affix" data-offset-top="200">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <a href="/movement/add" class="btn btn-small btn-warning">
                    <i class="icon icon-plus-sign"></i>添加
                </a>
                <div class="form-group">
                    <label for="keywords">关键字</label>
                    <input type="text" name="keywords" class="form-control" id="keywords" placeholder="输入关键字">
                </div>
                <div class="form-group">
                    <label for="keywords">时间</label>
                    <input type="text" name="begin_time" class="form-control date_timepicker_start" id="keywords" placeholder="开始时间">
                    <label for="keywords">到</label>
                    <input type="text" name="end_time" class="form-control date_timepicker_end" id="keywords" placeholder="结束时间">
                </div>
                <a onclick="doSearch();" class="btn btn-info"><i class="icon icon-search"></i> 搜索</a>
                <a onclick="saveEdit();" class="btn btn-info"><i class="icon icon-save"></i> 保存</a>
                <!--<a onclick="doExport();" class="btn btn-info"><i class="icon icon-file-excel"></i>导出</a>-->
            </div>
        </form>
    </div>
    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
</div>
<?php $this->start('script'); ?>
<script src="/wpadmin/lib/jqgrid/js/jquery.jqGrid.min.js"></script>
<script src="/wpadmin/lib/jqgrid/js/i18n/grid.locale-cn.js"></script>
<script>
                    var lastsel;
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
                            url: "/movement/getDataList",
                            editurl: "/movement/rowEdit",
                            datatype: "json",
                            mtype: "POST",
                            colNames:
                                    ['用户id', '动态类型', '动态内容', '动态图', '视频', '视频封面', '查看数', '点赞数', '审核状态', '创建时间', '更新时间', '操作'],
                            colModel: [
                                {name: 'user.nick', editable: false, align: 'center'},
                                {name: 'type', editable: false, align: 'center', formatter: function (cell, opt, row) {
                                        switch (cell) {
                                            case 1:
                                                cell = '图片动态';
                                                break;
                                            case 2:
                                                cell = '视频动态';
                                                break;
                                            case 3:
                                                cell = '图片动态';
                                                break;
                                            case 4:
                                                cell = '视频动态';
                                                break;
                                        }
                                        return cell;
                                    }},
                                {name: 'body', editable: false, align: 'center'},
                                {name: 'images', editable: false, align: 'center', formatter: function (cell, opt, row) {
                                        return '<a data-id="' + row.id + '" onclick="showImgs(this)"><i class="icon icon-picture"></i></a>';
                                    }},
                                {name: 'video', editable: false, align: 'center'},
                                {name: 'video_cover', editable: false, align: 'center'},
                                {name: 'view_nums', editable: false, align: 'center'},
                                {name: 'praise_nums', editable: false, align: 'center'},
                                {name: 'status', editable: true, align: 'center', formatter: function (cell, opt, row) {
                                        switch (cell) {
                                            case 1:
                                                return '待审核';
                                                break;
                                            case 2:
                                                return '审核通过';
                                                break;
                                            case 3:
                                                return '审核不通过';
                                                break;
                                        }
                                    }, editable:true, edittype: "select", editoptions: {value: "1:待审核;2:审核通过;3:审核不通过"}},
                                {name: 'create_time', editable: false, align: 'center'},
                                {name: 'update_time', editable: false, align: 'center'},
                                {name: 'actionBtn', align: 'center', viewable: false, sortable: false, frozen: true, formatter: actionFormatter}],
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
                            ondblClickRow: function (id) {
                                if (id && id !== lastsel) {
                                    $("#list").jqGrid('restoreRow', lastsel);
                                    $("#list").jqGrid('editRow', id, true);
                                    lastsel = id;
                                }
                            },
                        }).navGrid('#pager', {edit: false, add: false, del: false, view: true})
                                .jqGrid('navButtonAdd', '#pager', {
                                    caption: "",
                                    buttonicon: "ui-icon-save",
                                    onClickButton: function () {
                                        $('#list').jqGrid('saveRow', lastsel, {
                                            successfunc: function (res) {
                                                res = JSON.parse(res.responseText);
                                                $('#list').trigger('reloadGrid');
                                                if (res.status) {
                                                    layer.msg(res.msg);
                                                    return true;
                                                }
                                            }
                                        });
                                    },
                                    position: "last",
                                    title: "",
                                    cursor: "pointer"});
                        $('#list').jqGrid('setFrozenColumns');

                    });

                    function actionFormatter(cellvalue, options, rowObject) {
                        response = '<a title="删除" onClick="delRecord(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-trash"></i> </a>';
                        response += '<a title="查看" onClick="doView(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-eye-open"></i> </a>';
                        response += '<a title="编辑" href="/movement/edit/' + rowObject.id + '" class="grid-btn "><i class="icon icon-pencil"></i> </a>';
                        return response;
                    }

                    function showImgs(t) {
                        var id = $(t).data('id');
                        $.getJSON('/movement/getImgs/' + id, function (res) {
                            layer.photos({
                                photos: res.imgs //格式见API文档手册页
                                , shift: 0 //0-6的选择，指定弹出图片动画类型，默认随机
                            });
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
                                url: '/movement/delete',
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

                    function saveEdit() {
                        $('#list').jqGrid('saveRow', lastsel, {
                            successfunc: function (res) {
                                res = JSON.parse(res.responseText);
                                $('#list').trigger('reloadGrid');
                                if (res.status) {
                                    layer.msg(res.msg);
                                    return true;
                                }
                            }
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
                        $("body").append("<iframe src='/movement/exportExcel?" + searchQueryStr + "' style='display: none;' ></iframe>");
                    }

                    function doView(id) {
                        //查看明细
                        url = '/movement/view/' + id;
                        layer.open({
                            type: 2,
                            title: '查看详情',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['45%', '70%'],
                            content: url//iframe的url
                        });
                    }
</script>
<?php
$this->end();
