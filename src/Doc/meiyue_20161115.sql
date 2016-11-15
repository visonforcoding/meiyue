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

-- 导出  函数 meiyue.getDistance 结构
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='后台操作日志表';

-- 正在导出表  meiyue.lm_actionlog 的数据：~17 rows (大约)
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
	(22, 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-09 10:49:32');
/*!40000 ALTER TABLE `lm_actionlog` ENABLE KEYS */;

-- 导出  表 meiyue.lm_admin 结构
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

-- 正在导出表  meiyue.lm_admin 的数据：~0 rows (大约)
DELETE FROM `lm_admin`;
/*!40000 ALTER TABLE `lm_admin` DISABLE KEYS */;
INSERT INTO `lm_admin` (`id`, `username`, `password`, `enabled`, `ctime`, `utime`, `login_time`, `login_ip`) VALUES
	(1, 'admin', '$2y$10$FO3TYb8S3BygWrtep7DsY.f7qcWcSe95yC50FH5uEa8FIHmv0ViVG', 1, '2016-10-17 10:17:52', '2016-11-09 10:49:32', '2016-11-09 10:49:32', '127.0.0.1');
/*!40000 ALTER TABLE `lm_admin` ENABLE KEYS */;

-- 导出  表 meiyue.lm_admin_group 结构
CREATE TABLE IF NOT EXISTS `lm_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员',
  `group_id` int(11) NOT NULL COMMENT '所属组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_id` (`admin_id`,`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员群组';

-- 正在导出表  meiyue.lm_admin_group 的数据：~0 rows (大约)
DELETE FROM `lm_admin_group`;
/*!40000 ALTER TABLE `lm_admin_group` DISABLE KEYS */;
INSERT INTO `lm_admin_group` (`id`, `admin_id`, `group_id`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `lm_admin_group` ENABLE KEYS */;

-- 导出  表 meiyue.lm_cost 结构
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
CREATE TABLE IF NOT EXISTS `lm_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) DEFAULT '0' COMMENT '对应管理员录入的技能列表',
  `title` varchar(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
  `start_time` datetime NOT NULL COMMENT '约会开始时间',
  `site` varchar(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
  `end_time` datetime NOT NULL COMMENT '约会结束时间',
  `price` double NOT NULL DEFAULT '0' COMMENT '约会价格',
  `desc` varchar(255) DEFAULT '0' COMMENT '约会说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会表（美女发布的约会）';

-- 正在导出表  meiyue.lm_date 的数据：~0 rows (大约)
DELETE FROM `lm_date`;
/*!40000 ALTER TABLE `lm_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_date` ENABLE KEYS */;

-- 导出  表 meiyue.lm_dateorder 结构
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
  `create_time` datetime NOT NULL COMMENT '生成时间',
  `update_time` datetime NOT NULL COMMENT '订单更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='约单表';

-- 正在导出表  meiyue.lm_dateorder 的数据：~1 rows (大约)
DELETE FROM `lm_dateorder`;
/*!40000 ALTER TABLE `lm_dateorder` DISABLE KEYS */;
INSERT INTO `lm_dateorder` (`id`, `consumer_id`, `consumer`, `dater_id`, `dater_name`, `date_id`, `user_skill_id`, `status`, `operate_status`, `site`, `site_lat`, `site_lng`, `price`, `amount`, `is_complain`, `pre_pay`, `pre_precent`, `start_time`, `end_time`, `date_time`, `create_time`, `update_time`) VALUES
	(2, 18, '王思聪', 4, '曹小萌', 0, 5, 0, 0, '罗拉小厨(锦绣江南店)', 22.645, 114.034, 600, 1800, 0, 360, 0.2, '2016-11-12 01:00:00', '2016-11-12 04:00:00', 3, '2016-11-11 17:57:54', '2016-11-11 17:57:54');
/*!40000 ALTER TABLE `lm_dateorder` ENABLE KEYS */;

-- 导出  表 meiyue.lm_date_tag 结构
CREATE TABLE IF NOT EXISTS `lm_date_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应约会id',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会-标签中间表';

-- 正在导出表  meiyue.lm_date_tag 的数据：~0 rows (大约)
DELETE FROM `lm_date_tag`;
/*!40000 ALTER TABLE `lm_date_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_date_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_flow 结构
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
  `paytype` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付方式',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '交易状态',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='用户资金流水';

-- 正在导出表  meiyue.lm_flow 的数据：~0 rows (大约)
DELETE FROM `lm_flow`;
/*!40000 ALTER TABLE `lm_flow` DISABLE KEYS */;
INSERT INTO `lm_flow` (`id`, `user_id`, `buyer_id`, `relate_id`, `type`, `type_msg`, `income`, `amount`, `price`, `pre_amount`, `after_amount`, `paytype`, `status`, `remark`, `create_time`, `update_time`) VALUES
	(47, 0, 18, 2, 1, '约技能支出', 2, 360.00, 360.00, 999999.00, 999639.00, 1, 0, '约技能支出', '2016-11-11 17:57:54', '2016-11-11 17:57:54');
/*!40000 ALTER TABLE `lm_flow` ENABLE KEYS */;

-- 导出  表 meiyue.lm_group 结构
CREATE TABLE IF NOT EXISTS `lm_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '群组名称',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `utime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员群组';

-- 正在导出表  meiyue.lm_group 的数据：~0 rows (大约)
DELETE FROM `lm_group`;
/*!40000 ALTER TABLE `lm_group` DISABLE KEYS */;
INSERT INTO `lm_group` (`id`, `name`, `remark`, `ctime`, `utime`) VALUES
	(1, '超级管理员', '无限权限', '2016-10-18 14:25:32', '2016-10-18 14:25:32');
/*!40000 ALTER TABLE `lm_group` ENABLE KEYS */;

-- 导出  表 meiyue.lm_group_menu 结构
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

-- 导出  表 meiyue.lm_menu 结构
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.lm_menu 的数据：~5 rows (大约)
DELETE FROM `lm_menu`;
/*!40000 ALTER TABLE `lm_menu` DISABLE KEYS */;
INSERT INTO `lm_menu` (`id`, `name`, `node`, `pid`, `class`, `rank`, `is_menu`, `status`, `remark`) VALUES
	(1, '系统设置', '', 0, 'icon-cogs', NULL, 1, 1, ''),
	(2, '菜单管理', '/menu/index', 1, 'icon-list', NULL, 1, 1, ''),
	(3, 'user管理', '/user/index', 1, 'icon-user', NULL, 1, 1, ''),
	(4, '管理员管理', '/admin/index', 1, 'icon-android', NULL, 1, 1, ''),
	(5, '群组管理', '/group/index', 1, 'icon-group', NULL, 1, 1, ''),
	(6, '操作日志管理', '/actionlog/index', 1, 'icon-keyboard', NULL, 1, 1, '');
/*!40000 ALTER TABLE `lm_menu` ENABLE KEYS */;

-- 导出  表 meiyue.lm_skill 结构
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
CREATE TABLE IF NOT EXISTS `lm_smsmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(50) NOT NULL DEFAULT '0' COMMENT '手机号',
  `code` varchar(50) DEFAULT NULL COMMENT '验证码',
  `content` varchar(250) DEFAULT NULL COMMENT '内容',
  `expire_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='短信记录';

-- 正在导出表  meiyue.lm_smsmsg 的数据：~15 rows (大约)
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
	(20, '18316629973', '4527', '您的动态验证码为4527,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1478570445, '2016-11-08 09:50:45');
/*!40000 ALTER TABLE `lm_smsmsg` ENABLE KEYS */;

-- 导出  表 meiyue.lm_tag 结构
CREATE TABLE IF NOT EXISTS `lm_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='标签表';

-- 正在导出表  meiyue.lm_tag 的数据：~34 rows (大约)
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

-- 导出  表 meiyue.lm_user 结构
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
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态1待审核2审核不通过3审核通过',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账号状态 ：1.可用0禁用(控制登录)',
  `idpath` varchar(250) DEFAULT '' COMMENT '身份证路径',
  `idfront` varchar(250) DEFAULT '' COMMENT '身份证正面照',
  `idback` varchar(250) DEFAULT '' COMMENT '身份证背面照',
  `idperson` varchar(250) DEFAULT '' COMMENT '手持身份照',
  `images` text COMMENT '基本照片',
  `video` varchar(250) DEFAULT '' COMMENT '基本视频',
  `video_cover` varchar(250) DEFAULT '' COMMENT '基本视频封面',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否假删除：1,是0否',
  `device` varchar(50) NOT NULL DEFAULT 'app' COMMENT '注册设备',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `login_time` datetime DEFAULT NULL COMMENT '上次登陆时间',
  `login_coord_lng` float(10,7) unsigned DEFAULT '0.0000000' COMMENT '上次登录坐标',
  `login_coord_lat` float(10,7) unsigned DEFAULT '0.0000000' COMMENT '上次登录坐标',
  `guid` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一码（用于扫码登录）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

-- 正在导出表  meiyue.lm_user 的数据：~16 rows (大约)
DELETE FROM `lm_user`;
/*!40000 ALTER TABLE `lm_user` DISABLE KEYS */;
INSERT INTO `lm_user` (`id`, `phone`, `pwd`, `user_token`, `union_id`, `wx_openid`, `app_wx_openid`, `nick`, `truename`, `profession`, `email`, `gender`, `birthday`, `zodiac`, `weight`, `height`, `bwh`, `cup`, `hometown`, `city`, `avatar`, `state`, `career`, `place`, `food`, `music`, `movie`, `sport`, `sign`, `wxid`, `money`, `status`, `enabled`, `idpath`, `idfront`, `idback`, `idperson`, `images`, `video`, `video_cover`, `is_del`, `device`, `create_time`, `update_time`, `login_time`, `login_coord_lng`, `login_coord_lat`, `guid`) VALUES
	(0, '00000000000', '$2y$10$ZRSq.gc.vOqmJzwRFnrFFux9rmpBqQCHIzXq4RkDenQxetMNrOlNe', '1a2b463ab900fa81277a', '', '', '', '美约平台', '美约', 'CEO', '', 1, '1991-01-24', 4, 42, 127, '89/72/30', 'C', '九江', '深圳', '/upload/user/avatar/owHf-fxmpnqm3336966.jpg', 1, '2015年香港小姐亚军', '', '辣条', '', '', '跳皮筋', '', '', 0, 3, 0, '', '', '', '', NULL, '', '', 0, 'app', '2016-11-08 09:57:19', '2016-11-11 15:12:58', '2016-11-11 15:12:58', 0.0000000, 0.0000000, ''),
	(3, '18316629979', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d034', '', '', '', '薇薇', '曹蒹葭', '模特', '', 2, '1995-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/139-1503131F955.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-04/581c25d50ba3d.jpg";i:1;s:48:"/upload/user/images/2016-11-04/581c25d5142cf.jpg";}', '/upload/user/video/2016-11-07/58201cb2a0bcb.m4v', '/upload/user/video/2016-11-07/58201cb2a54b0.jpg', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-07 14:18:26', '2016-11-07 11:05:53', 114.0440445, 22.6315136, ''),
	(4, '18681540783', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', 'welber', '曹小萌', '模特', '', 2, '1996-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/c7eafcd1e0650af.jpeg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-15 10:08:24', '2016-11-15 10:08:24', 114.0452423, 22.6445580, ''),
	(5, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小2', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1_b9dfb4fc8fe6e3f17ad199269eb21c4d_510.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.2445583, ''),
	(6, '18316629976', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小3', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/0325zfmv2544.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0643845, 22.1445580, ''),
	(7, '18316629971', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小4', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1456365636.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0452347, 22.2445583, ''),
	(8, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小5', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.4445572, ''),
	(9, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小6', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/2.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.3445587, ''),
	(10, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小7', '曹小萌', '模特', '', 2, '1990-08-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/3.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.6445580, ''),
	(11, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小8', '曹小萌', '模特', '', 2, '1990-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/4.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.7445583, ''),
	(12, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小9', '曹小萌', '模特', '', 2, '1991-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/5.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.8445587, ''),
	(13, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小10', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/6.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.9445572, ''),
	(14, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小11', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/7.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.3445587, ''),
	(15, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/8.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.7445583, ''),
	(17, '18316629973', '$2y$10$ZRSq.gc.vOqmJzwRFnrFFux9rmpBqQCHIzXq4RkDenQxetMNrOlNe', '1a2b463ab900fa81277a', '', '', '', '王姑娘', '王语嫣', '平面模特', '', 2, '1991-01-24', 4, 42, 127, '89/72/30', 'C', '九江', '深圳', '/upload/user/avatar/2016-11-08/58213277e2421.jpg', 1, '2015年香港小姐亚军', '', '辣条', '', '', '跳皮筋', '', '', 0, 3, 1, '', '', '', '', '', '', '', 0, 'app', '2016-11-08 09:57:19', '2016-11-15 09:36:15', '2016-11-15 09:36:15', 0.0000000, 0.0000000, ''),
	(18, '18316629974', '$2y$10$ZRSq.gc.vOqmJzwRFnrFFux9rmpBqQCHIzXq4RkDenQxetMNrOlNe', '1a2b463ab900fa81277a', '', '', '', '国民老公', '王思聪', 'CEO', '', 1, '1991-01-24', 4, 42, 127, '89/72/30', 'C', '九江', '深圳', '/upload/user/avatar/owHf-fxmpnqm3336966.jpg', 1, '2015年香港小姐亚军', '', '辣条', '', '', '跳皮筋', '', '', 999639, 3, 1, '', '', '', '', NULL, '', '', 0, 'app', '2016-11-08 09:57:19', '2016-11-14 09:56:27', '2016-11-14 09:56:27', 0.0000000, 0.0000000, '');
/*!40000 ALTER TABLE `lm_user` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_fans 结构
CREATE TABLE IF NOT EXISTS `lm_user_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '关注者',
  `following_id` int(11) NOT NULL COMMENT '被关注者',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1,单向关注2互为关注',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='用户关系表';

-- 正在导出表  meiyue.lm_user_fans 的数据：~5 rows (大约)
DELETE FROM `lm_user_fans`;
/*!40000 ALTER TABLE `lm_user_fans` DISABLE KEYS */;
INSERT INTO `lm_user_fans` (`id`, `user_id`, `following_id`, `type`, `create_time`, `update_time`) VALUES
	(3, 18, 4, 1, '2016-11-08 15:11:05', '2016-11-08 15:11:05'),
	(11, 18, 11, 1, '2016-11-08 18:36:24', '2016-11-08 18:36:24'),
	(12, 18, 15, 1, '2016-11-08 18:36:30', '2016-11-08 18:36:30'),
	(13, 18, 9, 1, '2016-11-08 18:36:35', '2016-11-08 18:36:35'),
	(14, 18, 14, 1, '2016-11-08 18:36:41', '2016-11-08 18:36:41'),
	(15, 18, 17, 1, '2016-11-08 18:37:00', '2016-11-08 18:37:00');
/*!40000 ALTER TABLE `lm_user_fans` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_profile 结构
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
CREATE TABLE IF NOT EXISTS `lm_user_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `skill_id` int(11) NOT NULL COMMENT '对应管理员录入的名称',
  `cost_id` int(11) NOT NULL COMMENT '对应管理员录入的费用',
  `description` varchar(200) NOT NULL COMMENT '约会说明',
  `is_used` tinyint(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
  `is_checked` tinyint(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户技能表';

-- 正在导出表  meiyue.lm_user_skill 的数据：~8 rows (大约)
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
	(8, 7, 5, 1, '', 1, 1);
/*!40000 ALTER TABLE `lm_user_skill` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_skill_tag 结构
CREATE TABLE IF NOT EXISTS `lm_user_skill_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_skill_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户技能-标签中间表';

-- 正在导出表  meiyue.lm_user_skill_tag 的数据：~2 rows (大约)
DELETE FROM `lm_user_skill_tag`;
/*!40000 ALTER TABLE `lm_user_skill_tag` DISABLE KEYS */;
INSERT INTO `lm_user_skill_tag` (`id`, `user_skill_id`, `tag_id`) VALUES
	(1, 5, 3),
	(2, 5, 5),
	(3, 5, 7);
/*!40000 ALTER TABLE `lm_user_skill_tag` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_tag 结构
CREATE TABLE IF NOT EXISTS `lm_user_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_tag_id` (`user_id`,`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户个人标签';

-- 正在导出表  meiyue.lm_user_tag 的数据：~2 rows (大约)
DELETE FROM `lm_user_tag`;
/*!40000 ALTER TABLE `lm_user_tag` DISABLE KEYS */;
INSERT INTO `lm_user_tag` (`id`, `user_id`, `tag_id`) VALUES
	(1, 17, 5),
	(3, 17, 6),
	(2, 17, 19);
/*!40000 ALTER TABLE `lm_user_tag` ENABLE KEYS */;

-- 导出  表 meiyue.phinxlog 结构
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

-- 导出  表 meiyue.wpadmin_phinxlog 结构
CREATE TABLE IF NOT EXISTS `wpadmin_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.wpadmin_phinxlog 的数据：~2 rows (大约)
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
