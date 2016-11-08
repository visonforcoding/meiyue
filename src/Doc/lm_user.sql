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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';

-- 正在导出表  meiyue.lm_user 的数据：~13 rows (大约)
DELETE FROM `lm_user`;
/*!40000 ALTER TABLE `lm_user` DISABLE KEYS */;
INSERT INTO `lm_user` (`id`, `phone`, `pwd`, `user_token`, `union_id`, `wx_openid`, `app_wx_openid`, `nick`, `truename`, `profession`, `email`, `gender`, `birthday`, `zodiac`, `weight`, `height`, `bwh`, `cup`, `hometown`, `city`, `avatar`, `state`, `career`, `place`, `food`, `music`, `movie`, `sport`, `sign`, `wxid`, `money`, `status`, `enabled`, `idpath`, `idfront`, `idback`, `idperson`, `images`, `video`, `video_cover`, `is_del`, `device`, `create_time`, `update_time`, `login_time`, `login_coord_lng`, `login_coord_lat`, `guid`) VALUES
	(3, '18316629973', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d034', '', '', '', '薇薇', '曹蒹葭', '模特', '', 2, '1995-09-24', 3, 72, 127, '88/88/88', 'C', '江西', '深圳', '/upload/user/avatar/139-1503131F955.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-04/581c25d50ba3d.jpg";i:1;s:48:"/upload/user/images/2016-11-04/581c25d5142cf.jpg";}', '/upload/user/video/2016-11-07/58201cb2a0bcb.m4v', '/upload/user/video/2016-11-07/58201cb2a54b0.jpg', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-07 14:18:26', '2016-11-07 11:05:53', 114.0440445, 22.6315136, ''),
	(4, '18316629974', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1996-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/c7eafcd1e0650af.jpeg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0452423, 22.6445580, ''),
	(5, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1_b9dfb4fc8fe6e3f17ad199269eb21c4d_510.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.2445583, ''),
	(6, '18316629976', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/0325zfmv2544.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0643845, 22.1445580, ''),
	(7, '18316629977', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1456365636.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0452347, 22.2445583, ''),
	(8, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/1.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.4445572, ''),
	(9, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/2.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.3445587, ''),
	(10, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1990-08-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/3.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.6445580, ''),
	(11, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1990-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/4.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.7445583, ''),
	(12, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1991-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/5.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.8445587, ''),
	(13, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/6.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.9445572, ''),
	(14, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/7.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.3445587, ''),
	(15, '18316629975', '$2y$10$vujUd/b41xBz9FvBTUhIke.ElEuXt7URpb79hzgx6SG5InBmNoARi', '04d6ad7bbeca1fe8d035', '', '', '', '薇小萌', '曹小萌', '模特', '', 2, '1993-09-24', 3, 72, 127, '88/88/88', 'C', '云南', '深圳', '/upload/user/avatar/8.jpg', 1, '2016深圳小姐冠军', '酒吧', '牛排', '《滑板鞋》', '《7月与安生》', '跳皮筋', '宁愿在宝马里哭，也不要在自行车上笑', '12315', 0, 3, 1, '', '', '', '', 'a:2:{i:0;s:48:"/upload/user/images/2016-11-03/581b0927c2087.jpg";i:1;s:48:"/upload/user/images/2016-11-03/581b0927c76e1.jpg";}', '', '', 0, 'weixin', '2016-10-31 14:44:51', '2016-11-03 17:53:43', '2016-11-02 16:52:30', 114.0440445, 22.7445583, '');
/*!40000 ALTER TABLE `lm_user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
