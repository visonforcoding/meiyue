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
        3 => "已下线"
    );

    if($status == -1) {

        return json_encode($statuses);

    } elseif($status == -2) {

        return $statuses;

    } else {

        return isset($statuses[$status])?$statuses[$status] : "未知状态";

    }

}


/**
 * 标签分类转述文字
 * @param int $type
 * @return array|mixed|string
 */
function getSkillType($type = -1) {

    $types = Array(

        0 => "未分类",
        1 => "技能标签",
        2 => "技能标签"

    );
    if($type == -1) {

        return $types;

    } else {

        return isset($types[$type])?$types[$type] : "未知分类";

    }
}