<div class="panel">
    <div class="panel-heading">
        标签管理
    </div>
    <div class="panel-body" style="height:500px;overflow-x:hidden;overflow-y:scroll">
        <ul class="tree treeview">
            <li><a class="add tree-plus" data-id="0"><i class="icon icon-plus-sign"></i></a></li>
            <?php foreach ($tags as $item): ?>
                <li>
                    <?= $item->name ?>【<?= getTagType($item['type'])?>】
                    <a class="add tree-plus" data-id="<?= $item->id ?>" type-no="<?= $item->type ?>"><i
                            class="icon icon-plus-sign"></i></a>
                    <?php if (count($item->children) == 0): ?>
                        <a class="del" data-id="<?= $item->id ?>"><i
                                class="icon icon-trash"></i></a>
                    <?php endif; ?>
                    <a class="edit" data-val="<?= $item->name ?>" data-id="<?= $item->id ?>" type-no="<?= $item->type ?>"><i
                            class="icon icon-pencil"></i></a>
                </li>
                <?php if ($item->children): ?>
                    <ul>
                        <?php foreach ($item->children as $i): ?>
                            <li><?= $i->name ?>
                                <a class="edit" data-val="<?= $i->name ?>" data-id="<?= $i->id ?>"><i
                                        class="icon icon-pencil"></i></a>
                                <a class="del" data-id="<?= $i->id ?>"><i
                                        class="icon icon-trash"></i></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
    $(function () {
        $('.del').click(function () {
            var id = $(this).data('id');
            layer.confirm('确定删除？', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: 'post',
                    data: {id: id},
                    dataType: 'json',
                    url: '/tag/delete',
                    success: function (res) {
                        layer.msg(res.msg);
                        if (res.status) {
                            parent.window.location.reload();
                        }
                    }
                })
            }, function () {
            });
        });


        $('.add').click(function () {

            url = '/tag/add/';
            layer.open({
                type: 2,
                title: '添加标签',
                shadeClose: true,
                shade: 0.8,
                area: ['50%', '40%'],
                content: url//iframe的url
            });

        });


        $('.edit').click(function () {

            url = '/tag/edit/' + $(this).attr('data-id');
            layer.open({
                type: 2,
                title: '修改标签',
                shadeClose: true,
                shade: 0.8,
                area: ['50%', '40%'],
                content: url//iframe的url
            });

        });
    });
</script>
<?php $this->end('script'); ?>