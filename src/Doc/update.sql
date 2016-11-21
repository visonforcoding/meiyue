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


##20161110
CREATE TABLE `lm_dateorder` (
	`id` INT(255) NOT NULL AUTO_INCREMENT,
	`dater_name` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '服务提供者姓名',
	`consumer` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '消费者姓名',
	`date_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应约会',
	`dater_id` INT(11) NOT NULL DEFAULT '0' COMMENT '服务提供者',
	`user_skill_id` INT(11) NOT NULL COMMENT '标签列表',
	`created_time` DATETIME NOT NULL COMMENT '生成时间',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败',
	`update_time` DATETIME NOT NULL COMMENT '订单更新时间',
	`operate_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单',
	`site` VARCHAR(50) NOT NULL COMMENT '约会地点',
	`consumer_id` INT(11) NOT NULL DEFAULT '0' COMMENT '消费者',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '价格',
	`count` DOUBLE NOT NULL DEFAULT '0' COMMENT '总金额',
	`is_complain` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '是否被投诉',
	`pre_pay` DOUBLE NOT NULL DEFAULT '0' COMMENT '预约金',
	`pre_precent` FLOAT NOT NULL DEFAULT '0' COMMENT '预约金占比',
	`start_time` DATETIME NOT NULL COMMENT '开始时间',
	`end_time` DATETIME NOT NULL COMMENT '结束时间',
	`date_time` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '约会总时间',
	PRIMARY KEY (`id`)
)
COMMENT='约单表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `lm_flow` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL COMMENT '收款方',
	`consumer_id` INT(11) NOT NULL COMMENT '支付方',
	`relate_id` INT(11) NOT NULL COMMENT '关联表，与type交易类型一起使用',
	`type` INT(11) NOT NULL COMMENT '交易类型：1#约单交易',
	`income` TINYINT(4) NOT NULL COMMENT '收支类型：1#收入 2#支出',
	`amount` DOUBLE NOT NULL COMMENT '金额',
	`remark` VARCHAR(255) NOT NULL COMMENT '备注',
	`pre_amount` DOUBLE NOT NULL COMMENT '交易前金额',
	`after_amount` DOUBLE NOT NULL COMMENT '交易后金额',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	PRIMARY KEY (`id`)
)
COMMENT='美币收支表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `lm_date` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_skill_id` INT(11) NULL DEFAULT '0' COMMENT '对应用户录入的技能列表',
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '约会标题',
	`start_time` DATETIME NOT NULL COMMENT '约会开始时间',
	`site` VARCHAR(255) NOT NULL DEFAULT '0' COMMENT '约会地点',
	`site_lat` FLOAT NOT NULL DEFAULT '0' COMMENT '约会地点纬度',
	`site_lng` FLOAT NOT NULL DEFAULT '0' COMMENT '约会地点经度',
	`end_time` DATETIME NOT NULL COMMENT '约会结束时间',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '约会价格',
	`description` VARCHAR(255) NULL DEFAULT '0' COMMENT '约会说明',
	`status` TINYINT(4) NOT NULL DEFAULT '2' COMMENT '状态：1#已有人赴约 2#未有人赴约 3#已下线',
	`user_id` INT(11) NOT NULL COMMENT '对应美女id',
	`created_time` DATETIME NOT NULL COMMENT '上线时间',
	PRIMARY KEY (`id`)
)
COMMENT='约会表（美女发布的约会）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=21
;


CREATE TABLE `lm_dateorder` (
	`id` INT(255) NOT NULL AUTO_INCREMENT,
	`dater_name` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '服务提供者姓名',
	`consumer` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '消费者姓名',
	`date_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应约会',
	`dater_id` INT(11) NOT NULL DEFAULT '0' COMMENT '服务提供者',
	`user_skill_id` INT(11) NOT NULL COMMENT '标签列表',
	`created_time` DATETIME NOT NULL COMMENT '生成时间',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败',
	`update_time` DATETIME NOT NULL COMMENT '订单更新时间',
	`operate_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单',
	`site` VARCHAR(50) NOT NULL COMMENT '约会地点',
	`site_lat` FLOAT NOT NULL COMMENT '约会地点纬度',
	`site_lng` FLOAT NOT NULL COMMENT '约会地点经度',
	`consumer_id` INT(11) NOT NULL DEFAULT '0' COMMENT '消费者',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '价格',
	`count` DOUBLE NOT NULL DEFAULT '0' COMMENT '总金额',
	`is_complain` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '是否被投诉',
	`pre_pay` DOUBLE NOT NULL DEFAULT '0' COMMENT '预约金',
	`pre_precent` FLOAT NOT NULL DEFAULT '0' COMMENT '预约金占比',
	`start_time` DATETIME NOT NULL COMMENT '开始时间',
	`end_time` DATETIME NOT NULL COMMENT '结束时间',
	`date_time` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '约会总时间',
	PRIMARY KEY (`id`)
)
COMMENT='约单表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;






##20161111
CREATE TABLE `lm_activity` (
	`id` INT(11) NOT NULL,
	`big_img` VARCHAR(50) NOT NULL COMMENT '大图url',
	`title` VARCHAR(50) NOT NULL COMMENT '标题',
	`male_price` DOUBLE NOT NULL DEFAULT '0' COMMENT '男性价格',
	`female_price` DOUBLE NOT NULL DEFAULT '0' COMMENT '女性价格',
	`description` VARCHAR(50) NOT NULL COMMENT '描述',
	`start_time` DATETIME NOT NULL COMMENT '开始时间',
	`end_time` DATETIME NOT NULL COMMENT '结束时间',
	`site` VARCHAR(50) NOT NULL COMMENT '活动地址',
	`site_lat` FLOAT NOT NULL COMMENT '地址纬度',
	`site_lng` FLOAT NOT NULL COMMENT '地址经度',
	`male_lim` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '活动男性名额',
	`female_lim` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '活动女性名额',
	`male_rest` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '男性剩余名额',
	`female_rest` SMALLINT(6) NULL DEFAULT '0' COMMENT '女性剩余名额',
	`detail` TEXT NOT NULL COMMENT '图文详情',
	`notice` VARCHAR(255) NOT NULL COMMENT '活动须知',
	`status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '活动状态：1#正常进行 2#异常取消',
	`remark` VARCHAR(255) NOT NULL COMMENT '备注',
	PRIMARY KEY (`id`)
)
COMMENT='活动派对表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `lm_actregistration` (
	`id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL COMMENT '用户id',
	`activity_id` INT(11) NOT NULL COMMENT '活动id',
	`status` TINYINT(4) NOT NULL COMMENT '报名状态：1#正常 2#取消',
	`cost` DOUBLE NOT NULL COMMENT '报名费用',
	`punish` DOUBLE NOT NULL COMMENT '取消报名惩罚金额',
	`punish_percent` FLOAT NOT NULL COMMENT '惩罚金占报名费百分比',
	`create_time` DATETIME NOT NULL COMMENT '报名时间',
	`cancel_time` DATETIME NOT NULL COMMENT '取消报名时间',
	`update_time` DATETIME NOT NULL COMMENT '更新时间，包括管理员操作',
	PRIMARY KEY (`id`)
)
COMMENT='活动报名表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


-- #2016-11-14

-- 流水表更改
CREATE TABLE `lm_flow` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '收款方',
	`buyer_id` INT(11) NOT NULL DEFAULT '0' COMMENT '支付方',
	`relate_id` INT(11) NOT NULL DEFAULT '0' COMMENT '关联id',
	`type` INT(11) NOT NULL DEFAULT '0' COMMENT '交易类型',
	`type_msg` VARCHAR(50) NOT NULL COMMENT '类型名称',
	`income` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '是否收入1:收入2:支出',
	`amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
	`price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
	`pre_amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易前金额',
	`after_amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '交易后金额',
	`paytype` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '支付方式',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '交易状态',
	`remark` VARCHAR(50) NOT NULL COMMENT '备注',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	`update_time` DATETIME NOT NULL COMMENT '修改时间',
	PRIMARY KEY (`id`)
)
COMMENT='用户资金流水'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;


-- 预约单表
CREATE TABLE `lm_dateorder` (
	`id` INT(255) NOT NULL AUTO_INCREMENT,
	`consumer_id` INT(11) NOT NULL DEFAULT '0' COMMENT '男方',
	`consumer` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '消费者姓名',
	`dater_id` INT(11) NOT NULL DEFAULT '0' COMMENT '女方',
	`dater_name` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '服务提供者姓名',
	`date_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对应约会',
	`user_skill_id` INT(11) NOT NULL COMMENT '用户技能id',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态码： 1#消费者未支付预约金 2#消费者超时未支付预约金，订单取消 3#消费者已支付预约金 4#消费者取消订单 5#受邀者拒绝约单 6#受邀者超时未响应，自动退单 7#受邀者确认约单 8#受邀者取消订单 9#消费者超时未付尾款 10#消费者已支付尾款 11#消费者退单 12#受邀者退单 13#受邀者确认到达 14#订单完成 15#已评价 16#订单失败',
	`operate_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '用户操作状态码：0#无操作 1#消费者删除订单 2#被约者删除订单 3#双方删除订单',
	`site` VARCHAR(50) NOT NULL COMMENT '约会地点',
	`site_lat` FLOAT NOT NULL COMMENT '约会地点纬度',
	`site_lng` FLOAT NOT NULL COMMENT '约会地点经度',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '价格',
	`amount` DOUBLE NOT NULL DEFAULT '0' COMMENT '总金额',
	`is_complain` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '是否被投诉',
	`pre_pay` DOUBLE NOT NULL DEFAULT '0' COMMENT '预约金',
	`pre_precent` FLOAT NOT NULL DEFAULT '0' COMMENT '预约金占比',
	`start_time` DATETIME NOT NULL COMMENT '开始时间',
	`end_time` DATETIME NOT NULL COMMENT '结束时间',
	`date_time` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '约会总时间',
	`create_time` DATETIME NOT NULL COMMENT '生成时间',
	`update_time` DATETIME NOT NULL COMMENT '订单更新时间',
	PRIMARY KEY (`id`)
)
COMMENT='约单表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;

##20161116
CREATE TABLE `lm_actregistration` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL COMMENT '用户id',
	`activity_id` INT(11) NOT NULL COMMENT '活动id',
	`status` TINYINT(4) NOT NULL COMMENT '报名状态：1#正常 2#取消 3#未付款',
	`cost` DOUBLE NOT NULL COMMENT '报名费用',
	`punish` DOUBLE NOT NULL COMMENT '取消报名惩罚金额',
	`punish_percent` TINYINT(4) NOT NULL COMMENT '惩罚金占报名费百分比',
	`create_time` DATETIME NOT NULL COMMENT '报名时间',
	`cancel_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '取消报名时间',
	`update_time` DATETIME NOT NULL COMMENT '更新时间，包括管理员操作',
	`num` SMALLINT(6) NOT NULL DEFAULT '1' COMMENT '购买数量',
	PRIMARY KEY (`id`)
)
COMMENT='活动报名表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=25
;


CREATE TABLE `lm_activity` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`big_img` VARCHAR(50) NOT NULL COMMENT '封面图',
	`title` VARCHAR(50) NOT NULL COMMENT '标题',
	`male_price` DOUBLE NOT NULL DEFAULT '0' COMMENT '男性价格',
	`female_price` DOUBLE NOT NULL DEFAULT '0' COMMENT '女性价格',
	`description` VARCHAR(50) NOT NULL COMMENT '描述',
	`ad` VARCHAR(50) NULL DEFAULT NULL COMMENT '宣传语',
	`start_time` DATETIME NOT NULL COMMENT '开始时间',
	`end_time` DATETIME NOT NULL COMMENT '结束时间',
	`site` VARCHAR(50) NOT NULL COMMENT '活动地址',
	`site_lat` FLOAT NOT NULL COMMENT '地址纬度',
	`site_lng` FLOAT NOT NULL COMMENT '地址经度',
	`male_lim` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '活动男性名额',
	`female_lim` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '活动女性名额',
	`male_rest` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '男性剩余名额',
	`female_rest` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '女性剩余名额',
	`detail` TEXT NULL COMMENT '图文详情',
	`notice` VARCHAR(255) NOT NULL COMMENT '活动须知',
	`status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '活动状态：1#正常进行 2#下架处理',
	`remark` VARCHAR(255) NOT NULL COMMENT '备注',
	`punish_percent` TINYINT(4) NULL DEFAULT '0' COMMENT '惩罚比例',
	PRIMARY KEY (`id`)
)
COMMENT='活动派对表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

#user表添加唯一索引
ALTER TABLE `lm_user`
	ADD UNIQUE INDEX `phone` (`phone`);
#充值总额记录字段
ALTER TABLE `lm_user`
	ADD COLUMN `recharge` FLOAT NULL DEFAULT '0' COMMENT '充值总额' AFTER `video_cover`;


##20161121
ALTER TABLE `lm_user`
	ADD COLUMN `wx_ishow` TINYINT NOT NULL DEFAULT '1' COMMENT '微信是否显示: 1#显示 2#不显示' AFTER `device`,
	DROP COLUMN `wx_ishow`;
SELECT `DEFAULT_COLLATION_NAME` FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME`='meiyue';