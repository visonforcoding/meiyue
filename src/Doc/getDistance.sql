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
CREATE DATABASE IF NOT EXISTS `meiyue` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `meiyue`;

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

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
