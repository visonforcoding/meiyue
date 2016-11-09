-- #数据库表名更改：
-- lm_costs => lm_cost
-- lm_dates => lm_date
-- lm_dates_tags => lm_date_tag
-- lm_skills => lm_skill
-- lm_tags => lm_tag
-- lm_user_skills => lm_user_skill
-- lm_user_skills_tags => lm_user_skill_tag

-- 新增美女-土豪关系表 对应 土豪对美女的关注 和 美女对土豪的喜欢
CREATE TABLE `lm_user_fans` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL COMMENT '关注者',
	`following_id` INT(11) NOT NULL COMMENT '被关注者',
	`type` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1,单向关注2互为关注',
	`create_time` DATETIME NOT NULL,
	`update_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='用户关系表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

##20161109
CREATE TABLE `lm_tag` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COMMENT '标签名',
	`parent_id` INT(11) NOT NULL DEFAULT '0',
	`type` INT(11) NULL DEFAULT '0' COMMENT '标签类别： 0#未分类 1#技能标签 2#个人标签',
	PRIMARY KEY (`id`)
)
COMMENT='标签表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=18
;

CREATE TABLE `lm_user_skill` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`skill_id` INT(11) NOT NULL COMMENT '对应管理员录入的名称',
	`cost_id` INT(11) NOT NULL COMMENT '对应管理员录入的费用',
	`description` VARCHAR(200) NOT NULL COMMENT '约会说明',
	`is_used` TINYINT(2) NOT NULL DEFAULT '1' COMMENT '启用状态0/1',
	`is_checked` TINYINT(2) NOT NULL DEFAULT '2' COMMENT '审核状态[0不通过][1通过][2未审核]',
	`user_id` INT(11) NOT NULL COMMENT '对应user',
	PRIMARY KEY (`id`)
)
COMMENT='用户技能表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=9
;


CREATE TABLE `lm_date` (
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
	`created_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上线时间',
	PRIMARY KEY (`id`)
)
COMMENT='约会表（美女发布的约会）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=16
;

CREATE TABLE `lm_skill` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COMMENT '技能名称',
	`parent_id` INT(11) NOT NULL DEFAULT '0',
	`is_shown` TINYINT(4) NULL DEFAULT '0' COMMENT '是否显示在‘发现’筛选列表中',
	`shown_order` TINYINT(4) NULL DEFAULT '0' COMMENT '显示顺序',
	PRIMARY KEY (`id`)
)
COMMENT='技能表（管理员创建）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=12
;


