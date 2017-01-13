<div class="panel">
    <div class="panel-heading">
        技能管理
    </div>
    <div class="panel-body" style="height:500px;overflow-x:hidden;overflow-y:scroll">
        <table id="list"></table>
        <ul class="tree treeview">
            <li><a href="/skill/add/0" class="add tree-plus" data-id="0"><i class="icon icon-plus-sign"></i></a></li>
            <?php
                $count = 0;
                $bmax = count($skills);
                foreach ($skills as $item): ?>
                <li>
                    <?php $count++; ?>
                    <?= $item->name ?><a href="/skill/add/<?= $item['id'] ?>" class="add tree-plus"
                                         data-id="<?= $item->id ?>"><i
                                class="icon icon-plus-sign"></i></a>
                    <?php if (count($item->children) == 0): ?>
                        <a class="del" data-id="<?= $item->id ?>"><i
                                    class="icon icon-trash"></i></a>
                    <?php endif; ?>
                    <a href="/skill/edit/<?= $item->id ?>" class="edit"><i class="icon icon-pencil"></i></a>
                    <?php if(($count > 1) && ($bmax > 1)): ?>
                        <a class="up" data-id="<?= $item->id ?>"><i class="icon icon-arrow-up"></i></a>
                    <?php endif; ?>
                    <?php if(($count < $bmax) && ($bmax > 1)): ?>
                        <a class="down" data-id="<?= $item->id ?>"><i class="icon icon-arrow-down"></i></a>
                    <?php endif; ?>
                </li>
                <?php if ($item->children): ?>
                    <ul>
                        <?php
                            $scount = 0;
                            $smax = count($item->children);
                            foreach ($item->children as $i): ?>
                            <?php $scount++; ?>
                            <li><?= $i->name ?>
                                <!--<a class="del" data-id="<?= $i->id ?>"><i class="icon icon-trash"></i></a>-->
                                <a href="/skill/edit/<?= $i->id ?>" class="edit"><i
                                            class="icon icon-pencil"></i></a>
                                <a class="del" data-id="<?= $i->id ?>"><i
                                            class="icon icon-trash"></i></a>
                                <?php if(($scount > 1) && ($smax > 1)): ?>
                                    <a class="up" data-id="<?= $i->id ?>"><i class="icon icon-arrow-up"></i></a>
                                <?php endif; ?>
                                <?php if(($scount < $smax) && ($smax > 1)): ?>
                                    <a class="down" data-id="<?= $i->id ?>"><i class="icon icon-arrow-down"></i></a>
                                <?php endif; ?>
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


        $('.up').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'post',
                data: {id: id, action: 'up'},
                dataType: 'json',
                url: '/skill/cpositon',
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.status) {
                        window.location.reload();
                    }
                }
            })
        });

        $('.down').click(function () {
            var id = $(this).data('id');
            $.ajax({
                type: 'post',
                data: {id: id, action: 'down'},
                dataType: 'json',
                url: '/skill/cpositon',
                success: function (res) {
                    layer.msg(res.msg);
                    if (res.status) {
                        window.location.reload();
                    }
                }
            })
        });
    });

</script>
<?php $this->end('script'); ?>