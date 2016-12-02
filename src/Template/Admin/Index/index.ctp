<?php $this->start('static') ?>   
<link href="/wpadmin/css/index.css" rel="stylesheet">
<script src="/wpadmin/js/Chart.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/wpadmin/js/chart-config.js" type="text/javascript" charset="utf-8"></script>
<style>
    .a-link{
        display:block;
    }
    .a-link:hover{
        text-decoration:none;
    }
</style>
<?php $this->end() ?>     
<div class="cbody">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themesecondary ht">
                            会员认证          
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/savant/index?do=check">
                                <span class="databox-number themesecondary"><?= $savantCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themethirdcolor ht">
                            小秘书          
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/need/index?do=check">
                                <span class="databox-number cosecondar"><?= $needCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themeprimary ht">
                            提现        
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/withdraw/index?do=check">
                                <span class="databox-number coseconda"><?= $withdrawCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-palegreen ht">
                            活动赞助          
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/sponsor/index?do=check">
                                <span class="databox-number cosecond"><?= $sponsorCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themesecondary ht">
                            活动报名         
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/activityapply/index?do=check">
                                <span class="databox-number themesecondary"><?= $applyCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                    <div class="databox bg-white radius-bordered">
                        <div class="databox-left bg-themethirdcolor ht">
                            发票申请         
                        </div>
                        <div class="databox-right">
                            <a class="a-link" href="/admin/invoice/index?do=check">
                                <span class="databox-number themesecondary"><?= $invoiceCounts ?></span>
                                <div class="databox-text darkgray">待处理</div>
                                <div class="databox-stat themesecondary radius-bordered">
                                    <i class="">more</i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="datacontainer">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab">用户注册数</a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab">活动报名数</a>
                    </li>
                    <li class="dropdown">
                        <a href="#tab3" data-toggle="tab">会员约见数</a>
                    </li>
                    <li class="dropdown">
                        <a href="#tab4" data-toggle="tab">平台收入</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane in active" id="tab1">
                        <canvas id="new-user-chart" height='170px' width='400px'></canvas>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <canvas id="activity-apply-chart" height='170px' width='400px'></canvas>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <canvas id="meet-chart" height='170px' width='400px'></canvas>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <canvas id="flow-chart" height='170px' width='400px'></canvas>
                    </div>
                </div>
                <div class="input-group col-md-3">
                    <span class="input-group-addon">选择月份</span>
                    <?= $this->Form->month('month', ['value' => date('M'), 'class' => 'form-control', 'id' => 'month']) ?>
                </div>
            </div>
        </div>
        <div class="panel col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="panel-body">
                <div id="industry_chart" style="width:100%;height:400px;" >

                </div>
            </div>
        </div>
    </div>
</div>
<script src="/wpadmin/lib/echart/echarts.js"></script>    
<script type="text/javascript">
    window.onload = function () {
        var industry_chart = echarts.init(document.getElementById('industry_chart'));
        $.get('/admin/user-chart/getIndustryPieChart', function (data) {
            industry_chart.setOption({
                title: {
                    text: data.title.text,
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: data.legend.data
                },
                series: [
                    {
                        name: data.series.name,
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: data.series.data,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            });
        }, 'json');
        var newUserChart = document.getElementById('new-user-chart').getContext('2d');
        initChart('/admin/index/getNewUserByDayWithMonth',newUserChart,'line');
        var activityApplyChart = document.getElementById('activity-apply-chart').getContext('2d');
        initChart('/admin/index/getActivityApplyByDayWithMonth',activityApplyChart,'line');
        var meetChart = document.getElementById('meet-chart').getContext('2d');
        initChart('/admin/index/getMeetByDayWithMonth',meetChart,'bar');
        var flowChart = document.getElementById('flow-chart').getContext('2d');
        initChart('/admin/index/getFlowByDayWithMonth',flowChart,'line');
        $('#month').change(function () {
            var month = $('#month').val();
            initChart('/admin/index/getNewUserByDayWithMonth/'+month,newUserChart,'line');
            initChart('/admin/index/getActivityApplyByDayWithMonth/'+month,activityApplyChart,'line');
            initChart('/admin/index/getMeetByDayWithMonth/'+month,meetChart,'bar');
            initChart('/admin/index/getFlowByDayWithMonth/'+month,flowChart,'line');
        });
    }

    function initChart(url, chart, type) {
        var chartObj;
        $.getJSON(url, function (res) {
           chartObj = new Chart(chart, {
                type: type,
                data: res.data
            });
        }, 'json');
    }
</script>