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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='后台操作日志表';

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
	(20, 'menu/edit/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'操作日志管理\',\n  \'node\' => \'/actionlog/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-keyboard\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-20 14:36:49');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.lm_admin 的数据：~0 rows (大约)
DELETE FROM `lm_admin`;
/*!40000 ALTER TABLE `lm_admin` DISABLE KEYS */;
INSERT INTO `lm_admin` (`id`, `username`, `password`, `enabled`, `ctime`, `utime`, `login_time`, `login_ip`) VALUES
	(1, 'admin', '$2y$10$FO3TYb8S3BygWrtep7DsY.f7qcWcSe95yC50FH5uEa8FIHmv0ViVG', 1, '2016-10-17 10:17:52', '2016-10-20 14:31:37', '2016-10-20 14:31:37', '127.0.0.1');
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

-- 正在导出表  meiyue.lm_admin_group 的数据：~0 rows (大约)
DELETE FROM `lm_admin_group`;
/*!40000 ALTER TABLE `lm_admin_group` DISABLE KEYS */;
INSERT INTO `lm_admin_group` (`id`, `admin_id`, `group_id`) VALUES
	(1, 1, 1);
/*!40000 ALTER TABLE `lm_admin_group` ENABLE KEYS */;

-- 导出  表 meiyue.lm_costs 结构
DROP TABLE IF EXISTS `lm_costs`;
CREATE TABLE IF NOT EXISTS `lm_costs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` double NOT NULL DEFAULT '0' COMMENT '价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='价格管理';

-- 正在导出表  meiyue.lm_costs 的数据：~0 rows (大约)
DELETE FROM `lm_costs`;
/*!40000 ALTER TABLE `lm_costs` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_costs` ENABLE KEYS */;

-- 导出  表 meiyue.lm_dates 结构
DROP TABLE IF EXISTS `lm_dates`;
CREATE TABLE IF NOT EXISTS `lm_dates` (
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

-- 正在导出表  meiyue.lm_dates 的数据：~0 rows (大约)
DELETE FROM `lm_dates`;
/*!40000 ALTER TABLE `lm_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_dates` ENABLE KEYS */;

-- 导出  表 meiyue.lm_dates_tags 结构
DROP TABLE IF EXISTS `lm_dates_tags`;
CREATE TABLE IF NOT EXISTS `lm_dates_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应约会id',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会-标签中间表';

-- 正在导出表  meiyue.lm_dates_tags 的数据：~0 rows (大约)
DELETE FROM `lm_dates_tags`;
/*!40000 ALTER TABLE `lm_dates_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_dates_tags` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 正在导出表  meiyue.lm_group 的数据：~0 rows (大约)
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

-- 导出  表 meiyue.lm_skills 结构
DROP TABLE IF EXISTS `lm_skills`;
CREATE TABLE IF NOT EXISTS `lm_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '技能名称',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='技能表（管理员创建）';

-- 正在导出表  meiyue.lm_skills 的数据：~0 rows (大约)
DELETE FROM `lm_skills`;
/*!40000 ALTER TABLE `lm_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_skills` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='短信记录';

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
	(18, '18316629973', '0360', '您的动态验证码为0360,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', 1477896834, '2016-10-31 14:43:54');
/*!40000 ALTER TABLE `lm_smsmsg` ENABLE KEYS */;

-- 导出  表 meiyue.lm_tags 结构
DROP TABLE IF EXISTS `lm_tags`;
CREATE TABLE IF NOT EXISTS `lm_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='标签表';

-- 正在导出表  meiyue.lm_tags 的数据：~0 rows (大约)
DELETE FROM `lm_tags`;
/*!40000 ALTER TABLE `lm_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_tags` ENABLE KEYS */;

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
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '账户余额(美币)',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '审核状态1待审核2审核不通过3审核通过',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账号状态 ：1.可用0禁用(控制登录)',
  `idpath` varchar(250) DEFAULT '' COMMENT '身份证路径',
  `idfront` varchar(250) DEFAULT '' COMMENT '身份证正面照',
  `idback` varchar(250) DEFAULT '' COMMENT '身份证背面照',
  `idperson` varchar(250) DEFAULT '' COMMENT '手持身份照',
  `images` text COMMENT '基本照片',
  `video` varchar(250) DEFAULT '' COMMENT '基本视频',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否假删除：1,是0否',
  `device` varchar(50) NOT NULL DEFAULT 'app' COMMENT '注册设备',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `login_time` datetime DEFAULT NULL COMMENT '上次登陆时间',
  `login_coord` varchar(100) DEFAULT '' COMMENT '上次登录坐标',
  `guid` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一码（用于扫码登录）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

-- 正在导出表  meiyue.lm_user 的数据：~1 rows (大约)
DELETE FROM `lm_user`;
/*!40000 ALTER TABLE `lm_user` DISABLE KEYS */;
INSERT INTO `lm_user` (`id`, `phone`, `pwd`, `user_token`, `union_id`, `wx_openid`, `app_wx_openid`, `nick`, `truename`, `profession`, `email`, `gender`, `birthday`, `zodiac`, `weight`, `height`, `bwh`, `cup`, `hometown`, `city`, `avatar`, `state`, `career`, `place`, `food`, `music`, `movie`, `sport`, `sign`, `wxid`, `money`, `status`, `enabled`, `idpath`, `idfront`, `idback`, `idperson`, `images`, `video`, `is_del`, `device`, `create_time`, `update_time`, `login_time`, `login_coord`, `guid`) VALUES
	(3, '18316629973', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d034', '', '', '', '薇薇', '曹蒹葭', '模特', '', 2, '2015-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/2016-10-31/5816e889dc676.JPG', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 1, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', '', '');
/*!40000 ALTER TABLE `lm_user` ENABLE KEYS */;

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

-- 导出  表 meiyue.lm_user_skills 结构
DROP TABLE IF EXISTS `lm_user_skills`;
CREATE TABLE IF NOT EXISTS `lm_user_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL COMMENT '对应管理员录入的名称',
  `cost_id` int(11) NOT NULL COMMENT '对应管理员录入的费用',
  `desc` varchar(200) NOT NULL COMMENT '约会说明',
  `is_used` tinyint(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
  `is_checked` tinyint(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户技能表';

-- 正在导出表  meiyue.lm_user_skills 的数据：~0 rows (大约)
DELETE FROM `lm_user_skills`;
/*!40000 ALTER TABLE `lm_user_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_user_skills` ENABLE KEYS */;

-- 导出  表 meiyue.lm_user_skills_tags 结构
DROP TABLE IF EXISTS `lm_user_skills_tags`;
CREATE TABLE IF NOT EXISTS `lm_user_skills_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_skill_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户技能-标签中间表';

-- 正在导出表  meiyue.lm_user_skills_tags 的数据：~0 rows (大约)
DELETE FROM `lm_user_skills_tags`;
/*!40000 ALTER TABLE `lm_user_skills_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `lm_user_skills_tags` ENABLE KEYS */;

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

-- 导出  表 meiyue.wpadmin_phinxlog 结构
DROP TABLE IF EXISTS `wpadmin_phinxlog`;
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
