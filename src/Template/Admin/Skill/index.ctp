<div class="panel">
    <div class="panel-heading">
        技能管理
    </div>
    <div class="panel-body" style="height:500px;overflow-x:hidden;overflow-y:scroll">
        <ul class="tree treeview">
            <li><a  href="/skill/add/0" class="add tree-plus" data-id="0"><i class="icon icon-plus-sign"></i></a></li>
            <?php foreach ($skills as $item): ?>
                <li>
                    <?= $item->name ?><a href="/skill/add/<?= $item['id']?>" class="add tree-plus" data-id="<?= $item->id ?>"><i
                            class="icon icon-plus-sign"></i></a>
                    <?php if (count($item->children) == 0): ?>
                        <a class="del" data-id="<?= $item->id ?>"><i
                                class="icon icon-trash"></i></a>
                    <?php endif; ?>
                    <a href="/skill/edit/<?= $item->id ?>" class="edit"><i class="icon icon-pencil"></i></a>
                </li>
                <?php if ($item->children): ?>
                    <ul>
                        <?php foreach ($item->children as $i): ?>
                            <li><?= $i->name ?>
                                <!--<a class="del" data-id="<?= $i->id ?>"><i class="icon icon-trash"></i></a>-->
                                <a href="/skill/edit/<?= $i->id ?>" class="edit"><i
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
                    url: '/skill/delete',
                    success: function (res) {
                        layer.msg(res.msg);
                        if (res.status) {
                            window.location.reload();
                        }
                    }
                })
            }, function () {
            });
        });

</script>
<?php $this->end('script'); ?>