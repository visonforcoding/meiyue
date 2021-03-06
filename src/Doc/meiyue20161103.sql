/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : meiyue

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-11-03 15:53:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lm_actionlog`
-- ----------------------------
DROP TABLE IF EXISTS `lm_actionlog`;
CREATE TABLE `lm_actionlog` (
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
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 CHECKSUM=1 ROW_FORMAT=DYNAMIC COMMENT='后台操作日志表';

-- ----------------------------
-- Records of lm_actionlog
-- ----------------------------
INSERT INTO `lm_actionlog` VALUES ('1', 'menu/edit/2', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'菜单管理\',\n  \'node\' => \'/menu/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-list\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 02:28:04');
INSERT INTO `lm_actionlog` VALUES ('2', 'menu/edit/3', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'user管理\',\n  \'node\' => \'/user/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-user\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 02:29:37');
INSERT INTO `lm_actionlog` VALUES ('3', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'管理员管理\',\n  \'node\' => \'/admin/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-android\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 03:12:05');
INSERT INTO `lm_actionlog` VALUES ('4', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:24:49');
INSERT INTO `lm_actionlog` VALUES ('5', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:27:38');
INSERT INTO `lm_actionlog` VALUES ('6', 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \'\',\n  ),\n)', 'admin', '2016-10-18 03:29:43');
INSERT INTO `lm_actionlog` VALUES ('7', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 03:30:25');
INSERT INTO `lm_actionlog` VALUES ('8', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 13:00:00');
INSERT INTO `lm_actionlog` VALUES ('9', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 14:03:43');
INSERT INTO `lm_actionlog` VALUES ('10', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'群组管理\',\n  \'node\' => \'/group/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-group\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-18 14:07:11');
INSERT INTO `lm_actionlog` VALUES ('11', 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:10:19');
INSERT INTO `lm_actionlog` VALUES ('12', 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:11:24');
INSERT INTO `lm_actionlog` VALUES ('13', 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:16:43');
INSERT INTO `lm_actionlog` VALUES ('14', 'group/add', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'group', 'add', 'array (\n  \'name\' => \'超级管理员\',\n  \'remark\' => \'无限权限\',\n)', 'admin', '2016-10-18 14:25:31');
INSERT INTO `lm_actionlog` VALUES ('15', 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \n    array (\n      0 => \'1\',\n    ),\n  ),\n)', 'admin', '2016-10-18 14:28:03');
INSERT INTO `lm_actionlog` VALUES ('16', 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \'\',\n  ),\n)', 'admin', '2016-10-18 14:29:25');
INSERT INTO `lm_actionlog` VALUES ('17', 'admin/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'admin', 'edit', 'array (\n  \'username\' => \'admin\',\n  \'enabled\' => \'1\',\n  \'g\' => \n  array (\n    \'_ids\' => \n    array (\n      0 => \'1\',\n    ),\n  ),\n)', 'admin', '2016-10-18 14:31:15');
INSERT INTO `lm_actionlog` VALUES ('18', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.04', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-18 15:41:33');
INSERT INTO `lm_actionlog` VALUES ('19', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-10-20 14:31:37');
INSERT INTO `lm_actionlog` VALUES ('20', 'menu/edit/6', 'PUT', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36', '127.0.0.1', 'F:\\www\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'操作日志管理\',\n  \'node\' => \'/actionlog/index\',\n  \'pid\' => \'1\',\n  \'class\' => \'icon-keyboard\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-10-20 14:36:49');
INSERT INTO `lm_actionlog` VALUES ('21', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-01 11:48:55');
INSERT INTO `lm_actionlog` VALUES ('22', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'技能管理\',\n  \'node\' => \'/skills/index\',\n  \'pid\' => \'0\',\n  \'class\' => \'icon-angle-right\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'管理员进行美女技能管理\',\n)', 'admin', '2016-11-01 13:47:34');
INSERT INTO `lm_actionlog` VALUES ('23', 'menu/edit/8', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'约会管理\',\n  \'node\' => \'\',\n  \'pid\' => \'0\',\n  \'class\' => \'icon-wechat\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'管理员进行美女技能管理\',\n)', 'admin', '2016-11-01 13:49:44');
INSERT INTO `lm_actionlog` VALUES ('24', 'menu/edit/8', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'约会管理\',\n  \'node\' => \'\',\n  \'pid\' => \'0\',\n  \'class\' => \'icon-wechat\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 13:49:54');
INSERT INTO `lm_actionlog` VALUES ('25', 'menu/edit/7', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'技能管理\',\n  \'node\' => \'/skills/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-lemon\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 13:50:36');
INSERT INTO `lm_actionlog` VALUES ('26', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约吃饭\',\n)', 'admin', '2016-11-01 13:51:06');
INSERT INTO `lm_actionlog` VALUES ('27', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:52:40');
INSERT INTO `lm_actionlog` VALUES ('28', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:52:43');
INSERT INTO `lm_actionlog` VALUES ('29', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:52:50');
INSERT INTO `lm_actionlog` VALUES ('30', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:52:50');
INSERT INTO `lm_actionlog` VALUES ('31', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:53:03');
INSERT INTO `lm_actionlog` VALUES ('32', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:53:04');
INSERT INTO `lm_actionlog` VALUES ('33', 'skills/add', 'POST', 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:53:10');
INSERT INTO `lm_actionlog` VALUES ('34', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:56:14');
INSERT INTO `lm_actionlog` VALUES ('35', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:56:38');
INSERT INTO `lm_actionlog` VALUES ('36', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:57:55');
INSERT INTO `lm_actionlog` VALUES ('37', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:58:51');
INSERT INTO `lm_actionlog` VALUES ('38', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'name\' => \'约电影\',\n)', 'admin', '2016-11-01 13:59:08');
INSERT INTO `lm_actionlog` VALUES ('39', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'价格管理\',\n  \'node\' => \'/costs/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-yen\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 14:31:42');
INSERT INTO `lm_actionlog` VALUES ('40', 'costs/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'costs', 'add', 'array (\n  \'money\' => \'300\',\n)', 'admin', '2016-11-01 14:31:56');
INSERT INTO `lm_actionlog` VALUES ('41', 'costs/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'costs', 'add', 'array (\n  \'money\' => \'400\',\n)', 'admin', '2016-11-01 14:32:03');
INSERT INTO `lm_actionlog` VALUES ('42', 'costs/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'costs', 'add', 'array (\n  \'money\' => \'350\',\n)', 'admin', '2016-11-01 14:32:27');
INSERT INTO `lm_actionlog` VALUES ('43', 'costs/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'costs', 'add', 'array (\n  \'money\' => \'450\',\n)', 'admin', '2016-11-01 14:32:42');
INSERT INTO `lm_actionlog` VALUES ('44', 'costs/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'costs', 'add', 'array (\n  \'money\' => \'500\',\n)', 'admin', '2016-11-01 14:32:49');
INSERT INTO `lm_actionlog` VALUES ('45', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:42:58');
INSERT INTO `lm_actionlog` VALUES ('46', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:42:59');
INSERT INTO `lm_actionlog` VALUES ('47', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:00');
INSERT INTO `lm_actionlog` VALUES ('48', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:01');
INSERT INTO `lm_actionlog` VALUES ('49', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:02');
INSERT INTO `lm_actionlog` VALUES ('50', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:02');
INSERT INTO `lm_actionlog` VALUES ('51', 'menu/edit/10', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'costs管理\',\n  \'node\' => \'/costs/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 14:43:15');
INSERT INTO `lm_actionlog` VALUES ('52', 'menu/edit/12', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'用户标签管理\',\n  \'node\' => \'/tags/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-tags\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 14:43:49');
INSERT INTO `lm_actionlog` VALUES ('53', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:56');
INSERT INTO `lm_actionlog` VALUES ('54', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:57');
INSERT INTO `lm_actionlog` VALUES ('55', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:43:58');
INSERT INTO `lm_actionlog` VALUES ('56', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-01 14:44:05');
INSERT INTO `lm_actionlog` VALUES ('57', 'menu/edit/9', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'用户技能管理\',\n  \'node\' => \'/userskills/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-leaf\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 14:46:08');
INSERT INTO `lm_actionlog` VALUES ('58', 'menu/edit/11', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'价格管理\',\n  \'node\' => \'/costs/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-credit\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-01 14:49:31');
INSERT INTO `lm_actionlog` VALUES ('59', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-01 15:13:09');
INSERT INTO `lm_actionlog` VALUES ('60', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'name\' => \'性格标签\',\n  \'field\' => \'\',\n)', 'admin', '2016-11-01 15:30:36');
INSERT INTO `lm_actionlog` VALUES ('61', 'tags/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'tags', 'edit', 'array (\n  \'name\' => \'类型标签\',\n  \'parent_id\' => \'2\',\n)', 'admin', '2016-11-01 15:31:12');
INSERT INTO `lm_actionlog` VALUES ('62', 'tags/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'tags', 'edit', 'array (\n  \'name\' => \'类型标签\',\n  \'parent_id\' => \'\',\n)', 'admin', '2016-11-01 15:34:11');
INSERT INTO `lm_actionlog` VALUES ('63', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'name\' => \'dsfsf\',\n  \'parent_id\' => \'\',\n)', 'admin', '2016-11-01 16:17:31');
INSERT INTO `lm_actionlog` VALUES ('64', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'3\',\n)', 'admin', '2016-11-01 16:17:36');
INSERT INTO `lm_actionlog` VALUES ('65', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'name\' => \'成熟型\',\n  \'parent_id\' => \'1\',\n)', 'admin', '2016-11-01 16:40:02');
INSERT INTO `lm_actionlog` VALUES ('66', 'userskills/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'userskills', 'edit', 'array (\n  \'skill_id\' => \'1\',\n  \'cost_id\' => \'1\',\n  \'desc\' => \'hello\',\n  \'is_used\' => \'0\',\n  \'is_checked\' => \'1\',\n)', 'admin', '2016-11-01 19:52:26');
INSERT INTO `lm_actionlog` VALUES ('67', 'userskills/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'userskills', 'edit', 'array (\n  \'skill_id\' => \'1\',\n  \'cost_id\' => \'1\',\n  \'desc\' => \'hello\',\n  \'is_used\' => \'1\',\n  \'is_checked\' => \'1\',\n)', 'admin', '2016-11-01 19:52:34');
INSERT INTO `lm_actionlog` VALUES ('68', 'userskills/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'userskills', 'edit', 'array (\n  \'skill_id\' => \'1\',\n  \'cost_id\' => \'1\',\n  \'desc\' => \'hello\',\n  \'is_used\' => \'1\',\n  \'is_checked\' => \'2\',\n)', 'admin', '2016-11-01 19:53:52');
INSERT INTO `lm_actionlog` VALUES ('69', 'userskills/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'userskills', 'edit', 'array (\n  \'skill_id\' => \'1\',\n  \'cost_id\' => \'1\',\n  \'desc\' => \'hello\',\n  \'is_used\' => \'1\',\n  \'is_checked\' => \'1\',\n)', 'admin', '2016-11-01 20:21:21');
INSERT INTO `lm_actionlog` VALUES ('70', 'userskills/edit/1', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'userskills', 'edit', 'array (\n  \'skill_id\' => \'1\',\n  \'cost_id\' => \'1\',\n  \'desc\' => \'hello\',\n  \'is_used\' => \'1\',\n  \'is_checked\' => \'2\',\n)', 'admin', '2016-11-02 09:42:19');
INSERT INTO `lm_actionlog` VALUES ('71', 'admin/login', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-02 16:31:55');
INSERT INTO `lm_actionlog` VALUES ('72', 'skills/edit/2', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'skills', 'edit', 'array (\n  \'name\' => \'约电影1\',\n)', 'admin', '2016-11-02 17:54:09');
INSERT INTO `lm_actionlog` VALUES ('73', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'1\',\n)', 'admin', '2016-11-02 18:01:58');
INSERT INTO `lm_actionlog` VALUES ('74', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'技能分类管理\',\n  \'node\' => \'/skills/category\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-align-justify\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:03:03');
INSERT INTO `lm_actionlog` VALUES ('75', 'menu/edit/13', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'技能分类管理\',\n  \'node\' => \'/skills/category\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-align-justify\',\n  \'rank\' => \'1\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:03:35');
INSERT INTO `lm_actionlog` VALUES ('76', 'menu/edit/7', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'技能管理\',\n  \'node\' => \'/skills/index\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-lemon\',\n  \'rank\' => \'2\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:04:02');
INSERT INTO `lm_actionlog` VALUES ('77', 'menu/edit/13', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'技能分类管理\',\n  \'node\' => \'/skills/category\',\n  \'pid\' => \'8\',\n  \'class\' => \'icon-align-justify\',\n  \'rank\' => \'100\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:04:30');
INSERT INTO `lm_actionlog` VALUES ('78', 'menu/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'menu', 'add', 'array (\n  \'name\' => \'申请管理\',\n  \'node\' => \'\',\n  \'pid\' => \'0\',\n  \'class\' => \'icon-envelope-alt\',\n  \'rank\' => \'10\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:05:41');
INSERT INTO `lm_actionlog` VALUES ('79', 'menu/edit/9', 'PUT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'menu', 'edit', 'array (\n  \'name\' => \'用户技能管理\',\n  \'node\' => \'/userskills/index\',\n  \'pid\' => \'14\',\n  \'class\' => \'icon-leaf\',\n  \'rank\' => \'\',\n  \'is_menu\' => \'1\',\n  \'status\' => \'1\',\n  \'remark\' => \'\',\n)', 'admin', '2016-11-02 18:05:59');
INSERT INTO `lm_actionlog` VALUES ('80', 'skills/edit/5', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'skills', 'edit', 'array (\n  \'name\' => \'看恐怖片\',\n)', 'admin', '2016-11-02 18:35:10');
INSERT INTO `lm_actionlog` VALUES ('81', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'约约约\',\n)', 'admin', '2016-11-02 18:40:26');
INSERT INTO `lm_actionlog` VALUES ('82', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'6\',\n  \'name\' => \'第三方\',\n)', 'admin', '2016-11-02 18:40:33');
INSERT INTO `lm_actionlog` VALUES ('83', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'13\',\n)', 'admin', '2016-11-02 18:42:05');
INSERT INTO `lm_actionlog` VALUES ('84', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'13\',\n)', 'admin', '2016-11-02 18:42:07');
INSERT INTO `lm_actionlog` VALUES ('85', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'13\',\n)', 'admin', '2016-11-02 18:42:08');
INSERT INTO `lm_actionlog` VALUES ('86', 'wpadmin/menu/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'menu', 'delete', 'array (\n  \'id\' => \'13\',\n)', 'admin', '2016-11-02 18:42:09');
INSERT INTO `lm_actionlog` VALUES ('87', 'admin/login', 'POST', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; Media Center PC 6.0; .NET4.0C; .NET4.0E; .NET CLR 3.5.30729; .NET CLR 3.0.30729)', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '登录系统', 'admin', 'login', '', 'admin', '2016-11-02 18:44:02');
INSERT INTO `lm_actionlog` VALUES ('88', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'1\',\n)', 'admin', '2016-11-02 22:59:41');
INSERT INTO `lm_actionlog` VALUES ('89', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'4\',\n)', 'admin', '2016-11-02 22:59:50');
INSERT INTO `lm_actionlog` VALUES ('90', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-02 23:00:08');
INSERT INTO `lm_actionlog` VALUES ('91', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-02 23:00:28');
INSERT INTO `lm_actionlog` VALUES ('92', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-02 23:01:50');
INSERT INTO `lm_actionlog` VALUES ('93', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-02 23:11:11');
INSERT INTO `lm_actionlog` VALUES ('94', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-02 23:12:21');
INSERT INTO `lm_actionlog` VALUES ('95', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sfsd\',\n)', 'admin', '2016-11-02 23:12:42');
INSERT INTO `lm_actionlog` VALUES ('96', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sdjfks\',\n)', 'admin', '2016-11-02 23:15:06');
INSERT INTO `lm_actionlog` VALUES ('97', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sdfsdf\',\n)', 'admin', '2016-11-02 23:15:20');
INSERT INTO `lm_actionlog` VALUES ('98', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'ff\',\n)', 'admin', '2016-11-02 23:18:13');
INSERT INTO `lm_actionlog` VALUES ('99', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sss\',\n)', 'admin', '2016-11-02 23:18:54');
INSERT INTO `lm_actionlog` VALUES ('100', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'8\',\n)', 'admin', '2016-11-02 23:20:40');
INSERT INTO `lm_actionlog` VALUES ('101', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'7\',\n)', 'admin', '2016-11-02 23:20:46');
INSERT INTO `lm_actionlog` VALUES ('102', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'6\',\n)', 'admin', '2016-11-02 23:20:49');
INSERT INTO `lm_actionlog` VALUES ('103', 'tags/edit/2', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'tags', 'edit', 'array (\n  \'name\' => \'性格标签1\',\n)', 'admin', '2016-11-02 23:21:28');
INSERT INTO `lm_actionlog` VALUES ('104', 'tags/edit/2', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '修改', 'tags', 'edit', 'array (\n  \'name\' => \'性格标签\',\n)', 'admin', '2016-11-02 23:21:33');
INSERT INTO `lm_actionlog` VALUES ('105', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'sfsd\',\n)', 'admin', '2016-11-02 23:21:37');
INSERT INTO `lm_actionlog` VALUES ('106', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'5\',\n)', 'admin', '2016-11-02 23:21:40');
INSERT INTO `lm_actionlog` VALUES ('107', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sdfsd\',\n)', 'admin', '2016-11-02 23:21:44');
INSERT INTO `lm_actionlog` VALUES ('108', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sdfsd\',\n)', 'admin', '2016-11-02 23:21:46');
INSERT INTO `lm_actionlog` VALUES ('109', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'2323\',\n)', 'admin', '2016-11-02 23:23:40');
INSERT INTO `lm_actionlog` VALUES ('110', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'2323\',\n)', 'admin', '2016-11-02 23:23:45');
INSERT INTO `lm_actionlog` VALUES ('111', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'f\',\n)', 'admin', '2016-11-02 23:27:50');
INSERT INTO `lm_actionlog` VALUES ('112', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'l\',\n)', 'admin', '2016-11-02 23:28:45');
INSERT INTO `lm_actionlog` VALUES ('113', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'3\',\n  \'name\' => \'反反复复\',\n)', 'admin', '2016-11-02 23:31:52');
INSERT INTO `lm_actionlog` VALUES ('114', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'fdf\',\n)', 'admin', '2016-11-02 23:33:18');
INSERT INTO `lm_actionlog` VALUES ('115', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'3\',\n  \'name\' => \'fdf\',\n)', 'admin', '2016-11-02 23:33:42');
INSERT INTO `lm_actionlog` VALUES ('116', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'fdf\',\n)', 'admin', '2016-11-02 23:34:11');
INSERT INTO `lm_actionlog` VALUES ('117', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'9\',\n)', 'admin', '2016-11-02 23:39:18');
INSERT INTO `lm_actionlog` VALUES ('118', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'5\',\n)', 'admin', '2016-11-02 23:39:24');
INSERT INTO `lm_actionlog` VALUES ('119', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'6\',\n)', 'admin', '2016-11-02 23:39:33');
INSERT INTO `lm_actionlog` VALUES ('120', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \';\',\n)', 'admin', '2016-11-02 23:40:16');
INSERT INTO `lm_actionlog` VALUES ('121', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'dfd\',\n)', 'admin', '2016-11-02 23:41:13');
INSERT INTO `lm_actionlog` VALUES ('122', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'ll\',\n)', 'admin', '2016-11-02 23:45:16');
INSERT INTO `lm_actionlog` VALUES ('123', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'ggg\',\n)', 'admin', '2016-11-02 23:55:18');
INSERT INTO `lm_actionlog` VALUES ('124', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'11\',\n)', 'admin', '2016-11-02 23:55:24');
INSERT INTO `lm_actionlog` VALUES ('125', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'10\',\n)', 'admin', '2016-11-02 23:55:26');
INSERT INTO `lm_actionlog` VALUES ('126', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'fff\',\n)', 'admin', '2016-11-02 23:55:32');
INSERT INTO `lm_actionlog` VALUES ('127', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'fff\',\n)', 'admin', '2016-11-03 09:38:44');
INSERT INTO `lm_actionlog` VALUES ('128', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'yy\',\n)', 'admin', '2016-11-03 09:40:41');
INSERT INTO `lm_actionlog` VALUES ('129', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'yy\',\n)', 'admin', '2016-11-03 09:41:16');
INSERT INTO `lm_actionlog` VALUES ('130', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'yy\',\n)', 'admin', '2016-11-03 09:41:45');
INSERT INTO `lm_actionlog` VALUES ('131', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'gg\',\n)', 'admin', '2016-11-03 09:43:11');
INSERT INTO `lm_actionlog` VALUES ('132', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'dd\',\n)', 'admin', '2016-11-03 09:59:03');
INSERT INTO `lm_actionlog` VALUES ('133', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'5\',\n)', 'admin', '2016-11-03 09:59:08');
INSERT INTO `lm_actionlog` VALUES ('134', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'sdfdsf\',\n)', 'admin', '2016-11-03 10:00:05');
INSERT INTO `lm_actionlog` VALUES ('135', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'6\',\n  \'name\' => \'ff\',\n)', 'admin', '2016-11-03 10:00:18');
INSERT INTO `lm_actionlog` VALUES ('136', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'7\',\n)', 'admin', '2016-11-03 10:01:46');
INSERT INTO `lm_actionlog` VALUES ('137', 'skills/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'skills', 'delete', 'array (\n  \'id\' => \'6\',\n)', 'admin', '2016-11-03 10:01:49');
INSERT INTO `lm_actionlog` VALUES ('138', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'gg\',\n)', 'admin', '2016-11-03 10:01:56');
INSERT INTO `lm_actionlog` VALUES ('139', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'dfdf\',\n)', 'admin', '2016-11-03 10:05:54');
INSERT INTO `lm_actionlog` VALUES ('140', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'4\',\n)', 'admin', '2016-11-03 10:07:18');
INSERT INTO `lm_actionlog` VALUES ('141', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'3\',\n)', 'admin', '2016-11-03 10:07:21');
INSERT INTO `lm_actionlog` VALUES ('142', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'看恐怖片\',\n)', 'admin', '2016-11-03 14:12:34');
INSERT INTO `lm_actionlog` VALUES ('143', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'看爱情片\',\n)', 'admin', '2016-11-03 14:12:42');
INSERT INTO `lm_actionlog` VALUES ('144', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'3\',\n  \'name\' => \'打篮球\',\n)', 'admin', '2016-11-03 14:12:49');
INSERT INTO `lm_actionlog` VALUES ('145', 'skills/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'skills', 'add', 'array (\n  \'parent_id\' => \'3\',\n  \'name\' => \'打羽毛球\',\n)', 'admin', '2016-11-03 14:12:55');
INSERT INTO `lm_actionlog` VALUES ('146', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'0\',\n  \'name\' => \'类型标签\',\n)', 'admin', '2016-11-03 14:52:34');
INSERT INTO `lm_actionlog` VALUES ('147', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'萌哒萌哒\',\n)', 'admin', '2016-11-03 14:52:55');
INSERT INTO `lm_actionlog` VALUES ('148', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'5\',\n  \'name\' => \'大长腿\',\n)', 'admin', '2016-11-03 14:53:04');
INSERT INTO `lm_actionlog` VALUES ('149', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'5\',\n  \'name\' => \'小蛮腰\',\n)', 'admin', '2016-11-03 14:53:12');
INSERT INTO `lm_actionlog` VALUES ('150', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'温文尔雅\',\n)', 'admin', '2016-11-03 14:59:49');
INSERT INTO `lm_actionlog` VALUES ('151', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'可爱活泼\',\n)', 'admin', '2016-11-03 14:59:56');
INSERT INTO `lm_actionlog` VALUES ('152', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'泼辣老练\',\n)', 'admin', '2016-11-03 15:00:04');
INSERT INTO `lm_actionlog` VALUES ('153', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'善良开朗\',\n)', 'admin', '2016-11-03 15:00:55');
INSERT INTO `lm_actionlog` VALUES ('154', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'豁达稳重\',\n)', 'admin', '2016-11-03 15:01:10');
INSERT INTO `lm_actionlog` VALUES ('155', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'虚荣冷淡\',\n)', 'admin', '2016-11-03 15:01:25');
INSERT INTO `lm_actionlog` VALUES ('156', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'2\',\n  \'name\' => \'善于体察\',\n)', 'admin', '2016-11-03 15:01:43');
INSERT INTO `lm_actionlog` VALUES ('157', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'5\',\n  \'name\' => \'虎体熊腰\',\n)', 'admin', '2016-11-03 15:02:08');
INSERT INTO `lm_actionlog` VALUES ('158', 'tags/add', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '添加', 'tags', 'add', 'array (\n  \'parent_id\' => \'5\',\n  \'name\' => \'短小精辩\',\n)', 'admin', '2016-11-03 15:02:19');
INSERT INTO `lm_actionlog` VALUES ('159', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'15\',\n)', 'admin', '2016-11-03 15:03:25');
INSERT INTO `lm_actionlog` VALUES ('160', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'14\',\n)', 'admin', '2016-11-03 15:03:28');
INSERT INTO `lm_actionlog` VALUES ('161', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'13\',\n)', 'admin', '2016-11-03 15:03:31');
INSERT INTO `lm_actionlog` VALUES ('162', 'tags/delete', 'POST', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '127.0.0.1', 'C:\\development\\xampp\\htdocs\\meiyue\\plugins\\Wpadmin\\src\\Controller\\Component\\UtilComponent.php', '删除', 'tags', 'delete', 'array (\n  \'id\' => \'12\',\n)', 'admin', '2016-11-03 15:03:34');

-- ----------------------------
-- Table structure for `lm_admin`
-- ----------------------------
DROP TABLE IF EXISTS `lm_admin`;
CREATE TABLE `lm_admin` (
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

-- ----------------------------
-- Records of lm_admin
-- ----------------------------
INSERT INTO `lm_admin` VALUES ('1', 'admin', '$2y$10$FO3TYb8S3BygWrtep7DsY.f7qcWcSe95yC50FH5uEa8FIHmv0ViVG', '1', '2016-10-17 10:17:52', '2016-11-02 18:44:02', '2016-11-02 18:44:02', '127.0.0.1');

-- ----------------------------
-- Table structure for `lm_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `lm_admin_group`;
CREATE TABLE `lm_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL COMMENT '管理员',
  `group_id` int(11) NOT NULL COMMENT '所属组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_id` (`admin_id`,`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='管理员群组';

-- ----------------------------
-- Records of lm_admin_group
-- ----------------------------
INSERT INTO `lm_admin_group` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for `lm_costs`
-- ----------------------------
DROP TABLE IF EXISTS `lm_costs`;
CREATE TABLE `lm_costs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money` double NOT NULL DEFAULT '0' COMMENT '价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='价格管理';

-- ----------------------------
-- Records of lm_costs
-- ----------------------------
INSERT INTO `lm_costs` VALUES ('1', '300');
INSERT INTO `lm_costs` VALUES ('2', '400');
INSERT INTO `lm_costs` VALUES ('3', '350');
INSERT INTO `lm_costs` VALUES ('4', '450');
INSERT INTO `lm_costs` VALUES ('5', '500');

-- ----------------------------
-- Table structure for `lm_dates`
-- ----------------------------
DROP TABLE IF EXISTS `lm_dates`;
CREATE TABLE `lm_dates` (
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

-- ----------------------------
-- Records of lm_dates
-- ----------------------------

-- ----------------------------
-- Table structure for `lm_dates_tags`
-- ----------------------------
DROP TABLE IF EXISTS `lm_dates_tags`;
CREATE TABLE `lm_dates_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应约会id',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应标签id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会-标签中间表';

-- ----------------------------
-- Records of lm_dates_tags
-- ----------------------------

-- ----------------------------
-- Table structure for `lm_date_sites`
-- ----------------------------
DROP TABLE IF EXISTS `lm_date_sites`;
CREATE TABLE `lm_date_sites` (
  `id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL COMMENT '地理坐标',
  `name` varchar(50) NOT NULL COMMENT '地点名称',
  `列 4` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='约会地点表';

-- ----------------------------
-- Records of lm_date_sites
-- ----------------------------

-- ----------------------------
-- Table structure for `lm_group`
-- ----------------------------
DROP TABLE IF EXISTS `lm_group`;
CREATE TABLE `lm_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '群组名称',
  `remark` varchar(50) NOT NULL COMMENT '备注',
  `ctime` datetime NOT NULL COMMENT '创建时间',
  `utime` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lm_group
-- ----------------------------
INSERT INTO `lm_group` VALUES ('1', '超级管理员', '无限权限', '2016-10-18 14:25:32', '2016-10-18 14:25:32');

-- ----------------------------
-- Table structure for `lm_group_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lm_group_menu`;
CREATE TABLE `lm_group_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '群组',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id` (`group_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lm_group_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `lm_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lm_menu`;
CREATE TABLE `lm_menu` (
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lm_menu
-- ----------------------------
INSERT INTO `lm_menu` VALUES ('1', '系统设置', '', '0', 'icon-cogs', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('2', '菜单管理', '/menu/index', '1', 'icon-list', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('3', 'user管理', '/user/index', '1', 'icon-user', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('4', '管理员管理', '/admin/index', '1', 'icon-android', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('5', '群组管理', '/group/index', '1', 'icon-group', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('6', '操作日志管理', '/actionlog/index', '1', 'icon-keyboard', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('7', '技能管理', '/skills/index', '8', 'icon-lemon', '2', '1', '1', '');
INSERT INTO `lm_menu` VALUES ('8', '约会管理', '', '0', 'icon-wechat', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('9', '用户技能管理', '/userskills/index', '14', 'icon-leaf', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('11', '价格管理', '/costs/index', '8', 'icon-credit', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('12', '用户标签管理', '/tags/index', '8', 'icon-tags', null, '1', '1', '');
INSERT INTO `lm_menu` VALUES ('14', '申请管理', '', '0', 'icon-envelope-alt', '10', '1', '1', '');

-- ----------------------------
-- Table structure for `lm_skills`
-- ----------------------------
DROP TABLE IF EXISTS `lm_skills`;
CREATE TABLE `lm_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '技能名称',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='技能表（管理员创建）';

-- ----------------------------
-- Records of lm_skills
-- ----------------------------
INSERT INTO `lm_skills` VALUES ('2', '约电影', '0');
INSERT INTO `lm_skills` VALUES ('3', '约运动', '0');
INSERT INTO `lm_skills` VALUES ('4', '约工作', '0');
INSERT INTO `lm_skills` VALUES ('8', '看恐怖片', '2');
INSERT INTO `lm_skills` VALUES ('9', '看爱情片', '2');
INSERT INTO `lm_skills` VALUES ('10', '打篮球', '3');
INSERT INTO `lm_skills` VALUES ('11', '打羽毛球', '3');

-- ----------------------------
-- Table structure for `lm_smsmsg`
-- ----------------------------
DROP TABLE IF EXISTS `lm_smsmsg`;
CREATE TABLE `lm_smsmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(50) NOT NULL DEFAULT '0' COMMENT '手机号',
  `code` varchar(50) DEFAULT NULL COMMENT '验证码',
  `content` varchar(250) DEFAULT NULL COMMENT '内容',
  `expire_time` int(11) DEFAULT NULL COMMENT '过期时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='短信记录';

-- ----------------------------
-- Records of lm_smsmsg
-- ----------------------------
INSERT INTO `lm_smsmsg` VALUES ('19', '13763053901', '4261', '您的动态验证码为4261,请妥善保管，切勿泄露给他人，该验证码10分钟内有效', '1478058595', '2016-11-02 11:39:55');

-- ----------------------------
-- Table structure for `lm_tags`
-- ----------------------------
DROP TABLE IF EXISTS `lm_tags`;
CREATE TABLE `lm_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '标签名',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='标签表';

-- ----------------------------
-- Records of lm_tags
-- ----------------------------
INSERT INTO `lm_tags` VALUES ('2', '性格标签', '0');
INSERT INTO `lm_tags` VALUES ('5', '类型标签', '0');
INSERT INTO `lm_tags` VALUES ('6', '萌哒萌哒', '2');
INSERT INTO `lm_tags` VALUES ('7', '大长腿', '5');
INSERT INTO `lm_tags` VALUES ('8', '小蛮腰', '5');
INSERT INTO `lm_tags` VALUES ('9', '温文尔雅', '2');
INSERT INTO `lm_tags` VALUES ('10', '可爱活泼', '2');
INSERT INTO `lm_tags` VALUES ('11', '泼辣老练', '2');
INSERT INTO `lm_tags` VALUES ('16', '虎体熊腰', '5');
INSERT INTO `lm_tags` VALUES ('17', '短小精辩', '5');

-- ----------------------------
-- Table structure for `lm_user`
-- ----------------------------
DROP TABLE IF EXISTS `lm_user`;
CREATE TABLE `lm_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户表',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `pwd` varchar(120) NOT NULL COMMENT '密码',
  `user_token` varchar(20) NOT NULL COMMENT '用户标志',
  `union_id` varchar(100) DEFAULT '' COMMENT 'wx_unionid',
  `wx_openid` varchar(100) DEFAULT '' COMMENT '微信的openid',
  `app_wx_openid` varchar(100) DEFAULT '' COMMENT 'app端的微信id',
  `truename` varchar(20) DEFAULT '' COMMENT '姓名',
  `level` varchar(20) NOT NULL DEFAULT '1' COMMENT '等级,1:普通2:专家',
  `position` varchar(50) DEFAULT '' COMMENT '职位',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `gender` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1,男，2女',
  `city` varchar(50) DEFAULT '' COMMENT '常驻城市',
  `avatar` varchar(250) DEFAULT '' COMMENT '头像',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '实名认证状态：1.实名待审核2审核通过0审核不通过',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账号状态 ：1.可用0禁用(控制登录)',
  `is_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否假删除：1,是0否',
  `device` varchar(50) NOT NULL DEFAULT 'app' COMMENT '注册设备',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  `guid` varchar(50) NOT NULL DEFAULT '' COMMENT '唯一码（用于扫码登录）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

-- ----------------------------
-- Records of lm_user
-- ----------------------------
INSERT INTO `lm_user` VALUES ('1', '18316629973', '$2y$10$liCZi7f57ZUG.LurSlnQRuuVwsJiGNKwFCzTZ6xi0A3rtjAssopqi', '134d935b57b82fc1e5ea', '', '', '', '', '1', '', '', '1', '', '', '0.00', '1', '1', '0', 'app', '2016-10-23 15:02:47', '2016-10-23 15:02:47', '');
INSERT INTO `lm_user` VALUES ('2', '13763053901', '$2y$10$C4xKPjDrHn2EW.xepYtmA.8mmkankHsgZ7j0Ki/.fEc0R/jQ5oIsu', 'a3ee5290308cd3a3d669', '', '', '', '', '1', '', '', '2', '', '', '0.00', '1', '1', '0', 'app', '2016-11-02 11:40:10', '2016-11-03 15:21:42', '');

-- ----------------------------
-- Table structure for `lm_user_skills`
-- ----------------------------
DROP TABLE IF EXISTS `lm_user_skills`;
CREATE TABLE `lm_user_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL COMMENT '对应管理员录入的名称',
  `cost_id` int(11) NOT NULL COMMENT '对应管理员录入的费用',
  `desc` varchar(200) NOT NULL COMMENT '约会说明',
  `is_used` tinyint(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
  `is_checked` tinyint(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户技能表';

-- ----------------------------
-- Records of lm_user_skills
-- ----------------------------
INSERT INTO `lm_user_skills` VALUES ('1', '1', '1', 'hello', '1', '2');

-- ----------------------------
-- Table structure for `lm_user_skills_tags`
-- ----------------------------
DROP TABLE IF EXISTS `lm_user_skills_tags`;
CREATE TABLE `lm_user_skills_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_skill_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户技能-标签中间表';

-- ----------------------------
-- Records of lm_user_skills_tags
-- ----------------------------

-- ----------------------------
-- Table structure for `phinxlog`
-- ----------------------------
DROP TABLE IF EXISTS `phinxlog`;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phinxlog
-- ----------------------------

-- ----------------------------
-- Table structure for `wpadmin_phinxlog`
-- ----------------------------
DROP TABLE IF EXISTS `wpadmin_phinxlog`;
CREATE TABLE `wpadmin_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wpadmin_phinxlog
-- ----------------------------
INSERT INTO `wpadmin_phinxlog` VALUES ('20160321153421', 'Inital', '2016-10-17 09:24:51', '2016-10-17 09:24:52');
INSERT INTO `wpadmin_phinxlog` VALUES ('20161017092321', 'Initial', '2016-10-17 09:23:22', '2016-10-17 09:23:22');
INSERT INTO `wpadmin_phinxlog` VALUES ('20161017100910', 'Initial', '2016-10-17 10:09:10', '2016-10-17 10:09:10');
