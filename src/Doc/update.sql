CREATE TABLE `lm_smsmsg` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`phone` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '手机号',
	`code` VARCHAR(50) NULL DEFAULT NULL COMMENT '验证码',
	`content` VARCHAR(250) NULL DEFAULT NULL COMMENT '内容',
	`expire_time` INT(11) NULL DEFAULT NULL COMMENT '过期时间',
	`create_time` DATETIME NULL DEFAULT NULL COMMENT '创建时间',
	PRIMARY KEY (`id`)
)
COMMENT='短信记录'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=19
;


CREATE TABLE `lm_costs` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`money` DOUBLE NOT NULL DEFAULT '0' COMMENT '价格',
	PRIMARY KEY (`id`)
)
COMMENT='价格管理'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;


CREATE TABLE `lm_dates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`skill_id` INT(11) NULL DEFAULT '0' COMMENT '对应管理员录入的技能列表',
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
	`start_time` DATETIME NOT NULL COMMENT '约会开始时间',
	`site` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
	`end_time` DATETIME NOT NULL COMMENT '约会结束时间',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '约会价格',
	`desc` VARCHAR(255) NULL DEFAULT '0' COMMENT '约会说明',
	PRIMARY KEY (`id`)
)
COMMENT='约会表（美女发布的约会）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `lm_dates_tags` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`date_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应约会id',
	`tag_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应标签id',
	PRIMARY KEY (`id`)
)
COMMENT='约会-标签中间表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `lm_skills` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COMMENT '技能名称',
	`parent_id` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COMMENT='技能表（管理员创建）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=12
;


CREATE TABLE `lm_tags` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COMMENT '标签名',
	`parent_id` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COMMENT='标签表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=18
;


CREATE TABLE `lm_user_skills` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`skill_id` INT(11) NOT NULL COMMENT '对应管理员录入的名称',
	`cost_id` INT(11) NOT NULL COMMENT '对应管理员录入的费用',
	`desc` VARCHAR(200) NOT NULL COMMENT '约会说明',
	`is_used` TINYINT(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
	`is_checked` TINYINT(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
	PRIMARY KEY (`id`)
)
COMMENT='用户技能表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;

CREATE TABLE `lm_user_skills_tags` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_skill_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应的用户技能表',
	`tag_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应用户标签表',
	PRIMARY KEY (`id`)
)
COMMENT='用户技能-标签中间表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

#2016-11-03

#用户表  在导入之前 需要先drop 掉该表
CREATE TABLE `lm_user` (
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '用户表',
	`phone` VARCHAR(20) NOT NULL COMMENT '手机号',
	`pwd` VARCHAR(120) NOT NULL COMMENT '密码',
	`user_token` VARCHAR(20) NOT NULL COMMENT '用户标志',
	`union_id` VARCHAR(100) NULL DEFAULT '' COMMENT 'wx_unionid',
	`wx_openid` VARCHAR(100) NULL DEFAULT '' COMMENT '微信的openid',
	`app_wx_openid` VARCHAR(100) NULL DEFAULT '' COMMENT 'app端的微信id',
	`nick` VARCHAR(20) NULL DEFAULT '' COMMENT '昵称',
	`truename` VARCHAR(20) NULL DEFAULT '' COMMENT '真实姓名',
	`profession` VARCHAR(20) NULL DEFAULT '' COMMENT '职业',
	`email` VARCHAR(50) NULL DEFAULT '' COMMENT '邮箱',
	`gender` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1,男，2女',
	`birthday` DATE NULL DEFAULT NULL COMMENT '生日',
	`zodiac` TINYINT(4) NULL DEFAULT '0' COMMENT '星座',
	`weight` TINYINT(4) NULL DEFAULT '0' COMMENT '体重(KG)',
	`height` TINYINT(4) NULL DEFAULT '0' COMMENT '身高(cm)',
	`bwh` VARCHAR(30) NULL DEFAULT '' COMMENT '三围',
	`cup` VARCHAR(20) NULL DEFAULT '' COMMENT '罩杯',
	`hometown` VARCHAR(20) NULL DEFAULT '' COMMENT '家乡',
	`city` VARCHAR(50) NULL DEFAULT '' COMMENT '常驻城市',
	`avatar` VARCHAR(250) NULL DEFAULT '' COMMENT '头像',
	`state` TINYINT(4) NULL DEFAULT '1' COMMENT '情感状态',
	`career` VARCHAR(100) NULL DEFAULT '' COMMENT '工作经历',
	`place` VARCHAR(100) NULL DEFAULT '' COMMENT '常出没地',
	`food` VARCHAR(20) NULL DEFAULT '' COMMENT '最喜欢美食',
	`music` VARCHAR(20) NULL DEFAULT '' COMMENT '音乐',
	`movie` VARCHAR(20) NULL DEFAULT '' COMMENT '电影',
	`sport` VARCHAR(20) NULL DEFAULT '' COMMENT '运动',
	`sign` VARCHAR(120) NULL DEFAULT '' COMMENT '个性签名',
	`wxid` VARCHAR(50) NULL DEFAULT '' COMMENT '微信号',
	`money` INT(11) NOT NULL DEFAULT '0' COMMENT '账户余额(美币)',
	`status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '审核状态1待审核2审核不通过3审核通过',
	`enabled` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '账号状态 ：1.可用0禁用(控制登录)',
	`idpath` VARCHAR(250) NULL DEFAULT '' COMMENT '身份证路径',
	`idfront` VARCHAR(250) NULL DEFAULT '' COMMENT '身份证正面照',
	`idback` VARCHAR(250) NULL DEFAULT '' COMMENT '身份证背面照',
	`idperson` VARCHAR(250) NULL DEFAULT '' COMMENT '手持身份照',
	`images` TEXT NULL COMMENT '基本照片',
	`video` VARCHAR(250) NULL DEFAULT '' COMMENT '基本视频',
	`is_del` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否假删除：1,是0否',
	`device` VARCHAR(50) NOT NULL DEFAULT 'app' COMMENT '注册设备',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	`update_time` DATETIME NULL DEFAULT NULL COMMENT '修改时间',
	`login_time` DATETIME NULL DEFAULT NULL COMMENT '上次登陆时间',
	`login_coord` VARCHAR(100) NULL DEFAULT '' COMMENT '上次登录坐标',
	`guid` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '唯一码（用于扫码登录）',
	PRIMARY KEY (`id`)
)
COMMENT='用户表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=4
;


CREATE TABLE `lm_dates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`skill_id` INT(11) NULL DEFAULT '0' COMMENT '对应管理员录入的技能列表',
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
	`start_time` DATETIME NOT NULL COMMENT '约会开始时间',
	`site` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
	`end_time` DATETIME NOT NULL COMMENT '约会结束时间',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '约会价格',
	`description` VARCHAR(255) NULL DEFAULT '0' COMMENT '约会说明',
	PRIMARY KEY (`id`)
)
COMMENT='约会表（美女发布的约会）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=10
;


ALTER TABLE `lm_user`
	CHANGE COLUMN `login_coord` `login_coord_lng` FLOAT NULL DEFAULT '0' COMMENT '上次登录坐标' AFTER `login_time`,
	ADD COLUMN `login_coord_lat` FLOAT NULL DEFAULT '0' AFTER `login_coord_lng`;


#自定义函数 获取2点距离
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


##2016/11/4
CREATE TABLE `lm_dates` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`skill_id` INT(11) NULL DEFAULT '0' COMMENT '对应管理员录入的技能列表',
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
	`start_time` DATETIME NOT NULL COMMENT '约会开始时间',
	`site` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
	`end_time` DATETIME NOT NULL COMMENT '约会结束时间',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '约会价格',
	`description` VARCHAR(255) NULL DEFAULT '0' COMMENT '约会说明',
	`status` TINYINT(4) NOT NULL DEFAULT '2' COMMENT '状态：1#已有人赴约 2#未有人赴约 3#已下线',
	`user_id` INT(11) NOT NULL COMMENT '对应美女id',
	PRIMARY KEY (`id`)
)
COMMENT='约会表（美女发布的约会）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=16
;

