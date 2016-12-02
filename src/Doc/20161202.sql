-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.24 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 meiyue 的数据库结构
DROP DATABASE IF EXISTS `meiyue`;
CREATE DATABASE IF NOT EXISTS `meiyue` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `meiyue`;

-- 导出  函数 meiyue.getDistance 结构
DROP FUNCTION IF EXISTS `getDistance`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` FUNCTION `getDistance`(
	`lng1` float(10,7) 
    ,
	`lat1` float(10,7)
    ,
	`lng2` float(10,7) 
    ,
	`lat2` float(10,7)

) RETURNS double
    COMMENT '计算2坐标点距离'
BEGIN
	declare d double;
    declare radius int;
    set radius = 6371000; #假设地球为正球形，直径为6371000米
    set d = (2*ATAN2(SQRT(SIN((lat1-lat2)*PI()/180/2)   
        *SIN((lat1-lat2)*PI()/180/2)+   
        COS(lat2*PI()/180)*COS(lat1*PI()/180)   
        *SIN((lng1-lng2)*PI()/180/2)   
        *SIN((lng1-lng2)*PI()/180/2)),   
        SQRT(1-SIN((lat1-lat2)*PI()/180/2)   
        *SIN((lat1-lat2)*PI()/180/2)   
        +COS(lat2*PI()/180)*COS(lat1*PI()/180)   
        *SIN((lng1-lng2)*PI()/180/2)   
        *SIN((lng1-lng2)*PI()/180/2))))*radius;
    return d;
END//
DELIMITER ;

-- 导出  表 meiyue.lm_actionlog 结构
DROP TABLE IF EXISTS `lm_actionlog`;
CREATE TABLE IF NOT EXISTS `lm_actionlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键，自增',
  `url` varchar(1000) NOT NULL COMMENT '请求地址',
  `type` varchar(50) NOT NULL COMMENT '请求类型',
  `useragent` varchar(1000) NOT NULL COMMENT '浏览器信息',
  `ip` varchar(80) NOT NULL COMMENT '客户端IP',
  `filename` varchar(250) NOT NULL COMMENT '脚本名称',
  `msg` varchar(150) NOT NULL COMMENT '日志内容',
  `controller` varchar(50) NOT NULL COMMENT '控制器',
  `action` varchar(50) NOT NULL COMMENT '动作',
  `param` varchar(1000) NOT NULL COMMENT '请求参数',
  `user` varchar(80) NOT NULL COMMENT '操作者',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='后台操作日志表';

-- 正在导出表  meiyue.lm_actionlog 的数据：~26 rows (大约)
DELETE FROM `lm_actionlog`;
/*!40000 ALTER TABLE `lm_actionlog` DISABLE KEYS */;
INSERT INTO `lm_actionlog` (`id`, `url`, `type`, `useragent`, `ip`, `filename`, `msg`, `controller`, `action`, `param`, `user`, `create_time`) VALUES
	(1, 'menu/edit/2', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'菜单管理\',\n  \'node\' => \'/menu/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-list\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 02:28:04'),
	(2, 'menu/edit/3', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'user管理\',\n  \'node\' => \'/user/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-user\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 02:29:37'),
	(3, 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'管理员管理\',\n  \'node\' => \'/admin/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-android\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 03:12:05'),
	(4, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:24:49'),
	(5, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:27:38'),
	(6, 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \'\',\n  ),\n)', 'admin', '2016-10-18 03:29:43'),
	(7, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:30:25'),
	(8, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 13:00:00'),
	(9, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 14:03:43'),
	(10, 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'群组管理\',\n  \'node\' => \'/group/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-group\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 14:07:11'),
	(11, 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:10:19'),
	(12, 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:11:24'),
	(13, 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:16:43'),
	(14, 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:25:31'),
	(15, 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \n    array (\n      0 => \'1\',\n    ),\n  ),\n)', 'admin', '2016-10-18 14:28:03'),
	(16, 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \'\',\n  ),\n)', 'admin', '2016-10-18 14:29:25'),
	(17, 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \n    array (\n      0 => \'1\',\n    ),\n  ),\n)', 'admin', '2016-10-18 14:31:15'),
	(18, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 15:41:33'),
	(19, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-20 14:31:37'),
	(20, 'menu/edit/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'操作日志管理\',\n  \'node\' => \'/actionlog/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-keyboard\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-20 14:36:49'),
	(21, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-07 12:08:48'),
	(22, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-09 10:49:32'),
	(23, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-18 14:41:29'),
	(24, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-12-01 17:10:49'),
	(25, 'menu/edit/3', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'用户管理\',\n  \'node\' => \'/user/index\',\n  \'pid\' => \'7\',\n  \'class\' => \'icon-user\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-12-01 17:38:43'),
	(26, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-12-02 18:14:34');
/*!40000 ALTER TABLE `lm_actionlog` ENABLE KEYS */;

-- 导出  表 meiyue.lm_admin 结构
DROP TABLE IF EXISTS `lm_admin`;
CREATE TABLE IF NOT EXISTS `lm_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(150) NOT NULL COMMENT '密码',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1启用0禁用',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `utime` datetime DEFAULT NULL COMMENT '修改时间',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  `login_ip` varchar(50) DEFAULT NULL COMMENT '登录ip',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- 正在导出表  meiyue.lm_admin 的数据：~1 rows (大约)
DELETE FROM `lm_admin`;
/*!40000 ALTER TABLE `lm_admin` DISABLE KEYS */;
INSERT INTO `lm_admin` (`id`, `username`, `password`, `enabled`, `ctime`, `utime`, `login_time`, `login_ip`) VALUES
	(1, 'admin', '$2y$10$FO3TYb8S3BygWrtep7DsY.f7qcWcSe95yC50FH5uEa8FIHmv0ViVG', 1, '2016-10-17 10:17:52', '2016-12-02 18:14:34', '2016-12-02 18:14:34', '127.0.0.1');
/*!40000 ALTER TABLE `lm_admin` ENABLE KEYS */;

-- 导出  表 meiyue.lm_admin_group 结构
DROP TABLE IF EXISTS `lm_admin_group`;
CREATE TABLE IF NOT EXISTS `lm_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员',
  `group_id` int(11) NOT NULL COMMENT '所属组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_id` (`admin_id`,`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员群组';

-- 正在导出表  meiyue.lm_admin_group 的数据：~1 rows (大约)
DELETE FROM `lm_admin_group`;
/*!40000 ALTER TABLE `lm_admin_group` DISABLE KEYS */;
INSERT INTO `lm_admin_group` (`id`, `admin_id`, `group_id`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `lm_admin_group` ENABLE KEYS */;

-- 导出  表 meiyue.lm_cost 结构
DROP TABLE IF EXISTS `lm_cost`;
CREATE TABLE IF NOT EXISTS `lm_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` double NOT NULL DEFAULT '0' COMMENT '价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='价格管理';

-- 正在导出表  meiyue.lm_cost 的数据：~7 rows (大约)
DELETE FROM `lm_cost`;
/*!40000 ALTER TABLE `lm_cost` DISABLE KEYS */;
INSERT INTO `lm_cost` (`id`, `money`) VALUES
	(1, 300),
	(2, 350),
	(3, 400),
	(4, 450),
	(5, 500),
	(6, 550),
	(7, 600);
/*!40000 ALTER TABLE `lm_cost` ENABLE KEYS */;

-- 导出  表 meiyue.lm_date 结构
DROP TABLE IF EXISTS `lm_date`;
CREATE TABLE IF NOT EXISTS `lm_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_skill_id` int(11) DEFAULT '0' COMMENT '对应管理员录入的技能列表',
  `title` varchar(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
  `start_time` datetime NOT NULL COMMENT '约会开始时间',
  `site` varchar(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
  `end_time` datetime NOT NULL COMMENT '约会结束时间',
  `price` double NOT NULL DEFAULT '0' COMMENT '约会价格',
  `description` varchar(255) DEFAULT '0' COMMENT '约会说明',
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '状态：1#已有人赴约 2#未有人赴约 3#已下线',
  `user_id` int(11) NOT NULL COMMENT '对应美女id',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上线时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会表（美女发布的约会）';

-- 正在导出表  meiyue.lm_date 的数据：~0 rows (大约)
DELETE FROM `lm_date`;
/*!40000 ALTER TABLE `lm_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_date` ENABLE KEYS */;

-- 导出  表 meiyue.lm_dateorder 结构
DROP TABLE IF EXISTS `lm_dateorder`;
CREATE TABLE IF NOT EXISTS `lm_dateorder` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `consumer_id` int(11) NOT NULL DEFAULT '0' COMMENT '男方',
  `consumer` varchar(50) NOT NULL DEFAULT '0' COMMENT '消费者姓名',
  `dater_id` int(11) NOT NULL DEFAULT '0' COMMENT '女方',
  `dater_name` varchar(50) NOT NULL DEFAULT '0' COMMENT '服务提供者姓名',
  `date_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应约会',
  `user_skill_id` int(11) NOT NULL COMMENT '用户技能id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败',
  `operate_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单',
  `site` varchar(50) NOT NULL COMMENT '约会地点',
  `site_lat` float NOT NULL COMMENT '约会地点纬度',
  `site_lng` float NOT NULL COMMENT '约会地点经度',
  `price` double NOT NULL DEFAULT '0' COMMENT '价格',
  `amount` double NOT NULL DEFAULT '0' COMMENT '总金额',
  `is_complain` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被投诉',
  `pre_pay` double NOT NULL DEFAULT '0' COMMENT '预约金',
  `pre_precent` float NOT NULL DEFAULT '0' COMMENT '预约金占比',
  `start_time` datetime NOT NULL COMMENT '开始时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `date_time` tinyint(4) NOT NULL DEFAULT '0' COMMENT '约会总时间',
  `prepay_time` datetime NOT NULL COMMENT '支付预约金时间点',
  `receive_time` datetime NOT NULL COMMENT '美女接单时间点',
  `create_time` datetime NOT NULL COMMENT '生成时间',
  `update_time` datetime NOT NULL COMMENT '订单更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='约单表';

-- 正在导出表  meiyue.lm_dateorder 的数据：~5 rows (大约)
DELETE FROM `lm_dateorder`;
/*!40000 ALTER TABLE `lm_dateorder` DISABLE KEYS */;
INSERT INTO `lm_dateorder` (`id`, `consumer_id`, `consumer`, `dater_id`, `dater_name`, `date_id`, `user_skill_id`, `status`, `operate_status`, `site`, `site_lat`, `site_lng`, `price`, `amount`, `is_complain`, `pre_pay`, `pre_precent`, `start_time`, `end_time`, `date_time`, `prepay_time`, `receive_time`, `create_time`, `update_time`) VALUES
	(2, 18, '王思聪', 4, '曹小萌', 0, 5, 3, 0, '罗拉小厨(锦绣江南店)', 22.645, 114.034, 600, 1800, 0, 360, 0.2, '2016-11-12 01:00:00', '2016-11-12 04:00:00', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-11-11 17:57:54', '2016-11-16 14:32:33'),
	(3, 46, '曹蒹葭', 4, '曹小萌', 0, 9, 4, 0, 'VinCent咖啡', 22.6359, 114.043, 300, 1500, 0, 300, 0.2, '2016-11-21 13:00:00', '2016-11-20 18:00:00', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2016-11-18 14:19:02', '2016-11-30 16:13:14'),
	(25, 46, '曹蒹葭', 3, '曹蒹葭', 0, 1, 4, 0, '名典商旅龙华店-咖啡厅', 22.6504, 114.048, 300, 1200, 0, 240, 0.2, '2016-11-23 11:00:00', '2016-11-20 15:00:00', 4, '0000-00-00 00:00:00', '2016-11-21 23:11:11', '2016-11-21 15:23:28', '2016-11-30 16:11:30'),
	(26, 46, '曹蒹葭', 4, '曹小萌', 0, 5, 6, 0, 'VinCent咖啡', 22.6359, 114.043, 600, 1800, 0, 360, 0.2, '2016-12-01 05:00:00', '2016-12-01 08:00:00', 3, '2016-11-30 16:21:31', '0000-00-00 00:00:00', '2016-11-30 16:21:31', '2016-12-01 16:22:44'),
	(27, 46, '曹蒹葭', 4, '曹小萌', 0, 5, 6, 0, '可口多拿&咖啡(深圳北站店)', 22.6372, 114.037, 600, 3000, 0, 600, 0.2, '2016-12-02 01:00:00', '2016-12-02 06:00:00', 5, '2016-12-01 10:35:50', '0000-00-00 00:00:00', '2016-12-01 10:35:50', '2016-12-01 16:31:34');
/*!40000 ALTER TABLE `lm_dateorder` ENABLE KEYS */;

-- 导出  表 meiyue.lm_date_tag 结构
DROP TABLE IF EXISTS `lm_date_tag`;
CREATE TABLE IF NOT EXISTS `lm_date_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应约会id',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='约会-标签中间表';

-- 正在导出表  meiyue.lm_date_tag 的数据：~1 rows (大约)
DELETE FROM `lm_date_tag`;
/*!40000 ALTER TABLE `lm_date_tag` DISABLE KEYS */;
INSERT INTO `lm_date_tag` (`id`, `date_id`, `tag_id`) VALUES
	(1, 1, 17);
/*!40000 ALTER TABLE `lm_date_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_flow 结构
DROP TABLE IF EXISTS `lm_flow`;
CREATE TABLE IF NOT EXISTS `lm_flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '收款方',
  `buyer_id` int(11) NOT NULL DEFAULT '0' COMMENT '支付方',
  `relate_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '交易类型',
  `type_msg` varchar(50) NOT NULL COMMENT '类型名称',
  `income` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否收入1:收入2:支出',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `pre_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易前金额',
  `after_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易后金额',
  `paytype` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付方式1.余额支付2.平台支付3.微信支付4.支付宝支付',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '交易状态',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8 COMMENT='用户资金流水';

-- 正在导出表  meiyue.lm_flow 的数据：~59 rows (大约)
DELETE FROM `lm_flow`;
/*!40000 ALTER TABLE `lm_flow` DISABLE KEYS */;
INSERT INTO `lm_flow` (`id`, `user_id`, `buyer_id`, `relate_id`, `type`, `type_msg`, `income`, `amount`, `price`, `pre_amount`, `after_amount`, `paytype`, `status`, `remark`, `create_time`, `update_time`) VALUES
	(47, 0, 18, 2, 1, '约技能支出', 2, 360.00, 360.00, 999999.00, 999639.00, 1, 0, '约技能支出', '2016-11-11 17:57:54', '2016-11-11 17:57:54'),
	(52, 0, 18, 2, 2, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(54, 4, 0, 2, 3, '约技能收款', 1, 1800.00, 1800.00, 0.00, 1800.00, 1, 0, '约技收取尾款', '2016-11-16 14:32:33', '2016-11-16 14:32:33'),
	(56, 0, 49, 2, 2, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(57, 0, 49, 2, 1, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(58, 0, 49, 2, 1, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(59, 0, 50, 2, 1, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(61, 0, 46, 2, 2, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(62, 0, 47, 2, 2, '约技能支付尾款', 2, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(64, 46, 46, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(65, 47, 47, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(66, 48, 48, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(67, 49, 49, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(68, 50, 50, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(69, 46, 46, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(70, 46, 46, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(71, 47, 47, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(72, 46, 46, 2, 4, '充值美币', 1, 1440.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(73, 48, 48, 2, 4, '充值美币', 1, 2410.00, 1440.00, 99639.00, 98199.00, 1, 0, '约技能支付尾款', '2016-11-15 20:59:14', '2016-11-15 20:59:14'),
	(74, 0, 46, 3, 1, '约技能支付预约金', 2, 300.00, 300.00, 99999.00, 99699.00, 1, 0, '约技能支出', '2016-11-18 14:19:02', '2016-11-18 14:19:02'),
	(76, 46, 0, 3, 6, '取消约单退回预约金', 1, 300.00, 300.00, 99999.00, 100299.00, 2, 0, '女士取消订单退回预约金', '2016-11-21 10:21:22', '2016-11-21 10:21:22'),
	(77, 46, 0, 3, 7, '取消约单退回预约金', 1, 300.00, 300.00, 100299.00, 100599.00, 2, 0, '女士在接受订单后取消订单退回预约金', '2016-11-21 10:52:50', '2016-11-21 10:52:50'),
	(78, 0, 4, 3, 7, '取消约单退回预约金', 2, 150.00, 150.00, 1800.00, 1650.00, 1, 0, '女士在接受订单后取消订单退回预约金', '2016-11-21 10:52:50', '2016-11-21 10:52:50'),
	(83, 46, 0, 3, 7, '取消约单退回预约金', 1, 300.00, 300.00, 100899.00, 101199.00, 2, 0, '女士在接受订单后取消订单退回预约金', '2016-11-21 11:25:15', '2016-11-21 11:25:15'),
	(84, 0, 4, 3, 7, '取消约单退回预约金', 2, 150.00, 150.00, 1500.00, 1350.00, 1, 0, '女士在接受订单后取消订单扣除10%的约单金额作为惩罚', '2016-11-21 11:25:15', '2016-11-21 11:25:15'),
	(85, 0, 46, 3, 2, '约技能支付尾款', 2, 1200.00, 1200.00, 101199.00, 99999.00, 1, 0, '约技能支付尾款', '2016-11-21 11:46:15', '2016-11-21 11:46:15'),
	(86, 46, 0, 3, 9, '取消约单退回约单金额', 1, 1050.00, 1050.00, 99999.00, 101049.00, 1, 0, '男士在接受订单后约会时间2小时之内取消订单退回预约金', '2016-11-21 12:07:25', '2016-11-21 12:07:25'),
	(87, 4, 0, 3, 9, '取消约单退回约单金额', 1, 450.00, 450.00, 1350.00, 900.00, 1, 0, '男士在接受订单后约会时间2小时之内取消订单退回预约金', '2016-11-21 12:07:25', '2016-11-21 12:07:25'),
	(88, 0, 46, 4, 1, '约技能支付预约金', 2, 300.00, 300.00, 101049.00, 100749.00, 1, 0, '约技能支出', '2016-11-21 14:36:45', '2016-11-21 14:36:45'),
	(89, 0, 46, 5, 1, '约技能支付预约金', 2, 300.00, 300.00, 100749.00, 100449.00, 1, 0, '约技能支出', '2016-11-21 14:36:45', '2016-11-21 14:36:45'),
	(90, 0, 46, 6, 1, '约技能支付预约金', 2, 300.00, 300.00, 100449.00, 100149.00, 1, 0, '约技能支出', '2016-11-21 14:36:46', '2016-11-21 14:36:46'),
	(91, 0, 46, 7, 1, '约技能支付预约金', 2, 300.00, 300.00, 100149.00, 99849.00, 1, 0, '约技能支出', '2016-11-21 14:40:37', '2016-11-21 14:40:37'),
	(92, 0, 46, 8, 1, '约技能支付预约金', 2, 300.00, 300.00, 99849.00, 99549.00, 1, 0, '约技能支出', '2016-11-21 14:40:39', '2016-11-21 14:40:39'),
	(93, 0, 46, 9, 1, '约技能支付预约金', 2, 300.00, 300.00, 99549.00, 99249.00, 1, 0, '约技能支出', '2016-11-21 14:40:40', '2016-11-21 14:40:40'),
	(94, 0, 46, 10, 1, '约技能支付预约金', 2, 300.00, 300.00, 99249.00, 98949.00, 1, 0, '约技能支出', '2016-11-21 14:40:40', '2016-11-21 14:40:40'),
	(95, 0, 46, 11, 1, '约技能支付预约金', 2, 300.00, 300.00, 98949.00, 98649.00, 1, 0, '约技能支出', '2016-11-21 14:40:41', '2016-11-21 14:40:41'),
	(96, 0, 46, 12, 1, '约技能支付预约金', 2, 300.00, 300.00, 98649.00, 98349.00, 1, 0, '约技能支出', '2016-11-21 14:40:41', '2016-11-21 14:40:41'),
	(97, 0, 46, 13, 1, '约技能支付预约金', 2, 300.00, 300.00, 98349.00, 98049.00, 1, 0, '约技能支出', '2016-11-21 14:40:41', '2016-11-21 14:40:41'),
	(98, 0, 46, 14, 1, '约技能支付预约金', 2, 300.00, 300.00, 98049.00, 97749.00, 1, 0, '约技能支出', '2016-11-21 14:40:42', '2016-11-21 14:40:42'),
	(99, 0, 46, 15, 1, '约技能支付预约金', 2, 300.00, 300.00, 97749.00, 97449.00, 1, 0, '约技能支出', '2016-11-21 14:40:42', '2016-11-21 14:40:42'),
	(100, 0, 46, 16, 1, '约技能支付预约金', 2, 300.00, 300.00, 97449.00, 97149.00, 1, 0, '约技能支出', '2016-11-21 14:40:43', '2016-11-21 14:40:43'),
	(101, 0, 46, 17, 1, '约技能支付预约金', 2, 300.00, 300.00, 97149.00, 96849.00, 1, 0, '约技能支出', '2016-11-21 14:40:43', '2016-11-21 14:40:43'),
	(102, 0, 46, 18, 1, '约技能支付预约金', 2, 300.00, 300.00, 96849.00, 96549.00, 1, 0, '约技能支出', '2016-11-21 14:41:36', '2016-11-21 14:41:36'),
	(103, 0, 46, 19, 1, '约技能支付预约金', 2, 300.00, 300.00, 96549.00, 96249.00, 1, 0, '约技能支出', '2016-11-21 14:46:05', '2016-11-21 14:46:05'),
	(104, 0, 46, 20, 1, '约技能支付预约金', 2, 300.00, 300.00, 96249.00, 95949.00, 1, 0, '约技能支出', '2016-11-21 15:02:25', '2016-11-21 15:02:25'),
	(105, 0, 46, 21, 1, '约技能支付预约金', 2, 300.00, 300.00, 95949.00, 95649.00, 1, 0, '约技能支出', '2016-11-21 15:02:45', '2016-11-21 15:02:45'),
	(106, 0, 46, 22, 1, '约技能支付预约金', 2, 300.00, 300.00, 95649.00, 95349.00, 1, 0, '约技能支出', '2016-11-21 15:04:39', '2016-11-21 15:04:39'),
	(107, 0, 46, 23, 1, '约技能支付预约金', 2, 300.00, 300.00, 95349.00, 95049.00, 1, 0, '约技能支出', '2016-11-21 15:05:37', '2016-11-21 15:05:37'),
	(108, 0, 46, 24, 1, '约技能支付预约金', 2, 300.00, 300.00, 95049.00, 94749.00, 1, 0, '约技能支出', '2016-11-21 15:09:11', '2016-11-21 15:09:11'),
	(109, 0, 46, 25, 1, '约技能支付预约金', 2, 240.00, 240.00, 94749.00, 94509.00, 1, 0, '约技能支出', '2016-11-21 15:23:28', '2016-11-21 15:23:28'),
	(110, 46, 0, 25, 10, '自动退单退款', 1, 1200.00, 1200.00, 94509.00, 95709.00, 2, 0, '支付完预约金后60分钟无响应,自动退单', '2016-11-22 16:10:38', '2016-11-22 16:10:38'),
	(111, 3, 0, 25, 11, '违约预约金', 1, 240.00, 240.00, 0.00, 240.00, 2, 0, '接受约单后6小时未支付尾款', '2016-11-22 16:52:38', '2016-11-22 16:52:38'),
	(112, 3, 0, 25, 12, '约会收入', 1, 1200.00, 1200.00, 240.00, 1440.00, 2, 0, '24小时无操作订单自动完成', '2016-11-22 17:25:44', '2016-11-22 17:25:44'),
	(113, 46, 0, 25, 5, '取消约单退回预约金', 1, 240.00, 240.00, 95709.00, 95949.00, 2, 0, '男士取消订单退回预约金', '2016-11-30 16:11:30', '2016-11-30 16:11:30'),
	(114, 46, 0, 3, 5, '取消约单退回预约金', 1, 300.00, 300.00, 95949.00, 96249.00, 2, 0, '男士取消订单退回预约金', '2016-11-30 16:13:14', '2016-11-30 16:13:14'),
	(115, 0, 46, 26, 1, '约技能支付预约金', 2, 360.00, 360.00, 96249.00, 95889.00, 1, 0, '约技能支出', '2016-11-30 16:21:31', '2016-11-30 16:21:31'),
	(116, 0, 46, 27, 1, '约技能支付预约金', 2, 600.00, 600.00, 95889.00, 95289.00, 1, 0, '约技能支出', '2016-12-01 10:35:50', '2016-12-01 10:35:50'),
	(117, 46, 0, 26, 10, '自动退单退款', 1, 360.00, 360.00, 95289.00, 95649.00, 2, 0, '支付完预约金后60分钟无响应,自动退单', '2016-12-01 16:22:44', '2016-12-01 16:22:44'),
	(118, 46, 0, 27, 10, '自动退单退款', 1, 600.00, 600.00, 95649.00, 96249.00, 2, 0, '支付完预约金后60分钟无响应,自动退单', '2016-12-01 16:31:34', '2016-12-01 16:31:34');
/*!40000 ALTER TABLE `lm_flow` ENABLE KEYS */;

-- 导出  表 meiyue.lm_gift 结构
DROP TABLE IF EXISTS `lm_gift`;
CREATE TABLE IF NOT EXISTS `lm_gift` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '0' COMMENT '礼物价格',
  `name` varchar(50) DEFAULT NULL COMMENT '礼物名称',
  `pic` varchar(50) NOT NULL COMMENT '礼物图片',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼物表';

-- 正在导出表  meiyue.lm_gift 的数据：~0 rows (大约)
DELETE FROM `lm_gift`;
/*!40000 ALTER TABLE `lm_gift` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_gift` ENABLE KEYS */;

-- 导出  表 meiyue.lm_group 结构
DROP TABLE IF EXISTS `lm_group`;
CREATE TABLE IF NOT EXISTS `lm_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '群组名称',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `utime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员群组';

-- 正在导出表  meiyue.lm_group 的数据：~1 rows (大约)
DELETE FROM `lm_group`;
/*!40000 ALTER TABLE `lm_group` DISABLE KEYS */;
INSERT INTO `lm_group` (`id`, `name`, `remark`, `ctime`, `utime`) VALUES
	(1, '超级管理员', '无限权限', '2016-10-18 14:25:32', '2016-10-18 14:25:32');
/*!40000 ALTER TABLE `lm_group` ENABLE KEYS */;

-- 导出  表 meiyue.lm_group_menu 结构
DROP TABLE IF EXISTS `lm_group_menu`;
CREATE TABLE IF NOT EXISTS `lm_group_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '群组',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.lm_group_menu 的数据：~0 rows (大约)
DELETE FROM `lm_group_menu`;
/*!40000 ALTER TABLE `lm_group_menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_group_menu` ENABLE KEYS */;

-- 导出  表 meiyue.lm_log 结构
DROP TABLE IF EXISTS `lm_log`;
CREATE TABLE IF NOT EXISTS `lm_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` varchar(50) NOT NULL DEFAULT '',
  `msg` varchar(550) NOT NULL DEFAULT '',
  `data` text,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='重要的信息日志记录';

-- 正在导出表  meiyue.lm_log 的数据：~5 rows (大约)
DELETE FROM `lm_log`;
/*!40000 ALTER TABLE `lm_log` DISABLE KEYS */;
INSERT INTO `lm_log` (`id`, `flag`, `msg`, `data`, `create_time`) VALUES
	(1, 'dateorder', '1条约单被执行自动退单', '\'order_id:25\'', '2016-11-22 16:10:38'),
	(2, 'dateorder', '1条约单被执行自动退单', '\'dateorder_id:25\'', '2016-11-22 16:52:38'),
	(3, 'dateorder', '1条约单被执行状态10操作', '\'dateorder_id:25\'', '2016-11-22 17:25:45'),
	(4, 'dateorder', '1条约单被执行状态3操作', '\'dateorder_id:26\'', '2016-12-01 16:22:44'),
	(5, 'dateorder', '1条约单被执行状态3操作', '\'dateorder_id:27\'', '2016-12-01 16:31:34');
/*!40000 ALTER TABLE `lm_log` ENABLE KEYS */;

-- 导出  表 meiyue.lm_menu 结构
DROP TABLE IF EXISTS `lm_menu`;
CREATE TABLE IF NOT EXISTS `lm_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL COMMENT '节点名称',
  `node` varchar(50) DEFAULT NULL COMMENT '路径',
  `pid` int(11) NOT NULL COMMENT '父ID',
  `class` varchar(50) DEFAULT NULL COMMENT '样式',
  `rank` int(6) DEFAULT NULL COMMENT '排序',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否在菜单显示',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.lm_menu 的数据：~21 rows (大约)
DELETE FROM `lm_menu`;
/*!40000 ALTER TABLE `lm_menu` DISABLE KEYS */;
INSERT INTO `lm_menu` (`id`, `name`, `node`, `pid`, `class`, `rank`, `is_menu`, `status`, `remark`) VALUES
	(1, '系统设置', '', 0, 'icon-cogs', NULL, 1, 1, ''),
	(2, '菜单管理', '/menu/index', 1, 'icon-list', NULL, 1, 1, ''),
	(3, '用户管理', '/user/index', 7, 'icon-user', NULL, 1, 1, ''),
	(4, '管理员管理', '/admin/index', 1, 'icon-android', NULL, 1, 1, ''),
	(5, '群组管理', '/group/index', 1, 'icon-group', NULL, 1, 1, ''),
	(6, '操作日志管理', '/actionlog/index', 1, 'icon-keyboard', NULL, 1, 1, ''),
	(7, '用户管理', '', 0, 'icon-user', 100, 1, 1, ''),
	(8, '活动管理', '', 0, 'icon-cubes', 99, 1, 1, ''),
	(9, '基础管理', '', 0, 'icon-toggle-on', 90, 1, 1, ''),
	(10, '客户服务', '', 0, 'icon-group', 91, 1, 1, ''),
	(11, '用户技能管理', '/user-skill/index', 10, 'icon-server', 10, 1, 1, ''),
	(12, '技能管理', '/skill/index', 9, 'icon-toggle-on', 10, 1, 1, ''),
	(13, '标签管理', '/tag/index', 9, 'icon-tag', 9, 1, 1, ''),
	(14, '价格管理', '/cost/index', 9, 'icon-credit', 8, 1, 1, ''),
	(15, '派对管理', '/activity/index', 8, 'icon-coffee', 10, 1, 1, ''),
	(16, '礼物设置', '/gift/index', 9, 'icon-gift', 6, 1, 1, ''),
	(17, '订单管理', '', 0, 'icon-th-list', 97, 1, 1, ''),
	(18, '套餐管理', '/package/index', 0, 'icon-list-alt', 95, 1, 1, ''),
	(19, '套餐购买管理', '/package/index', 18, 'icon-server', 10, 1, 1, ''),
	(20, '约拍管理', '/yuepai/index', 9, 'icon-camera-retro', 5, 1, 1, ''),
	(21, '约拍申请', '/yuepai-user/index', 10, 'icon-building', 9, 1, 1, '');
/*!40000 ALTER TABLE `lm_menu` ENABLE KEYS */;

-- 导出  表 meiyue.lm_movement 结构
DROP TABLE IF EXISTS `lm_movement`;
CREATE TABLE IF NOT EXISTS `lm_movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:图片动态2.视频动态',
  `body` varchar(550) DEFAULT NULL COMMENT '动态内容',
  `images` text,
  `video` varchar(250) DEFAULT NULL,
  `video_cover` varchar(250) DEFAULT NULL,
  `view_nums` int(11) DEFAULT '0' COMMENT '查看数',
  `praise_nums` int(11) DEFAULT '0' COMMENT '点赞数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1待审核2审核通过3审核不通过',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='动态';

-- 正在导出表  meiyue.lm_movement 的数据：~3 rows (大约)
DELETE FROM `lm_movement`;
/*!40000 ALTER TABLE `lm_movement` DISABLE KEYS */;
INSERT INTO `lm_movement` (`id`, `user_id`, `type`, `body`, `images`, `video`, `video_cover`, `view_nums`, `praise_nums`, `status`, `create_time`, `update_time`) VALUES
	(1, 4, 1, '哈哈哈', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-24/58366975dfc3a.png";i:1;s:48:"/upload/user/images/2016-11-24/58366975e0489.png";i:2;s:48:"/upload/user/images/2016-11-24/58366975e0f31.png";i:3;s:48:"/upload/user/images/2016-11-24/58366975e1783.png";i:4;s:48:"/upload/user/images/2016-11-24/58366975e7bb8.png";i:5;s:48:"/upload/user/images/2016-11-24/58366975e83e3.png";i:6;s:48:"/upload/user/images/2016-11-24/58366975e8b2c.png";i:7;s:48:"/upload/user/images/2016-11-24/58366975e918d.png";i:8;s:48:"/upload/user/images/2016-11-24/58366975e98bd.png";}', NULL, NULL, 0, 0, 2, '2016-11-24 12:19:33', '2016-11-24 12:15:49'),
	(2, 4, 2, '无限售后才', NULL, '/upload/user/video/2016-11-24/5836a481e1fed.mp4', '/upload/user/video/2016-11-24/5836a481e4992.png', 0, 0, 2, '2016-11-24 16:27:45', '2016-11-24 16:27:45'),
	(3, 3, 1, '哈哈美约好好玩', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-25/5837b0532e0a6.png";i:1;s:48:"/upload/user/images/2016-11-25/5837b0533162b.png";i:2;s:48:"/upload/user/images/2016-11-25/5837b053347ad.png";i:3;s:48:"/upload/user/images/2016-11-25/5837b0533512c.png";i:4;s:48:"/upload/user/images/2016-11-25/5837b05335898.png";i:5;s:48:"/upload/user/images/2016-11-25/5837b05336040.png";i:6;s:48:"/upload/user/images/2016-11-25/5837b0533961c.png";i:7;s:48:"/upload/user/images/2016-11-25/5837b05339d47.png";i:8;s:48:"/upload/user/images/2016-11-25/5837b0533a49c.png";}', NULL, NULL, 0, 0, 2, '2016-11-25 11:30:27', '2016-11-25 11:30:27');
/*!40000 ALTER TABLE `lm_movement` ENABLE KEYS */;

-- 导出  表 meiyue.lm_package 结构
DROP TABLE IF EXISTS `lm_package`;
CREATE TABLE IF NOT EXISTS `lm_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0' COMMENT '套餐名称',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '套餐类型：1#vip套餐 2#充值套餐 3#其他套餐',
  `chat_num` int(11) NOT NULL DEFAULT '0' COMMENT '美女聊天名额',
  `browse_num` int(11) NOT NULL DEFAULT '0' COMMENT '查看动态名额',
  `vir_money` double NOT NULL DEFAULT '0' COMMENT '美币数量',
  `price` double NOT NULL DEFAULT '0' COMMENT '价格',
  `stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `vali_time` int(11) DEFAULT '0' COMMENT '有效期（单位:天）：-1表示无限',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建日期',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改日期',
  `show_order` smallint(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `is_used` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否启用：1#启用 0#禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='套餐表（包括vip、充值、其他等）';

-- 正在导出表  meiyue.lm_package 的数据：~0 rows (大约)
DELETE FROM `lm_package`;
/*!40000 ALTER TABLE `lm_package` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_package` ENABLE KEYS */;

-- 导出  表 meiyue.lm_payorder 结构
DROP TABLE IF EXISTS `lm_payorder`;
CREATE TABLE IF NOT EXISTS `lm_payorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单类型1充值美币',
  `relate_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id(买家id)',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '卖家id',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '订单标题',
  `order_no` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `out_trade_no` varchar(50) DEFAULT '' COMMENT '支付方的订单号',
  `paytype` tinyint(4) DEFAULT '0' COMMENT '实际支付方式：1微信2支付宝',
  `price` decimal(10,2) NOT NULL COMMENT '定价',
  `fee` decimal(10,2) NOT NULL COMMENT '实际支付',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态0未完成1已完成',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_no` (`order_no`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='支付订单表对接微信支付宝支付';

-- 正在导出表  meiyue.lm_payorder 的数据：~19 rows (大约)
DELETE FROM `lm_payorder`;
/*!40000 ALTER TABLE `lm_payorder` DISABLE KEYS */;
INSERT INTO `lm_payorder` (`id`, `type`, `relate_id`, `user_id`, `seller_id`, `title`, `order_no`, `out_trade_no`, `paytype`, `price`, `fee`, `remark`, `status`, `create_time`, `update_time`) VALUES
	(2, 1, 0, 46, 0, '美约美币充值', '148030049246CQJS', '', 0, 1000.00, 0.00, '充值美币1000个', 0, '2016-11-28 10:34:52', '2016-11-28 10:34:52'),
	(3, 1, 0, 46, 0, '美约美币充值', '148030712346HDAE', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-28 12:25:23', '2016-11-28 12:25:23'),
	(4, 1, 0, 46, 0, '美约美币充值', '148030723146CHXQ', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-28 12:27:11', '2016-11-28 12:27:11'),
	(5, 1, 0, 46, 0, '美约美币充值', '148031408046U6VO', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-28 14:21:20', '2016-11-28 14:21:20'),
	(6, 1, 0, 46, 0, '美约美币充值', '148031799246DF9T', '', 0, 33.00, 0.00, '充值美币33个', 0, '2016-11-28 15:26:33', '2016-11-28 15:26:33'),
	(7, 1, 0, 46, 0, '美约美币充值', '1480412971461CAY', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-29 17:49:31', '2016-11-29 17:49:31'),
	(8, 1, 0, 46, 0, '美约美币充值', '14804131744677EA', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-29 17:52:54', '2016-11-29 17:52:54'),
	(9, 1, 0, 46, 0, '美约美币充值', '148041332346ZN8T', '', 0, 1000.00, 0.00, '充值美币1000个', 0, '2016-11-29 17:55:23', '2016-11-29 17:55:23'),
	(10, 1, 0, 46, 0, '美约美币充值', '148041354046FD1O', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-29 17:59:00', '2016-11-29 17:59:00'),
	(11, 1, 0, 46, 0, '美约美币充值', '148041551246098F', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-29 18:31:52', '2016-11-29 18:31:52'),
	(12, 1, 0, 46, 0, '美约美币充值', '14804182884629SW', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-29 19:18:08', '2016-11-29 19:18:08'),
	(13, 1, 0, 46, 0, '美约美币充值', '148049719546PFGK', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-30 17:13:15', '2016-11-30 17:13:15'),
	(14, 1, 0, 46, 0, '美约美币充值', '148049775346AW3H', '', 0, 100.00, 0.00, '充值美币100个', 0, '2016-11-30 17:22:33', '2016-11-30 17:22:33'),
	(15, 1, 0, 46, 0, '美约美币充值', '148050817246HCBK', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-30 20:16:12', '2016-11-30 20:16:12'),
	(16, 1, 0, 46, 0, '美约美币充值', '1480508974462IE9', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-30 20:29:34', '2016-11-30 20:29:34'),
	(17, 1, 0, 46, 0, '美约美币充值', '148050952446G590', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-11-30 20:38:44', '2016-11-30 20:38:44'),
	(18, 1, 0, 46, 0, '美约美币充值', '1480668048461Y8H', '', 0, 10.00, 0.00, '充值美币10个', 0, '2016-12-02 16:40:48', '2016-12-02 16:40:48'),
	(19, 1, 0, 46, 0, '美约美币充值', '148066955946QQU3', '', 0, 1.00, 0.00, '充值美币1个', 0, '2016-12-02 17:05:59', '2016-12-02 17:05:59'),
	(20, 1, 0, 46, 0, '美约美币充值', '1480673645467WYN', '', 0, 1.00, 0.00, '充值美币1个', 0, '2016-12-02 18:14:05', '2016-12-02 18:14:05');
/*!40000 ALTER TABLE `lm_payorder` ENABLE KEYS */;

-- 导出  表 meiyue.lm_skill 结构
DROP TABLE IF EXISTS `lm_skill`;
CREATE TABLE IF NOT EXISTS `lm_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '技能名称',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='技能表（管理员创建）';

-- 正在导出表  meiyue.lm_skill 的数据：~8 rows (大约)
DELETE FROM `lm_skill`;
/*!40000 ALTER TABLE `lm_skill` DISABLE KEYS */;
INSERT INTO `lm_skill` (`id`, `name`, `parent_id`) VALUES
	(1, '工作', 0),
	(2, '美食', 0),
	(3, '运动', 0),
	(4, '娱乐', 0),
	(5, '吃韩国料理', 2),
	(6, '股市看法', 1),
	(7, '打高尔夫', 3),
	(8, '打dota2', 4);
/*!40000 ALTER TABLE `lm_skill` ENABLE KEYS */;

-- 导出  表 meiyue.lm_smsmsg 结构
DROP TABLE IF EXISTS `lm_smsmsg`;
CREATE TABLE IF NOT EXISTS `lm_smsmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(50) NOT NULL DEFAULT '0' COMMENT '手机号',
  `code` varchar(50) DEFAULT NULL COMMENT '验证码',
  `content` varchar(250) DEFAULT NULL COMMENT '内容',
  `expire_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='短信记录';

-- 正在导出表  meiyue.lm_smsmsg 的数据：~56 rows (大约)
DELETE FROM `lm_smsmsg`;
/*!40000 ALTER TABLE `lm_smsmsg` DISABLE KEYS */;
INSERT INTO `lm_smsmsg` (`id`, `phone`, `code`, `content`, `expire_time`, `create_time`) VALUES
	(1, '18316629973', '8471', '您的动态验证码为8471', NULL, '2016-10-23 12:01:54'),
	(2, '18316629973', '8206', '您的动态验证码为8206', NULL, '2016-10-23 14:22:51'),
	(3, '18316629973', '3798', '您的动态验证码为3798', NULL, '2016-10-24 11:02:06'),
	(5, '18316629973', '6499', '您的动态验证码为6499', 1477282990, '2016-10-24 12:13:10'),
	(6, '18316629973', '7107', '您的动态验证码为7107', 1477468507, '2016-10-26 15:45:07'),
	(7, '18316629973', '1708', '您的动态验证码为1708', 1477468627, '2016-10-26 15:47:07'),
	(8, '18316629973', '9510', '您的动态验证码为9510', 1477468737, '2016-10-26 15:48:57'),
	(9, '18316629973', '6580', '您的动态验证码为6580', 1477473329, '2016-10-26 17:05:29'),
	(10, '18316629973', '5199', '您的动态验证码为5199', 1477473355, '2016-10-26 17:05:55'),
	(11, '18316629973', '6023', '您的动态验证码为6023', 1477473440, '2016-10-26 17:07:20'),
	(12, '18316629973', '7126', '您的动态验证码为7126', 1477474079, '2016-10-26 17:17:59'),
	(13, '18316629973', '9657', '您的动态验证码为9657', 1477474571, '2016-10-26 17:26:11'),
	(14, '18316629973', '2042', '您的动态验证码为2042,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477556698, '2016-10-27 16:14:58'),
	(15, '18316629973', '5098', '您的动态验证码为5098,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477556699, '2016-10-27 16:14:59'),
	(16, '18316629973', '6916', '您的动态验证码为6916,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477556908, '2016-10-27 16:18:28'),
	(17, '18316629973', '0317', '您的动态验证码为0317,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477884333, '2016-10-31 11:15:33'),
	(18, '18316629973', '0360', '您的动态验证码为0360,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477896834, '2016-10-31 14:43:54'),
	(19, '18316629973', '5679', '您的动态验证码为5679,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1478570298, '2016-11-08 09:48:18'),
	(20, '18316629973', '4527', '您的动态验证码为4527,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1478570445, '2016-11-08 09:50:45'),
	(21, '18316629973', '', 'welber已接受你发出的【打dota2】邀请，请您尽快支付尾款.', 1479183395, '2016-11-15 12:06:35'),
	(22, '18316629973', '', 'welber已接受你发出的【打dota2】邀请，请您尽快支付尾款.', 1479197498, '2016-11-15 16:01:38'),
	(23, '18681540783', '', '国民老公已支付您的【打dota2】技能约单尾款，请及时赴约.', 1479214589, '2016-11-15 20:46:29'),
	(24, '18681540783', '', '国民老公已支付您的【打dota2】技能约单尾款，请及时赴约.', 1479215354, '2016-11-15 20:59:14'),
	(25, '18316629973', '', 'welber已到达约会目的地，请及时到场赴约.', 1479267654, '2016-11-16 11:30:54'),
	(26, '18316629973', '3316', '您的动态验证码为3316,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479279016, '2016-11-16 14:40:16'),
	(27, '18316629973', '7154', '您的动态验证码为7154,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479291019, '2016-11-16 18:00:19'),
	(28, '18316629973', '8054', '您的动态验证码为8054,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479292798, '2016-11-16 18:29:58'),
	(29, '18316629973', '2933', '您的动态验证码为2933,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479293972, '2016-11-16 18:49:32'),
	(30, '18316629973', '9581', '您的动态验证码为9581,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479298057, '2016-11-16 19:57:37'),
	(31, '18316629973', '7479', '您的动态验证码为7479,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479298360, '2016-11-16 20:02:40'),
	(32, '18316629973', '9535', '您的动态验证码为9535,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479299101, '2016-11-16 20:15:01'),
	(33, '18316629973', '4167', '您的动态验证码为4167,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479299507, '2016-11-16 20:21:47'),
	(34, '18316629973', '9415', '您的动态验证码为9415,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479299957, '2016-11-16 20:29:17'),
	(35, '18316629973', '7202', '您的动态验证码为7202,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479300573, '2016-11-16 20:39:33'),
	(36, '18316629973', '8096', '您的动态验证码为8096,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479347162, '2016-11-17 09:36:02'),
	(37, '18316629973', '1918', '您的动态验证码为1918,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479347167, '2016-11-17 09:36:07'),
	(38, '15986227560', '3914', '您的动态验证码为3914,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479349618, '2016-11-17 10:16:58'),
	(39, '15914057632', '4228', '您的动态验证码为4228,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479349921, '2016-11-17 10:22:01'),
	(40, '18316629973', '3016', '您的动态验证码为3016,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479350672, '2016-11-17 10:34:32'),
	(41, '18316629976', '1864', '您的动态验证码为1864,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479351056, '2016-11-17 10:40:56'),
	(42, '18316629972', '7510', '您的动态验证码为7510,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479366640, '2016-11-17 15:00:40'),
	(43, '18316629972', '5017', '您的动态验证码为5017,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1479366682, '2016-11-17 15:01:22'),
	(44, '18316629973', '', 'welber已接受你发出的【打高尔夫】邀请，请您尽快支付尾款.', 1479695928, '2016-11-21 10:28:48'),
	(45, '18316629973', '', 'welber已接受你发出的【打高尔夫】邀请，请您尽快支付尾款.', 1479699514, '2016-11-21 11:28:34'),
	(46, '18316629973', '', 'welber已接受你发出的【打高尔夫】邀请，请您尽快支付尾款.', 1479699534, '2016-11-21 11:28:54'),
	(47, '18681540783', '', '王思聪已支付您的【打高尔夫】技能约单尾款，请及时赴约.', 1479700576, '2016-11-21 11:46:16'),
	(48, '18681540783', '', '用户王思聪已支付了您的技能预约费,请尽快前往平台确认', 1479712479, '2016-11-21 15:04:39'),
	(49, '18681540783', '', '用户王思聪已支付了您的打高尔夫技能预约费,请尽快前往平台确认', 1479712537, '2016-11-21 15:05:37'),
	(50, '18681540783', '', '用户王思聪已支付了您的打高尔夫技能预约费,请尽快前往平台确认', 1479712751, '2016-11-21 15:09:11'),
	(51, '18316629979', '', '用户王思聪已支付了您的吃韩国料理技能预约费,请尽快前往平台确认', 1479713609, '2016-11-21 15:23:29'),
	(52, '18681540783', '', '用户王思聪已支付了您的打dota2技能预约费,请尽快前往平台确认', 1480494692, '2016-11-30 16:21:32'),
	(53, '18681540783', '', '用户王思聪已支付了您的打dota2技能预约费,请尽快前往平台确认', 1480560351, '2016-12-01 10:35:51'),
	(54, '18316629973', '5204', '您的动态验证码为5204,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1480673738, '2016-12-02 18:05:38'),
	(55, '18316629973', '0968', '您的动态验证码为0968,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1480675191, '2016-12-02 18:29:51'),
	(56, '18316629973', '6192', '您的动态验证码为6192,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1480680719, '2016-12-02 20:01:59'),
	(57, '18316629973', '2926', '您的动态验证码为2926,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1480681538, '2016-12-02 20:15:38');
/*!40000 ALTER TABLE `lm_smsmsg` ENABLE KEYS */;

-- 导出  表 meiyue.lm_support 结构
DROP TABLE IF EXISTS `lm_support`;
CREATE TABLE IF NOT EXISTS `lm_support` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supporter_id` int(11) NOT NULL DEFAULT '0' COMMENT '支持者id',
  `supported_id` int(11) NOT NULL DEFAULT '0' COMMENT '被支持者id',
  `gift_id` int(11) NOT NULL DEFAULT '0' COMMENT '礼物id',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支持列表';

-- 正在导出表  meiyue.lm_support 的数据：~0 rows (大约)
DELETE FROM `lm_support`;
/*!40000 ALTER TABLE `lm_support` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_support` ENABLE KEYS */;

-- 导出  表 meiyue.lm_tag 结构
DROP TABLE IF EXISTS `lm_tag`;
CREATE TABLE IF NOT EXISTS `lm_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='标签表';

-- 正在导出表  meiyue.lm_tag 的数据：~37 rows (大约)
DELETE FROM `lm_tag`;
/*!40000 ALTER TABLE `lm_tag` DISABLE KEYS */;
INSERT INTO `lm_tag` (`id`, `name`, `parent_id`) VALUES
	(1, '常规', 0),
	(2, '创意', 0),
	(3, '小鸟依人', 1),
	(4, '成熟大方', 1),
	(5, '性感火辣', 1),
	(6, '青春可爱', 1),
	(7, '文艺女青年', 1),
	(8, '安静淑女', 1),
	(9, '气质优雅', 1),
	(10, '温柔体贴', 1),
	(11, '清纯呆萌', 1),
	(12, '霸气女王', 1),
	(13, '热情奔放', 1),
	(14, '高贵冷艳', 1),
	(15, '活泼开朗', 1),
	(16, '风趣幽默', 1),
	(17, '千杯不醉', 2),
	(18, '天下第一长腿', 2),
	(19, '1顿吃8碗', 2),
	(20, '颜值爆表/颜值逆天/颜值担当', 2),
	(21, '四千年一遇', 2),
	(22, 'A4腰', 2),
	(23, '萌妹纸', 2),
	(24, '氧气美女', 2),
	(25, '女神范儿', 2),
	(26, '天仙攻', 2),
	(27, '攻气十足', 2),
	(28, '宅男女神', 2),
	(29, '长发及腰', 2),
	(30, '我是逗比', 2),
	(31, '美貌与智慧并重', 2),
	(32, '人靓声甜', 2),
	(33, '邻家小妹妹', 2),
	(34, '自带光环', 2),
	(35, '无敌吃货', 2),
	(36, '自然萌天然呆', 2),
	(37, '小公举', 2);
/*!40000 ALTER TABLE `lm_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_used_package 结构
DROP TABLE IF EXISTS `lm_used_package`;
CREATE TABLE IF NOT EXISTS `lm_used_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用者id',
  `used_id` int(11) NOT NULL DEFAULT '0' COMMENT '作用对象id',
  `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '所购买的套餐id',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '消费类型：1#查看动态服务 2#聊天服务',
  `vali_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '该消费有效期',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户使用套餐情况表';

-- 正在导出表  meiyue.lm_used_package 的数据：~0 rows (大约)
DELETE FROM `lm_used_package`;
/*!40000 ALTER TABLE `lm_used_package` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_used_package` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user 结构
DROP TABLE IF EXISTS `lm_user`;
CREATE TABLE IF NOT EXISTS `lm_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `pwd` varchar(120) NOT NULL COMMENT '密码',
  `user_token` varchar(20) NOT NULL COMMENT '用户标志',
  `union_id` varchar(100) DEFAULT '' COMMENT 'wx_unionid',
  `wx_openid` varchar(100) DEFAULT '' COMMENT '微信的openid',
  `app_wx_openid` varchar(100) DEFAULT '' COMMENT 'app端的微信id',
  `nick` varchar(20) DEFAULT '' COMMENT '昵称',
  `truename` varchar(20) DEFAULT '' COMMENT '真实姓名',
  `profession` varchar(20) DEFAULT '' COMMENT '职业',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `gender` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1,男，2女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `zodiac` tinyint(4) DEFAULT '0' COMMENT '星座',
  `weight` tinyint(4) DEFAULT '0' COMMENT '体重(KG)',
  `height` tinyint(4) DEFAULT '0' COMMENT '身高(cm)',
  `bwh` varchar(30) DEFAULT '' COMMENT '三围',
  `cup` varchar(20) DEFAULT '' COMMENT '罩杯',
  `hometown` varchar(20) DEFAULT '' COMMENT '家乡',
  `city` varchar(50) DEFAULT '' COMMENT '常驻城市',
  `avatar` varchar(250) DEFAULT '' COMMENT '头像',
  `state` tinyint(4) DEFAULT '1' COMMENT '情感状态',
  `career` varchar(100) DEFAULT '' COMMENT '工作经历',
  `place` varchar(100) DEFAULT '' COMMENT '常出没地',
  `food` varchar(20) DEFAULT '' COMMENT '最喜欢美食',
  `music` varchar(20) DEFAULT '' COMMENT '音乐',
  `movie` varchar(20) DEFAULT '' COMMENT '电影',
  `sport` varchar(20) DEFAULT '' COMMENT '运动',
  `sign` varchar(120) DEFAULT '' COMMENT '个性签名',
  `wxid` varchar(50) DEFAULT '' COMMENT '微信号',
  `money` float NOT NULL DEFAULT '0' COMMENT '账户余额(美币)',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核状态1待审核2审核不通过3审核通过0不审核(男)',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账号状态 ：1.可用0禁用(控制登录)',
  `idpath` varchar(250) DEFAULT '' COMMENT '身份证路径',
  `idfront` varchar(250) DEFAULT '' COMMENT '身份证正面照',
  `idback` varchar(250) DEFAULT '' COMMENT '身份证背面照',
  `idperson` varchar(250) DEFAULT '' COMMENT '手持身份照',
  `images` text COMMENT '基本照片',
  `video` varchar(250) DEFAULT '' COMMENT '基本视频',
  `video_cover` varchar(250) DEFAULT '' COMMENT '基本视频封面',
  `recharge` float DEFAULT '0' COMMENT '充值总额',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否假删除：1,是0否',
  `device` varchar(50) NOT NULL DEFAULT 'app' COMMENT '注册设备',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `login_time` datetime DEFAULT NULL COMMENT '上次登陆时间',
  `login_coord_lng` float(10,7) unsigned DEFAULT '0.0000000' COMMENT '上次登录坐标',
  `login_coord_lat` float(10,7) unsigned DEFAULT '0.0000000' COMMENT '上次登录坐标',
  `guid` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一码（用于扫码登录）',
  `imtoken` varchar(150) DEFAULT '' COMMENT '云信token',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

-- 正在导出表  meiyue.lm_user 的数据：~8 rows (大约)
DELETE FROM `lm_user`;
/*!40000 ALTER TABLE `lm_user` DISABLE KEYS */;
INSERT INTO `lm_user` (`id`, `phone`, `pwd`, `user_token`, `union_id`, `wx_openid`, `app_wx_openid`, `nick`, `truename`, `profession`, `email`, `gender`, `birthday`, `zodiac`, `weight`, `height`, `bwh`, `cup`, `hometown`, `city`, `avatar`, `state`, `career`, `place`, `food`, `music`, `movie`, `sport`, `sign`, `wxid`, `money`, `status`, `enabled`, `idpath`, `idfront`, `idback`, `idperson`, `images`, `video`, `video_cover`, `recharge`, `is_del`, `device`, `create_time`, `update_time`, `login_time`, `login_coord_lng`, `login_coord_lat`, `guid`, `imtoken`) VALUES
	(0, '00000000000', '$2y$10$ZRSq.gc.vOqmJzwRFnrFFux9rmpBqQCHIzXq4RkDenQxetMNrOlNe', '1a2b463ab900fa81277a', '', '', '', '美约平台', '美约', 'CEO', '', 1, '1991-01-24', 4, 42, 127, '89/72/30', 'C', '九江', '深圳', '/upload/user/avatar/owHf-fxmpnqm3336966.jpg', 1, '2015年香港小姐亚军', '', '辣条', '', '', '跳皮筋', '', '', 0, 3, 0, '', '', '', '', NULL, '/upload/user/video/2016-11-24/5836a19579940.mp4', '/upload/user/video/2016-11-24/5836a1957ed2c.png', 0, 0, 'app', '2016-11-08 09:57:19', '2016-11-24 16:15:17', '2016-11-11 15:12:58', 0.0000000, 0.0000000, '', ''),
	(3, '18316629979', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d031', '', '', '', '薇薇', '曹蒹葭', '模特', '', 2, '1995-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/139-1503131F955.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 1440, 3, 1, '', '', '', '', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}', '/upload/user/video/2016-11-17/582d1dd5d8558.mp4', '/upload/user/video/2016-11-17/582d1dd5da896.png', 0, 0, 'weixin', '2016-10-31 14:44:51', '2016-11-29 11:40:33', '2016-11-17 11:49:10', 114.0440445, 22.6315136, '', 'd883845a006ab198c1485867c6296021'),
	(4, '18681540783', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d032', '', '', '', 'welber', '曹小萌', '模特', '', 2, '1996-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/c7eafcd1e0650af.jpeg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 900, 3, 1, '', '', '', '', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-24/583652bb6066e.png";i:1;s:48:"/upload/user/images/2016-11-24/583652bb60f38.png";i:2;s:48:"/upload/user/images/2016-11-24/583652bb616a6.png";i:3;s:48:"/upload/user/images/2016-11-24/583652bb65b11.png";i:4;s:48:"/upload/user/images/2016-11-24/583652bb66286.png";i:5;s:48:"/upload/user/images/2016-11-24/583652bb66911.png";i:6;s:48:"/upload/user/images/2016-11-24/583652bb66f28.png";i:7;s:48:"/upload/user/images/2016-11-24/583652bb67632.png";i:8;s:48:"/upload/user/images/2016-11-24/583652bb67c62.png";}', '', '', 0, 0, 'weixin', '2016-10-31 14:44:51', '2016-12-02 14:41:06', '2016-12-02 14:41:06', 114.0437775, 22.6463375, '', '17103c24431a5451adaac0e25ffe9b3f'),
	(5, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d033', '', '', '', '薇小2', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1_b9dfb4fc8fe6e3f17ad199269eb21c4d_510.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 0, 'weixin', '2016-10-31 14:44:51', '2016-11-22 14:26:56', '2016-11-22 14:26:56', 114.0440445, 22.2445583, '', ''),
	(17, '18681541783', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '1a2b463ab900fa81277a', '', '', '', '王姑娘', '王语嫣', '平面模特', '', 2, '1991-01-24', 4, 42, 127, '89/72/30', 'C', '九江', '深圳', '/upload/user/avatar/2016-11-08/58213277e2421.jpg', 1, '2015年香港小姐亚军', '', '辣条', '', '', '跳皮筋', '', '', 0, 3, 1, '', '', '', '', '', '', '', 0, 0, 'app', '2016-11-08 09:57:19', '2016-11-15 09:36:15', '2016-11-15 09:36:15', 0.0000000, 0.0000000, '', ''),
	(45, '18316629933', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d039', '', '', '', '薇小萌', '曹蒹葭', '模特', '', 2, '1995-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/139-1503131F955.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}', '/upload/user/video/2016-11-17/582d1dd5d8558.mp4', '/upload/user/video/2016-11-17/582d1dd5da896.png', 0, 0, 'weixin', '2016-10-31 14:44:51', '2016-11-17 15:57:28', '2016-11-17 15:57:28', 114.0440445, 22.6315136, '', ''),
	(46, '18316629974', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d034', '', '', '', '王思聪', '曹蒹葭', '模特', '', 1, '1995-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/2016-12-02/5840e573b9bc0.png', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 96249, 3, 1, '', '', '', '', 'a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}', '/upload/user/video/2016-11-17/582d1dd5d8558.mp4', '/upload/user/video/2016-11-17/582d1dd5da896.png', 0, 0, 'weixin', '2016-10-31 14:44:51', '2016-12-02 19:59:55', '2016-12-02 19:59:55', 114.0437698, 22.6495991, '', 'e332ee4d410fa8f76a9747a7bb13442e'),
	(48, '18316629973', '$2y$10$S8LCbOXJohhSFmYr6knZguwFeLQleF2hlWWP5jbRDJO73fHIts7HG', '126e6fd158e7ca5d82c2', '', '', '', '曹', '曹蒹葭', '模特', '', 2, '1991-01-24', 11, 48, 127, '88/88/88', 'F', '江西', '深圳', '/upload/user/avatar/2016-12-02/58416624e32f0.png', 1, '', '', '面', '', '', '打球', '', '', 0, 0, 1, '', '', '', '', NULL, '', '', 0, 0, 'app', '2016-12-02 20:16:01', '2016-12-02 20:20:58', NULL, 0.0000000, 0.0000000, '', '');
/*!40000 ALTER TABLE `lm_user` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_fans 结构
DROP TABLE IF EXISTS `lm_user_fans`;
CREATE TABLE IF NOT EXISTS `lm_user_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '关注者',
  `following_id` int(11) NOT NULL COMMENT '被关注者',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1,单向关注2互为关注',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='用户关系表 女对男的喜欢 男对女的关注';

-- 正在导出表  meiyue.lm_user_fans 的数据：~15 rows (大约)
DELETE FROM `lm_user_fans`;
/*!40000 ALTER TABLE `lm_user_fans` DISABLE KEYS */;
INSERT INTO `lm_user_fans` (`id`, `user_id`, `following_id`, `type`, `create_time`, `update_time`) VALUES
	(3, 18, 4, 1, '2016-11-08 15:11:05', '2016-11-08 15:11:05'),
	(11, 18, 11, 1, '2016-11-08 18:36:24', '2016-11-08 18:36:24'),
	(12, 18, 15, 1, '2016-11-08 18:36:30', '2016-11-08 18:36:30'),
	(13, 18, 9, 1, '2016-11-08 18:36:35', '2016-11-08 18:36:35'),
	(14, 18, 14, 1, '2016-11-08 18:36:41', '2016-11-08 18:36:41'),
	(15, 18, 17, 1, '2016-11-08 18:37:00', '2016-11-08 18:37:00'),
	(16, 45, 48, 1, '2016-11-17 20:39:16', '2016-11-17 20:39:16'),
	(17, 45, 50, 1, '2016-11-17 20:39:58', '2016-11-17 20:39:58'),
	(19, 46, 4, 2, '2016-11-21 14:32:51', '2016-11-23 17:40:11'),
	(20, 5, 46, 1, '2016-11-22 10:35:19', '2016-11-22 10:35:19'),
	(22, 5, 47, 1, '2016-11-22 10:42:36', '2016-11-22 10:42:36'),
	(24, 5, 48, 1, '2016-11-22 10:43:49', '2016-11-22 10:43:49'),
	(25, 4, 46, 2, '2016-11-23 17:40:11', '2016-11-23 17:40:11'),
	(26, 4, 48, 1, '2016-11-23 17:40:18', '2016-11-23 17:40:18'),
	(29, 3, 46, 1, '2016-11-25 15:17:40', '2016-11-25 15:17:40');
/*!40000 ALTER TABLE `lm_user_fans` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_package 结构
DROP TABLE IF EXISTS `lm_user_package`;
CREATE TABLE IF NOT EXISTS `lm_user_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0' COMMENT '套餐名称',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `package_id` int(11) NOT NULL DEFAULT '0' COMMENT '套餐id',
  `chat_num` int(11) NOT NULL DEFAULT '0' COMMENT '美女聊天名额',
  `rest_chat` int(11) NOT NULL DEFAULT '0' COMMENT '剩余聊天名额',
  `browse_num` int(11) NOT NULL DEFAULT '0' COMMENT '查看动态名额',
  `rest_browse` int(11) NOT NULL DEFAULT '0' COMMENT '剩余查看动态名额',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '套餐类型：1#vip套餐 2#充值套餐 3#其他套餐',
  `cost` double NOT NULL DEFAULT '0' COMMENT '购买价格',
  `vir_money` double NOT NULL DEFAULT '0' COMMENT '美币面额',
  `deathline` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '失效时间',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '购买时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户-套餐购买记录表';

-- 正在导出表  meiyue.lm_user_package 的数据：~0 rows (大约)
DELETE FROM `lm_user_package`;
/*!40000 ALTER TABLE `lm_user_package` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_user_package` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_profile 结构
DROP TABLE IF EXISTS `lm_user_profile`;
CREATE TABLE IF NOT EXISTS `lm_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `front` varchar(250) DEFAULT '' COMMENT '正面照',
  `back` varchar(250) DEFAULT '' COMMENT '背面照',
  `person` varchar(250) DEFAULT '' COMMENT '手持照',
  `images` text COMMENT '基本照片',
  `video` varchar(250) DEFAULT '' COMMENT '基本视频',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息副表';

-- 正在导出表  meiyue.lm_user_profile 的数据：~1 rows (大约)
DELETE FROM `lm_user_profile`;
/*!40000 ALTER TABLE `lm_user_profile` DISABLE KEYS */;
INSERT INTO `lm_user_profile` (`id`, `user_id`, `front`, `back`, `person`, `images`, `video`, `create_time`) VALUES
	(1, 3, '/upload/user/idcard/2016-10-31/581712554673c.jpg', '/upload/user/idcard/2016-10-31/5817125547d32.jpeg', '/upload/user/idcard/2016-10-31/581712554855f.jpeg', NULL, '', '2016-10-31 17:43:49');
/*!40000 ALTER TABLE `lm_user_profile` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_skill 结构
DROP TABLE IF EXISTS `lm_user_skill`;
CREATE TABLE IF NOT EXISTS `lm_user_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `skill_id` int(11) NOT NULL COMMENT '对应管理员录入的名称',
  `cost_id` int(11) NOT NULL COMMENT '对应管理员录入的费用',
  `description` varchar(200) NOT NULL COMMENT '约会说明',
  `is_used` tinyint(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
  `is_checked` tinyint(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户技能表';

-- 正在导出表  meiyue.lm_user_skill 的数据：~9 rows (大约)
DELETE FROM `lm_user_skill`;
/*!40000 ALTER TABLE `lm_user_skill` DISABLE KEYS */;
INSERT INTO `lm_user_skill` (`id`, `user_id`, `skill_id`, `cost_id`, `description`, `is_used`, `is_checked`) VALUES
	(1, 3, 5, 1, '', 1, 1),
	(2, 3, 6, 7, '', 1, 1),
	(3, 3, 7, 7, '', 1, 1),
	(4, 3, 8, 7, '', 1, 1),
	(5, 4, 8, 7, '跳刀躲梅肯,塔下意识粉,买鸡包眼包吃树送TP,辅助保你爽歪歪', 1, 1),
	(6, 5, 7, 7, '', 1, 1),
	(7, 6, 6, 7, '', 1, 1),
	(8, 7, 5, 1, '', 1, 1),
	(9, 4, 7, 1, '一杆进洞绝不含糊', 1, 1);
/*!40000 ALTER TABLE `lm_user_skill` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_skill_tag 结构
DROP TABLE IF EXISTS `lm_user_skill_tag`;
CREATE TABLE IF NOT EXISTS `lm_user_skill_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_skill_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户技能-标签中间表';

-- 正在导出表  meiyue.lm_user_skill_tag 的数据：~6 rows (大约)
DELETE FROM `lm_user_skill_tag`;
/*!40000 ALTER TABLE `lm_user_skill_tag` DISABLE KEYS */;
INSERT INTO `lm_user_skill_tag` (`id`, `user_skill_id`, `tag_id`) VALUES
	(1, 5, 3),
	(2, 5, 5),
	(3, 5, 7),
	(4, 9, 6),
	(5, 9, 7),
	(6, 9, 16);
/*!40000 ALTER TABLE `lm_user_skill_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_tag 结构
DROP TABLE IF EXISTS `lm_user_tag`;
CREATE TABLE IF NOT EXISTS `lm_user_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_tag_id` (`user_id`,`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户个人标签';

-- 正在导出表  meiyue.lm_user_tag 的数据：~4 rows (大约)
DELETE FROM `lm_user_tag`;
/*!40000 ALTER TABLE `lm_user_tag` DISABLE KEYS */;
INSERT INTO `lm_user_tag` (`id`, `user_id`, `tag_id`) VALUES
	(1, 17, 5),
	(3, 17, 6),
	(2, 17, 19),
	(4, 48, 5);
/*!40000 ALTER TABLE `lm_user_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_withdraw 结构
DROP TABLE IF EXISTS `lm_withdraw`;
CREATE TABLE IF NOT EXISTS `lm_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '对象id',
  `admin_id` int(11) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0' COMMENT '提现金额',
  `cardno` varchar(50) NOT NULL COMMENT '银行卡号',
  `bank` varchar(50) NOT NULL COMMENT '银行',
  `truename` varchar(50) NOT NULL COMMENT '持卡人姓名',
  `fee` float NOT NULL DEFAULT '0' COMMENT '手续费',
  `remark` varchar(200) NOT NULL DEFAULT '0' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态,0未审核，1审核通过',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='提现表';

-- 正在导出表  meiyue.lm_withdraw 的数据：~0 rows (大约)
DELETE FROM `lm_withdraw`;
/*!40000 ALTER TABLE `lm_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_withdraw` ENABLE KEYS */;

-- 导出  表 meiyue.lm_yuepai 结构
DROP TABLE IF EXISTS `lm_yuepai`;
CREATE TABLE IF NOT EXISTS `lm_yuepai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `act_time` datetime NOT NULL COMMENT '约拍时间',
  `rest_num` smallint(6) NOT NULL COMMENT '剩余名额',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态：1#正常 2#下架',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员添加的约拍表';

-- 正在导出表  meiyue.lm_yuepai 的数据：~0 rows (大约)
DELETE FROM `lm_yuepai`;
/*!40000 ALTER TABLE `lm_yuepai` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_yuepai` ENABLE KEYS */;

-- 导出  表 meiyue.lm_yuepai_user 结构
DROP TABLE IF EXISTS `lm_yuepai_user`;
CREATE TABLE IF NOT EXISTS `lm_yuepai_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yuepai_id` int(11) NOT NULL COMMENT '约拍id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `name` varchar(50) NOT NULL COMMENT '姓名',
  `phone` varchar(50) NOT NULL COMMENT '手机号',
  `area` varchar(50) NOT NULL COMMENT '所在地区',
  `checked` tinyint(4) NOT NULL COMMENT '审核状态：1#审核通过 2#未审核 3#审核不通过',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约拍申请表';

-- 正在导出表  meiyue.lm_yuepai_user 的数据：~0 rows (大约)
DELETE FROM `lm_yuepai_user`;
/*!40000 ALTER TABLE `lm_yuepai_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_yuepai_user` ENABLE KEYS */;

-- 导出  表 meiyue.phinxlog 结构
DROP TABLE IF EXISTS `phinxlog`;
CREATE TABLE IF NOT EXISTS `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.phinxlog 的数据：~0 rows (大约)
DELETE FROM `phinxlog`;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;

-- 导出  表 meiyue.sessions 结构
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` char(40) NOT NULL,
  `data` text,
  `expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.sessions 的数据：~17 rows (大约)
DELETE FROM `sessions`;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`id`, `data`, `expires`) VALUES
	('0gl5sdtaf48ac9ot6138nak560', 'Config|a:1:{s:4:"time";i:1480663363;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 11:57:18.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 11:57:18.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.043731699999995043981471098959445953369140625;s:15:"login_coord_lat";d:22.64882469999999869969542487524449825286865234375;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480749763),
	('1ju7ikl74kmms0hps6jds09i35', 'Config|a:1:{s:4:"time";i:1480669541;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0438156000000020640072762034833431243896484375;s:15:"login_coord_lat";d:22.646329900000001345006239716894924640655517578125;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480755941),
	('21ldtr0pbgkmu782mk2u8jc7r6', 'Config|a:1:{s:4:"time";i:1480668049;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 16:40:12.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 16:40:12.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0437926999999973531885189004242420196533203125;s:15:"login_coord_lat";d:22.646343200000000450700099463574588298797607421875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480754449),
	('3hf1rluoa2s50p940071oavbv3', 'Config|a:1:{s:4:"time";i:1480679997;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.04376980000000685322447679936885833740234375;s:15:"login_coord_lat";d:22.649599099999999651799953426234424114227294921875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480766397),
	('9aofpmuhbqqjfke23uncj07mg7', 'Config|a:1:{s:4:"time";i:1480661419;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 14:43:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 14:43:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.043731699999995043981471098959445953369140625;s:15:"login_coord_lat";d:22.649223299999999170495357248000800609588623046875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480747819),
	('9g8j2hj1bubte345sh83oo6eq2', 'Config|a:1:{s:4:"time";i:1480669540;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0438156000000020640072762034833431243896484375;s:15:"login_coord_lat";d:22.646329900000001345006239716894924640655517578125;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480755940),
	('a7al4ukdm2e4u9grc30deosv01', 'Config|a:1:{s:4:"time";i:1480679996;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.04376980000000685322447679936885833740234375;s:15:"login_coord_lat";d:22.649599099999999651799953426234424114227294921875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480766396),
	('bnvasdpq7uv9nq440h1pmqfse0', 'Config|a:1:{s:4:"time";i:1480669541;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0438156000000020640072762034833431243896484375;s:15:"login_coord_lat";d:22.646329900000001345006239716894924640655517578125;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480755941),
	('c2trnj40hg88eb9ra21q1534o7', 'Config|a:1:{s:4:"time";i:1480666516;}Flash|a:1:{s:3:"acl";a:1:{i:0;a:4:{s:7:"message";s:16:"请重新登录!";s:3:"key";s:3:"acl";s:7:"element";s:11:"Flash/error";s:6:"params";a:0:{}}}}User|a:1:{s:5:"admin";O:26:"Wpadmin\\Model\\Entity\\Admin":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:8:"password";}s:14:"\0*\0_properties";a:8:{s:2:"id";i:1;s:8:"username";s:5:"admin";s:7:"enabled";b:1;s:5:"ctime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-17 10:17:52.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:5:"utime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-01 17:10:49.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";s:19:"2016-12-01 17:10:49";s:8:"login_ip";s:9:"127.0.0.1";s:1:"g";a:1:{i:0;O:26:"Wpadmin\\Model\\Entity\\Group":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:14:"\0*\0_properties";a:7:{s:2:"id";i:1;s:4:"name";s:15:"超级管理员";s:6:"remark";s:12:"无限权限";s:5:"ctime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-18 14:25:32.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:5:"utime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-18 14:25:32.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:9:"_joinData";O:15:"Cake\\ORM\\Entity":11:{s:14:"\0*\0_properties";a:3:{s:2:"id";i:1;s:8:"admin_id";i:1;s:8:"group_id";i:1;}s:12:"\0*\0_original";a:0:{}s:10:"\0*\0_hidden";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:14:"\0*\0_accessible";a:1:{s:1:"*";b:1;}s:17:"\0*\0_registryAlias";s:12:"LmAdminGroup";}s:4:"menu";a:0:{}}s:12:"\0*\0_original";a:0:{}s:10:"\0*\0_hidden";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:9:"Wpadmin.g";}}}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:13:"Wpadmin.Admin";}}', 1480752916),
	('eln33qpc6d4o1sdropr37achn0', 'Config|a:1:{s:4:"time";i:1480682534;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 12:05:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 12:05:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.043731699999995043981471098959445953369140625;s:15:"login_coord_lat";d:22.64882469999999869969542487524449825286865234375;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480768934),
	('fvlpjm6gdt5ebh987cvc37d8j5', 'Config|a:1:{s:4:"time";i:1480678169;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 18:13:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 18:13:47.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0439453000000042948158807121217250823974609375;s:15:"login_coord_lat";d:22.646278399999999919600668363273143768310546875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480764569),
	('grnric5hfovr92tbqtevnb1u06', 'Config|a:1:{s:4:"time";i:1480679969;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:28.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:28.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.04376980000000685322447679936885833740234375;s:15:"login_coord_lat";d:22.649599099999999651799953426234424114227294921875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480766369),
	('lop4402hqotko2hgagclv4lsp6', 'Config|a:1:{s:4:"time";i:1480669541;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 17:05:39.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.0438156000000020640072762034833431243896484375;s:15:"login_coord_lat";d:22.646329900000001345006239716894924640655517578125;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480755941),
	('o6ui9ciab8lpshvmocglo9uqo4', 'Config|a:1:{s:4:"time";i:1480673676;}Flash|a:1:{s:3:"acl";a:1:{i:0;a:4:{s:7:"message";s:16:"请重新登录!";s:3:"key";s:3:"acl";s:7:"element";s:11:"Flash/error";s:6:"params";a:0:{}}}}User|a:1:{s:5:"admin";O:26:"Wpadmin\\Model\\Entity\\Admin":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:8:"password";}s:14:"\0*\0_properties";a:8:{s:2:"id";i:1;s:8:"username";s:5:"admin";s:7:"enabled";b:1;s:5:"ctime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-17 10:17:52.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:5:"utime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 18:14:34.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";s:19:"2016-12-02 18:14:34";s:8:"login_ip";s:9:"127.0.0.1";s:1:"g";a:1:{i:0;O:26:"Wpadmin\\Model\\Entity\\Group":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:14:"\0*\0_properties";a:7:{s:2:"id";i:1;s:4:"name";s:15:"超级管理员";s:6:"remark";s:12:"无限权限";s:5:"ctime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-18 14:25:32.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:5:"utime";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-18 14:25:32.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:9:"_joinData";O:15:"Cake\\ORM\\Entity":11:{s:14:"\0*\0_properties";a:3:{s:2:"id";i:1;s:8:"admin_id";i:1;s:8:"group_id";i:1;}s:12:"\0*\0_original";a:0:{}s:10:"\0*\0_hidden";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:14:"\0*\0_accessible";a:1:{s:1:"*";b:1;}s:17:"\0*\0_registryAlias";s:12:"LmAdminGroup";}s:4:"menu";a:0:{}}s:12:"\0*\0_original";a:0:{}s:10:"\0*\0_hidden";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:9:"Wpadmin.g";}}}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:13:"Wpadmin.Admin";}}', 1480760077),
	('qttaf3v8vn5cn9iknplt0h9aa0', 'Config|a:1:{s:4:"time";i:1480681333;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:9:{s:5:"phone";s:11:"18316629973";s:5:"vcode";s:4:"2926";s:3:"pwd";s:60:"$2y$10$S8LCbOXJohhSFmYr6knZguwFeLQleF2hlWWP5jbRDJO73fHIts7HG";s:6:"gender";i:2;s:7:"enabled";b:1;s:10:"user_token";s:32:"126e6fd158e7ca5d82c2402a2326f585";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 20:16:01.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 20:16:01.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:2:"id";i:48;}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}Login|a:1:{s:11:"login_token";s:32:"126e6fd158e7ca5d82c2402a2326f585";}', 1480767733),
	('rb390m3u1etgfmf4f3amd91b01', 'Config|a:1:{s:4:"time";i:1480679996;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.04376980000000685322447679936885833740234375;s:15:"login_coord_lat";d:22.649599099999999651799953426234424114227294921875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480766396),
	('vkl73nuj9673g63igssgqrdn80', 'Config|a:1:{s:4:"time";i:1480679997;}User|a:1:{s:6:"mobile";O:21:"App\\Model\\Entity\\User":11:{s:14:"\0*\0_accessible";a:2:{s:1:"*";b:1;s:2:"id";b:0;}s:10:"\0*\0_hidden";a:1:{i:0;s:3:"pwd";}s:14:"\0*\0_properties";a:50:{s:2:"id";i:46;s:5:"phone";s:11:"18316629973";s:3:"pwd";s:60:"$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi";s:10:"user_token";s:20:"04d6ad7bbeca1fe8d034";s:8:"union_id";s:0:"";s:9:"wx_openid";s:0:"";s:13:"app_wx_openid";s:0:"";s:4:"nick";s:9:"王思聪";s:8:"truename";s:9:"曹蒹葭";s:10:"profession";s:6:"模特";s:5:"email";s:0:"";s:6:"gender";i:1;s:8:"birthday";O:14:"Cake\\I18n\\Date":3:{s:4:"date";s:26:"1995-09-24 00:00:00.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}s:6:"zodiac";i:3;s:6:"weight";i:72;s:6:"height";i:127;s:3:"bwh";s:8:"88/88/88";s:3:"cup";s:1:"C";s:8:"hometown";s:6:"江西";s:4:"city";s:6:"深圳";s:6:"avatar";s:48:"/upload/user/avatar/2016-12-02/5840e573b9bc0.png";s:5:"state";i:1;s:6:"career";s:22:"2016深圳小姐冠军";s:5:"place";s:6:"酒吧";s:4:"food";s:6:"牛排";s:5:"music";s:15:"《滑板鞋》";s:5:"movie";s:19:"《7月与安生》";s:5:"sport";s:9:"跳皮筋";s:4:"sign";s:51:"宁愿在宝马里哭，也不要在自行车上笑";s:4:"wxid";s:5:"12315";s:5:"money";d:96249;s:6:"status";i:3;s:7:"enabled";b:1;s:6:"idpath";s:0:"";s:7:"idfront";s:0:"";s:6:"idback";s:0:"";s:8:"idperson";s:0:"";s:6:"images";s:546:"a:9:{i:0;s:48:"/upload/user/images/2016-11-17/582d12a3b21b3.png";i:1;s:48:"/upload/user/images/2016-11-17/582d12a3b2a90.png";i:2;s:48:"/upload/user/images/2016-11-17/582d12a3b3243.png";i:3;s:48:"/upload/user/images/2016-11-17/582d12a3b39de.png";i:4;s:48:"/upload/user/images/2016-11-17/582d12a3b7747.png";i:5;s:48:"/upload/user/images/2016-11-17/582d12a3b7ea8.png";i:6;s:48:"/upload/user/images/2016-11-17/582d12a3b85ed.png";i:7;s:48:"/upload/user/images/2016-11-17/582d12a3b8def.png";i:8;s:48:"/upload/user/images/2016-11-17/582d12a3b96aa.png";}";s:5:"video";s:47:"/upload/user/video/2016-11-17/582d1dd5d8558.mp4";s:11:"video_cover";s:47:"/upload/user/video/2016-11-17/582d1dd5da896.png";s:8:"recharge";d:0;s:6:"is_del";b:0;s:6:"device";s:6:"weixin";s:11:"create_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-10-31 14:44:51.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:11:"update_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:10:"login_time";O:14:"Cake\\I18n\\Time":3:{s:4:"date";s:26:"2016-12-02 19:59:55.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Asia/Shanghai";}s:15:"login_coord_lng";d:114.04376980000000685322447679936885833740234375;s:15:"login_coord_lat";d:22.649599099999999651799953426234424114227294921875;s:4:"guid";s:0:"";s:7:"imtoken";s:32:"e332ee4d410fa8f76a9747a7bb13442e";}s:12:"\0*\0_original";a:0:{}s:11:"\0*\0_virtual";a:0:{}s:13:"\0*\0_className";N;s:9:"\0*\0_dirty";a:0:{}s:7:"\0*\0_new";b:0;s:10:"\0*\0_errors";a:0:{}s:11:"\0*\0_invalid";a:0:{}s:17:"\0*\0_registryAlias";s:4:"User";}}', 1480766397);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

-- 导出  表 meiyue.wpadmin_phinxlog 结构
DROP TABLE IF EXISTS `wpadmin_phinxlog`;
CREATE TABLE IF NOT EXISTS `wpadmin_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.wpadmin_phinxlog 的数据：~3 rows (大约)
DELETE FROM `wpadmin_phinxlog`;
/*!40000 ALTER TABLE `wpadmin_phinxlog` DISABLE KEYS */;
INSERT INTO `wpadmin_phinxlog` (`version`, `migration_name`, `start_time`, `end_time`) VALUES
	(20160321153421, 'Inital', '2016-10-17 09:24:51', '2016-10-17 09:24:52'),
	(20161017092321, 'Initial', '2016-10-17 09:23:22', '2016-10-17 09:23:22'),
	(20161017100910, 'Initial', '2016-10-17 10:09:10', '2016-10-17 10:09:10');
/*!40000 ALTER TABLE `wpadmin_phinxlog` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
