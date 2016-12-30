<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <div class="form-group">
                    <label for="keywords">用户编号</label>
                    <input type="text" name="id_kw" class="form-control" id="keywords" placeholder="输入关键字">
                </div>
                <div class="form-group">
                    <label for="keywords">用户昵称</label>
                    <input type="text" name="nick_kw" class="form-control" id="keywords" placeholder="输入关键字">
                </div>
                <div class="form-group">
                    <label for="keywords">申请时间</label>
                    <input type="text" name="begin_time" class="form-control date_timepicker_start" id="keywords"
                           placeholder="开始时间">
                    <label for="keywords">到</label>
                    <input type="text" name="end_time" class="form-control date_timepicker_end" id="keywords"
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
                url: "/withdraw/getDataList",
                datatype: "json",
                mtype: "POST",
                colNames: [
                    '用户编号',
                    '用户昵称',
                    '申请人',
                    '电话号码',
                    '提现方式',
                    '银行',
                    '银行卡号',
                    '支付宝账号',
                    '微信账号',
                    '提现金额',
                    '申请时间',
                    '受理时间',
                    '状态',
                    '受理操作',
                    '操作'
                ],
                colModel: [
                    {name: 'user.id', editable: true, align: 'center'},
                    {name: 'user.nick', editable: true, align: 'center'},
                    {name: 'truename', editable: true, align: 'center'},
                    {name: 'user.phone', editable: true, align: 'center'},
                    {
                        name: 'type',
                        editable: true,
                        align: 'center',
                        formatter: function actionFormatter(cellvalue, options, rowObject) {
                            switch (cellvalue) {
                                case 1:
                                    cellvalue = '支付宝';
                                    break;
                                case 2:
                                    cellvalue = '银联'
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    {name: 'bank', editable: true, align: 'center'},
                    //银行卡号
                    {
                        name: 'cardno', editable: true, align: 'center',
                        formatter: function actionFormatter(cellvalue, options, rowObject) {
                            console.log(rowObject);
                            switch (rowObject.type) {
                                case 2:  //银联
                                    break;
                                case 1:  //支付宝
                                case 3:  //微信
                                    cellvalue = '';
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    //微信账号
                    {
                        name: 'cardno', editable: true, align: 'center',
                        formatter: function (cellvalue, options, rowObject) {
                            switch (rowObject.type) {
                                case 1:  //支付宝
                                    break;
                                case 2:  //银联
                                case 3:  //微信
                                    cellvalue = '';
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    //支付宝账号
                    {
                        name: 'cardno', editable: true, align: 'center',
                        formatter: function (cellvalue, options, rowObject) {
                            switch (rowObject.type) {
                                case 3:  //支付宝
                                    break;
                                case 2:  //银联
                                case 1:  //微信
                                    cellvalue = '';
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    {name: 'amount', editable: true, align: 'center'},
                    {name: 'create_time', editable: true, align: 'center'},
                    {name: 'deal_time', editable: true, align: 'center'},
                    {
                        name: 'status', editable: true, align: 'center',
                        formatter: function (cellvalue, options, rowObject) {
                            switch (cellvalue) {
                                case 1:
                                    cellvalue = '正在审核';
                                    break;
                                case 2:
                                    cellvalue = '审核通过'
                                    break;
                                case 3:
                                    cellvalue = '审核不通过'
                                    break;
                            }
                            return cellvalue;
                        }
                    },
                    {
                        name: 'dealBtn',
                        align: 'center',
                        viewable: false,
                        sortable: false,
                        frozen: true,
                        formatter: dealFormatter
                    },
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

        function dealFormatter(cellvalue, options, rowObject) {
            if(rowObject.status != 2) {
                response = '<a title="确认提现" onClick="dealOrder(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-check"></i> </a>';
                return response;
            }
            return '';
        }

        function actionFormatter(cellvalue, options, rowObject) {
            response = '<a title="删除" onClick="delRecord(' + rowObject.id + ');" data-id="' + rowObject.id + '" class="grid-btn "><i class="icon icon-trash"></i> </a>';
            return response;
        }

        function dealOrder(id) {
            layer.confirm('确认提现？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/withdraw/deal',
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
                    url: '/withdraw/delete',
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
    </script>
<?php
$this->end();
