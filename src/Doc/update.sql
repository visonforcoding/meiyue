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