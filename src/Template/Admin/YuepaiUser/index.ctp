<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <!--<a href="/yuepai-user/add" class="btn btn-small btn-warning">
                    <i class="icon icon-plus-sign"></i>添加
                </a>-->
                <div class="form-group">
                    <label for="keywords">用户名称</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        id="namekey"
                        placeholder="输入用户名称">
                </div>
                <div class="form-group">
                    <label for="statuskw">审核状态</label>
                    <select name="statuskw" class="form-control">
                        <option value="100">全部</option>
                        <option value="1">审核通过</option>
                        <option value="2">待审核</option>
                        <option value="3">审核不通过</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keywords">所在地区</label>
                    <input
                        type="text"
                        name="area"
                        class="form-control"
                        id="areakey"
                        placeholder="输入地区">
                </div>
                <div class="form-group">
                    <label for="keywords">时间</label>
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
                </div>
                <a onclick="doSearch();" class="btn btn-info">
                    <i class="icon icon-search"></i>
                    搜索
                </a>
            </div>
        </form>
        <table id="list"><tr><td></td></tr></table>
        <div id="pager"></div>
    </div>
<?php $this->start('script'); ?>
    <script src="/wpadmin/lib/jqgrid/js/jquery.jqGrid.min.js"></script>
    <script src="/wpadmin/lib/jqgrid/js/i18n/grid.locale-cn.js"></script>
    <script>
        var statuses = <?= CheckStatus::getStatus(CheckStatus::GETJSON);?>;
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
                url: "/yuepai-user/getDataList",
                datatype: "json",
                mtype: "POST",
                colNames:
                    [
                        '用户姓名',
                        '手机号码',
                        '所在地区',
                        '预约时间',
                        '剩余名额',
                        '审核状态',
                        '操作'
                    ],
                colModel: [
                    {name:'name',editable:true,align:'center'},
                    {name:'phone',editable:true,align:'center'},
                    {name:'area',editable:true,align:'center'},
                    {name:'yuepai.act_time',editable:true,align:'center'},
                    {name:'yuepai.rest_num',editable:true,align:'center'},
                    {
                        name:'checked',
                        editable:true,
                        align:'center',
                        formatter: function(cellvalue, options, rowObject) {
                            return statuses[cellvalue];
                        }
                    },
                    {
                        name:'actionBtn',
                        align:'center',
                        viewable:false,
                        sortable:false,
                        frozen:true,
                        formatter:actionFormatter
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
            response = '<a title="删除" '
                + 'onClick="delRecord(' + rowObject.id + ');" '
                + 'data-id="' + rowObject.id
                + '" class="grid-btn ">'
                + '<i class="icon icon-trash"></i> </a>';
            switch (rowObject.checked) {
                case <?= CheckStatus::CHECKED; ?>:
                    response += '<a title="审核不通过" '
                        + 'onClick="doCheck('
                        + rowObject.id + ', <?= CheckStatus::CHECKNO; ?>);" '
                        + 'data-id="' + rowObject.id
                        + '" class="grid-btn ">'
                        + '<i class="icon icon-remove"></i> </a>';
                    break;
                case <?= CheckStatus::CHECKING; ?>:
                case <?= CheckStatus::CHECKNO; ?>:
                    response += '<a title="审核通过" '
                        + 'onClick="doCheck('
                        + rowObject.id + ',<?= CheckStatus::CHECKED; ?>);" '
                        + 'data-id="' + rowObject.id
                        + '" class="grid-btn ">'
                        + '<i class="icon icon-check"></i> </a>';
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
                    url: '/yuepai-user/delete',
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
            $.each(postData,function(i,n){
                data[n.name] = n.value;
            });
            $.zui.store.pageSet('searchData', data); //本地存储查询参数 供导出操作等调用
            $("#list").jqGrid('setGridParam', {
                postData: data
            }).trigger("reloadGrid");
        }

        function doCheck(id, status) {
            layer.confirm('确定执行该操作？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/yuepai-user/check/' + id + '/' + status,
                    success: function (res) {
                        layer.msg(res.msg);
                        if (res.status) {
                            window.location.reload();
                        }
                    }
                })
            }, function () {
            });
        }

    </script>
<?php
$this->end();
