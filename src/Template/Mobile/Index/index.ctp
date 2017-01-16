<?php $this->start('css'); ?>
<style>
    #map_canvas {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
    .wraper {
        overflow: hidden;
        position: absolute;
        top: 1rem;
        bottom: 67px;
        width:100%;
        max-width:750px;
    }
</style>
<?php $this->end('css'); ?>
<header>
    <div class="header">
        <a href='/index/find-list'>
            <span class="l_btn">切换列表</span>
        </a>
        <h1>美约</h1>
    </div>
</header>
<div class="wraper">
    <div id="map_canvas">

    </div>
</div>
<?= $this->element('footer', ['active' => 'find']) ?>
<?php $this->start('script'); ?>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=e6a00ec81910abdb86c3c124211575cf"></script>
<script>
    var map = new AMap.Map("map_canvas", {

    });
    //地图中添加地图操作ToolBar插件
    map.plugin(['AMap.ToolBar'], function () {
        //设置地位标记为自定义标记
        var toolBar = new AMap.ToolBar();
        map.addControl(toolBar);
    });
</script>
<?php $this->end('script'); ?>