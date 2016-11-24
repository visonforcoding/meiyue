<?php

/**
 * 配置全局数据库表值与文字转换功能
 * Created by PhpStorm.
 * User: kebin
 * Date: 2016/11/8
 * Time: 11:24
 */

/**
 * 约会状态文字表述
 * @param int $status
 * @return array|mixed|string
 */
function getDateStatStr($status = -1) {

    $statuses = Array(
        1 => "已有人赴约",
        2 => "未有人赴约",
        3 => "已下线",
        4 => "被平台下架"
    );

    if ($status == -1) {

        return json_encode($statuses);
    } elseif ($status == -2) {

        return $statuses;
    } else {

        return isset($statuses[$status]) ? $statuses[$status] : "未知状态";
    }
}

/**
 * 技能分类转述
 * @param int $type
 * @return array|mixed|string
 */
function getTagType($type = -1) {

    $types = Array(
        0 => "未分类",
        1 => "技能标签",
        2 => "个人标签"
    );
    if ($type == -1) {

        return $types;
    } else {

        return isset($types[$type]) ? $types[$type] : "未知分类";
    }
}

/**
 * 获取审核状态
 * @param int $status_code
 * @return array|mixed|string
 */
function getCheckStatus($status_code = -1) {

    $status = Array(
        2 => "未审核",
        1 => "通过",
        0 => "不通过",
    );

    if ($status_code == -1) {

        return json_encode($status);
    } elseif ($status_code == -2) {

        return $status;
    } else {

        return isset($status[$status_code]) ? $status[$status_code] : "未知状态";
    }
}

/**
 * 获取启用状态
 * @param int $status_code
 * @return array|mixed|string
 */
function getUsedStatus($status_code = -1) {

    $status = Array(
        0 => "禁用",
        1 => "启用",
    );

    if ($status_code == -1) {

        return json_encode($status);
    } elseif ($status_code == -2) {

        return $status;
    } else {

        return isset($status[$status_code]) ? $status[$status_code] : "未知状态";
    }
}


/**
 * 资金流水类型
 * @param type $index
 * @return string
 */
function getFlowType($index = null) {
    $flowType = [
        '1' => '约技能支付预约金',
        '2' => '约技能支付尾款',
        '3' => '约技能收款',
        '4' => '用户充值',
        '5' => '男士取消约单预约金退回',
        '6' => '女士取消约单预约金退回',
        '7' => '女士在接受订单后取消约单',
        '8' => '女士在男士支付尾款后取消约单',
        '9' => '男士在支付尾款后后取消约单',
        '10' => '支付完预约金后60分钟无响应',
        '11' => '接受约单后6小时未支付尾款',
        '12' => '24小时订单自动完成',
        '13' => '派对报名费',
        '14' => '送礼物费用',
        '15' => '用户充值'
    ];
    if ($index) {
        return $flowType[$index];
    }

    return $flowType;
}





/**
 * 获取百度地图POI行业分类
 * @param int $status_code
 * @return array|mixed|string
 */
function getBaiduPOICF() {

    $cfs = Array(
        '美食',
        '酒店',
        '购物',
        '生活服务',
        '丽人',
        '旅游景点',
        '休闲娱乐',
        '运动健身',
        '教育培训',
        '文化传媒',
        '医疗',
        '汽车服务',
        '交通设施',
        '金融',
        '房地产',
        '公司企业',
        '政府机构'
    );
    return $cfs;
}


/**
 * 获取套餐类型
 * @param null $num
 * @return array
 */
function getPackageType($num = null) {

    $types = Array(
        1 => 'VIP套餐',
        2 => '充值套餐',
        3 => '其他套餐'
    );

    if($num) {
        return $types[$num];
    }
    return $types;
}


/**
 * 返回表示无限的数字
 * @return int
 */
function getEndlessNum() {
    return -1;
}