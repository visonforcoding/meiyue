<?php

/**
 * Encoding     :   UTF-8
 * Created on   :   2015-12-26 22:45:09 by allen <blog.rc5j.cn> , caowenpeng1990@126.com
 */
use Cake\I18n\Date;

/**
 * 生成指定长度的随机字符串
 * @param type $length
 * @param int $type 默认1数字字母混合，2纯数字，3纯字母
 * @return string
 */
function createRandomCode($length, $type = 1) {
    $randomCode = "";
    switch ($type) {
        case 1:
            $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 2:
            $randomChars = '0123456789';
            break;
        case 3:
            $randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        default:
            break;
    }
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $randomChars { mt_rand(0, strlen($randomChars) - 1) };
    }
    return $randomCode;
}

/**
 * save 的验证错误信息
 * @param type $entity
 * @param type $msg
 * @return type
 */
function errorMsg($entity, $msg) {
    $errors = $entity->errors();
    $message = null;
    if (is_array($errors)) {
        foreach ($errors as $value) {
            foreach ($value as $val) {
                $message = $val;
                break;
            }
        }
    }
    if ($message) {
        Cake\Log\Log::error($errors, 'devlog');
    }
    return empty($message) ? $msg : $message;
}

/**
 *  获得原图
 * @param type $thumb
 * @return type
 */
function getOriginAvatar($thumb) {
    return preg_replace('/thumb_/', '', $thumb);
}

/**
 * 获40% 缩略图
 * @param type $thumb
 * @return type
 */
function getSmallAvatar($thumb) {
    $small = preg_replace('/thumb_/', 'small_', $thumb);
    if (!file_exists(WWW_ROOT . $small)) {
        return getOriginAvatar($thumb);
    } else {
        return $small;
    }
}

/**
 * 头像不存在或找不到时候设置为默认图
 * @param type $avatar
 * @return string
 */
function getAvatar($avatar) {
    if (preg_match('/(http|https).*/', $avatar)) {
        return $avatar;
    }
    if (empty($avatar) || !file_exists(WWW_ROOT . $avatar)) {
        return '/mobile/images/touxiang.jpg';
    } else {
        return $avatar;
    }
}

/**
 * 
 * @param type $url
 */
function createImg($url) {
    return preg_replace('/upload/', 'imgs', $url);
}

/**
 * 
 * @param type $params
 */
function buildLinkString($params) {
    $string = '';
    foreach ($params as $key => $value) {
        $string.= $key . '="' . $value . '"&';
    }
    //去掉最后一个&字符
    $string = substr($string, 0, count($string) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    return $string;
}



/**
 * 计算2点间距离
 * @param type $coordinate1
 * @param type $coordinate2
 * @return 米  两点间距离
 * @throws Exception
 */
function getDistance($coordinate1, $lng,$lat) {
    $coordinate1_arr = explode(',', $coordinate1);
    if (!is_array($coordinate1_arr) || empty($coordinate1_arr)) {
        throw new Exception;
    } else {
        $lng1 = $coordinate1_arr[0];
        $lat1 = $coordinate1_arr[1];
    }
        $lng2 = $lng;
        $lat2 = $lat;
//    $earthRadius = 6367000; //approximate radius of earth in meters
    $earthRadius = 6371000; //百度地图用的参数
    /*
      Convert these degrees to radians
      to work with the formula
     */
    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;

    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;

    /*
      Using the
      Haversine formula

      http://en.wikipedia.org/wiki/Haversine_formula

      calculate the distance
     */
    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;

    $dis =  round($calculatedDistance);
    if($dis<1000){
        return $dis.'m';
    }else{
        return round($dis/1000,1).'km';
    }
//     return round($calculatedDistance);
}


//仅适用于本项目对应数据库约会表start_time，end_time字段
//用户将开始时间和结束时间合成页面需要的格式
function getFormateDT($startTime, $endTime) {

    $timestr = $startTime->year . "-" . $startTime->month . "-" . $startTime->day . " " . $startTime->hour . ":00~" . $endTime->hour . ":00";
    return $timestr;

}

//根据出生日期计算年龄
function getAge($birthday) {

    $currentday = new Date();
    return ($currentday->year - $birthday->year);

}


/**
 * //根据开始时间，结束时间，单价计算总价和付费百分比计算价格
 * @param \Cake\I18n\Time $start_time
 * @param \Cake\I18n\Time $end_time
 * @param double $price
 * @param float $percent
 * @return float;
 */
function getCost($start_time, $end_time, $price, $percent = 1.0) {

    return ($end_time->hour - $start_time->hour) * $price * $percent;

}

/**
 * 生成浮点随机数
 * @param int $min
 * @param int $max
 * @return float
 */
function randomFloat($min = 0, $max = 1) {
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

