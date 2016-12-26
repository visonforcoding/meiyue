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

-- 导出  表 meiyue.lm_gift 结构
DROP TABLE IF EXISTS `lm_gift`;
CREATE TABLE IF NOT EXISTS `lm_gift` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '0' COMMENT '礼物价格',
  `name` varchar(50) DEFAULT NULL COMMENT '礼物名称',
  `no` tinyint(4) NOT NULL COMMENT '礼物编号',
  `pic` varchar(50) NOT NULL COMMENT '礼物图片',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注说明',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼物表';

-- 正在导出表  meiyue.lm_gift 的数据：~8 rows (大约)
DELETE FROM `lm_gift`;
/*!40000 ALTER TABLE `lm_gift` DISABLE KEYS */;
INSERT INTO `lm_gift` (`id`, `price`, `name`, `no`, `pic`, `remark`) VALUES
	(1, 131.4, 'roseonly', 8, '/upload/gift/gift04.png', 'roseonly'),
	(2, 210, '海洋之心', 1, '/upload/gift/gift05.png', '海洋之心'),
	(3, 520, '跑车', 3, '/upload/gift/gift06.png', '跑车'),
	(4, 52, '巧克力雨', 5, '/upload/gift/gift03.png', '巧克力雨'),
	(5, 20, '怦然心动', 4, '/upload/gift/gift02.png', '怦然心动'),
	(7, 5, '飞吻', 7, '/upload/gift/gift01.png', '飞吻'),
	(8, 999, '豪华游轮', 6, '/upload/gift/gift07.png', '豪华游轮'),
	(9, 5000, '梦幻城堡', 2, '/upload/gift/gift08.png', '梦幻城堡');
/*!40000 ALTER TABLE `lm_gift` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
