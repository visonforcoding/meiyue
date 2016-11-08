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

