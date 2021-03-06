<?php $this->start('static') ?>
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" type="text/css" href="/wpadmin/lib/jqgrid/css/ui.ace.css">
<?php $this->end() ?>

<div class="panel">
    <div class="panel-heading">
        <Strong>套餐管理</Strong>
    </div>
    <br>
    <div class="col-xs-12">
        <form id="table-bar-form">
            <div class="table-bar form-inline">
                <a href="/package/add" class="btn btn-small btn-warning">
                    <i class="icon icon-plus-sign"></i>
                    添加
                </a>
                <div class="form-group">
                    <label for="keywords">关键字</label>
                    <input type="text"
                           name="keywords"
                           class="form-control"
                           id="keywords"
                           placeholder="输入关键字">
                </div>
                <a onclick="doSearch();" class="btn btn-info">
                    <i class="icon icon-search"></i>
                    搜索
                </a>
                <a class="btn btn-small btn-warning">
                    <i class="icon icon-shopping-cart"></i>
                    总销量：<?= $total; ?>
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
            url: "/package/getDataList",
            datatype: "json",
            mtype: "POST",
            colNames:
                ['名称',
                 '荣誉称号',
                 '类型',
                 '聊天名额',
                 '查看动态名额',
                 '充值金额',
                 '价格',
                 '库存',
                 '销量',
                 '有效期',
                 '创建时间',
                 '修改时间',
                 '排序',
                 '操作'
                ],
            colModel: [
                {name:'title',editable:true,align:'center'},
                {name:'honour_name',editable:true,align:'center'},
                {name:'type',editable:true,align:'center'},
                {
                    name:'chat_num',
                    editable:true,
                    align:'center',
                    formatter:function(cellvalue, options, rowObject) {

                        var endlessNum = <?= checkIsEndless(); ?>;
                        if(cellvalue >= endlessNum) {
                            cellvalue = '无限'
                        }
                        return cellvalue;
                    }
                },
                {
                    name:'browse_num',
                    editable:true,
                    align:'center',
                    formatter:function(cellvalue, options, rowObject) {
                        var endlessNum = <?= checkIsEndless(); ?>;
                        if(cellvalue >= endlessNum) {
                            cellvalue = '无限'
                        }
                        return cellvalue;
                    }
                },
                {name:'vir_money',editable:true,align:'center'},
                {name:'price',editable:true,align:'center'},
                {name:'stock',editable:true,align:'center'},
                {name:'user_package',editable:true,align:'center',
                    formatter:function(cellvalue, options, rowObject) {
                        return cellvalue.length;
                    }
                },
                {name:'vali_time',editable:true,align:'center'},
                {name:'create_time',editable:true,align:'center'},
                {name:'update_time',editable:true,align:'center'},
                {name:'show_order',editable:true,align:'center'},
                {name:'actionBtn',
                    align:'center',
                    viewable:false,
                    sortable:false,
                    frozen:true,
                    formatter:actionFormatter
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
        }).navGrid(
            '#pager',
            {edit: false, add: false, del: false, view: true}
        );
        $('#list').jqGrid('setFrozenColumns');
    });

    function actionFormatter(cellvalue, options, rowObject) {
        response =
            '<a title="删除" onClick="delRecord(' + rowObject.id + ');" ' +
            'data-id="' + rowObject.id + '" class="grid-btn ">' +
            '<i class="icon icon-trash"></i> </a>';
        response += '<a title="编辑" href="/package/edit/' + rowObject.id + '" ' +
            'class="grid-btn "><i class="icon icon-pencil"></i> </a>';
        response += '<a title="销售详情" href="/package/sell/' + rowObject.id + '" ' +
            'class="grid-btn "><i class="icon icon-shopping-cart"></i> </a>';
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
                url: '/package/delete',
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

    function doExport() {
        //导出excel
        var sortColumnName = $("#list").jqGrid('getGridParam', 'sortname');
        var sortOrder = $("#list").jqGrid('getGridParam', 'sortorder');
        var searchData = $.zui.store.pageGet('searchData')?$.zui.store.pageGet('searchData'):{};
        searchData['sidx'] = sortColumnName;
        searchData['sort'] = sortOrder;
        var searchQueryStr  = $.param(searchData);
        $("body").append("<iframe src='/activity/exportExcel?" + searchQueryStr + "'" +
            " style='display: none;' ></iframe>");
    }

</script>
<?php
$this->end();
