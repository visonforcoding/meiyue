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
class DateState {
    const DATED = 1;
    const NOT_YET = 2;
    const DOWN = 3;
    const BE_DOWN = 4;

    public static function getDateStatStr($status = null) {

        $statuses = Array(
            DateState::DATED => "已有人赴约",
            DateState::NOT_YET => "未有人赴约",
            DateState::DOWN => "已下线",
            DateState::BE_DOWN => "被平台下架"
        );
        if (!$status) {
            return $statuses;
        } else {
            return isset($statuses[$status]) ? $statuses[$status] : "未知状态";
        }
    }
}


/**
 * 用户审核状态
 * Class YPUserStatus
 */
class UserStatus {
    const NONEED = 0;  //不用审核
    const CHECKING = 1;  //待审核
    const NOPASS = 2;    //审核不通过
    const PASS = 3;    //审核通过

    const GETJSON = -1; //获取json数据
    public static function getStatus($st = null) {
        $status = Array(
            UserStatus::NONEED => '无需审核',
            UserStatus::CHECKING => '待审核',
            UserStatus::NOPASS => '不通过',
            UserStatus::PASS => '已通过'
        );
        if(CheckStatus::GETJSON == $st) {
            return json_encode($status);
        }
        if($st !== null) {
            return isset($status[$st])?$status[$st]:null;
        }
        return $status;
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
        '15' => '购买套餐',
        '17' => '赴约支付约金',
        '18' => '支付微信查看金'
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
class PackType {
    const VIP = 1;
    const RECHARGE = 2;
    const OTHER = 3;

    public static function getPackageType($num = null) {

        $types = Array(
            PackType::VIP => 'VIP套餐',
            PackType::RECHARGE => '充值套餐',
            PackType::OTHER => '其他套餐'
        );

        if($num) {
            return isset($types[$num])?$types[$num]:null;
        }
        return $types;
    }
}



/**
 * 检查是否是无限
 * 仅适用于套餐的数字
 * @return int
 */
function checkIsEndless($num = null) {
    $endless = 100000;  //定义10w为无限
    if($num !== null) {
        return ($num >= $endless);
    }
    return $endless;
}


/**
 * 返回表示无限的数字
 * 仅适用于套餐的数字
 * @return int
 */
function getDefultEndless() {
    $defaultEndless = 1000000;  //管理员勾选‘无限’时自动填入数据库的数量
    return $defaultEndless;
}


/**
 * 消费类型：1#查看动态服务 2#聊天服务
 */
class ServiceType {
    const BROWSE =  1;
    const CHAT = 2;

    public static function containType($type = null) {
        if($type == ServiceType::BROWSE || $type == ServiceType::CHAT) {
            return true;
        }
        return false;
    }


    /**
     * 返回数据库相应“剩余字段”
     * @param null $type
     * @return array
     */
    public static function getDBRestr($type = null) {
        $keys = Array(
            ServiceType::BROWSE => 'rest_browse',
            ServiceType::CHAT => 'rest_chat'
        );
        if($type && isset($keys[$type])) {
            return $keys[$type];
        }
        return null;
    }
}


/**
 * @author: kebin
 * 服务权限：
 */
class SerRight {
    const OK_CONSUMED = 1; //已经消费，具有权限
    const NO_HAVENUM = 2;  //剩余名额，还没有权限
    const NO_HAVENONUM = 3; //没有名额，还没有权限
}


/**
 * 约拍状态
 */
class YuepaiStatus {

    const NORMAL = 1;  //正常
    const DOWN = 2;    //下架

    const GETJSON = -1; //获取json数据
    public static function getStatus($st = null) {
        $status = Array(
            YuepaiStatus::NORMAL => '正常',
            YuepaiStatus::DOWN => '下架'
        );
        if(YuepaiStatus::GETJSON == $st) {
            return json_encode($status);
        }
        if($st) {
            return isset($status[$st])?$status[$st]:null;
        }
        return $status;
    }

}


/**
 * 申请状态
 * Class YPUserStatus
 */
class CheckStatus {
    const CHECKED = 1;  //审核通过
    const CHECKING = 2;    //尚未审核
    const CHECKNO = 3;    //审核不通过

    const GETJSON = -1; //获取json数据
    public static function getStatus($st = null) {
        $status = Array(
            CheckStatus::CHECKED => '审核通过',
            CheckStatus::CHECKING => '尚未审核',
            CheckStatus::CHECKNO => '审核不通过'
        );
        if(CheckStatus::GETJSON == $st) {
            return json_encode($status);
        }
        if($st) {
            return isset($status[$st])?$status[$st]:null;
        }
        return $status;
    }
}


/**
 * 获取星期
 */
function getWeekStr($week = null) {
    $weeks = Array(
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
        7 => '星期日',
    );
    if($week) {
        return isset($weeks[$week])?$weeks[$week]:null;
    }
    return $weeks;
}


/**
 * 轮播图位置
 * Class carouselPosition
 */
class CarouselPosition {
    const ACTIVITY = 1;  //活动轮播图显示位

    const GETJSON = -1;
    public static function getStr($st = null) {
        $positions = Array(
            CarouselPosition::ACTIVITY => '活动轮播图显示位',
        );
        if(CarouselPosition::GETJSON == $st) {
            return json_encode($positions);
        } else if($st) {
            return isset($positions[$st])?$positions[$st]:null;
        }
        return $positions;
    }
}


/**
 * 轮播图状态
 */
class CarouselStatus {

    const NORMAL = 1;  //正常
    const DOWN = 2;    //下架

    const GETJSON = -1; //获取json数据
    public static function getStatus($st = null) {
        $status = Array(
            CarouselStatus::NORMAL => '正常',
            CarouselStatus::DOWN => '下架'
        );
        if(CarouselStatus::GETJSON == $st) {
            return json_encode($status);
        }
        if($st) {
            return isset($status[$st])?$status[$st]:'未知';
        }
        return $status;
    }

}


/**
 * 星座
 */
class Zodiac {
    const BAIYANG = 1;  //白羊座
    const JINNIU = 2;    //金牛座
    const SHUANGZI = 3;    //双子座
    const JUXIE = 4;    //巨蟹座
    const SHIZI = 5;    //狮子座
    const CHUNV = 6;    //处女座
    const TIANPING = 7;    //天秤座
    const TIANXIE = 8;    //天蝎座
    const SHESHOU = 9;    //射手座
    const MOJIE = 10;    //摩羯座
    const SHUIPING = 11;    //水瓶座
    const SHUANGYU = 12;    //双鱼座

    const GETJSON = -1; //获取json数据
    public static function getStr($st = null) {
        $types = Array(
            Zodiac::BAIYANG => '白羊座',
            Zodiac::JINNIU => '金牛座',
            Zodiac::SHUANGZI => '双子座',
            Zodiac::JUXIE => '巨蟹座',
            Zodiac::SHIZI => '狮子座',
            Zodiac::CHUNV => '处女座',
            Zodiac::TIANPING => '天秤座',
            Zodiac::TIANXIE => '天蝎座',
            Zodiac::SHESHOU => '射手座',
            Zodiac::MOJIE => '摩羯座',
            Zodiac::SHUIPING => '水瓶座',
            Zodiac::SHUANGYU => '双鱼座',
        );
        if(CarouselStatus::GETJSON == $st) {
            return json_encode($types);
        }
        if($st !== null) {
            return isset($types[$st])?$types[$st]:'无';
        }
        return $types;
    }
}


/**
 * 用户情感状态
 */
class UserState {
    const SINGLE = 1;  //单身
    const SECRITE = 2;    //私密
    const GETJSON = -1; //获取json数据
    public static function getStatus($st = null) {
        $status = Array(
            UserState::SINGLE => '单身',
            UserState::SECRITE => '私密'
        );
        if(CarouselStatus::GETJSON == $st) {
            return json_encode($status);
        }
        if($st) {
            return isset($status[$st])?$status[$st]:'未知';
        }
        return $status;
    }
}


/**
 * 订单类型及相关操作
 */
class PayOrderType {
    const CHONGZHI = 1;  //充值美币
    const BUY_TAOCAN = 2;    //购买套餐
    const VIEW_WEIXIN = 10;  //查看美女微信
    const GETJSON = -1; //获取json数据
    public static function getType($st = null) {
        $status = Array(
            PayOrderType::CHONGZHI => '充值美币',
            PayOrderType::BUY_TAOCAN => '购买套餐',
            PayOrderType::VIEW_WEIXIN => '查看美女微信',
        );
        if(PayOrderType::GETJSON == $st) {
            return json_encode($status);
        }
        if($st) {
            return isset($status[$st])?$status[$st]:'未知';
        }
        return $status;
    }
}