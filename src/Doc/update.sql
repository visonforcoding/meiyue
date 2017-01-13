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


#增加日志记录表
CREATE TABLE `lm_log` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`flag` VARCHAR(50) NOT NULL DEFAULT '',
	`msg` VARCHAR(550) NOT NULL DEFAULT '',
	`data` TEXT NULL,
	`create_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='重要的信息日志记录'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

#约会单增加2个时间点
ALTER TABLE `lm_dateorder`
	ADD COLUMN `prepay_time` DATETIME NOT NULL COMMENT '支付预约金时间点' AFTER `date_time`,
	ADD COLUMN `receive_time` DATETIME NOT NULL COMMENT '美女接单时间点' AFTER `prepay_time`;



##20161121
ALTER TABLE `lm_user`
	ADD COLUMN `wx_ishow` TINYINT NOT NULL DEFAULT '1' COMMENT '微信是否显示: 1#显示 2#不显示' AFTER `device`,



##20161122
CREATE TABLE `lm_gift` (
	`id` INT(11) NOT NULL,
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '礼物价格',
	`name` VARCHAR(50) NULL DEFAULT NULL COMMENT '礼物名称',
	`pic` VARCHAR(50) NOT NULL COMMENT '礼物图片',
	`remark` VARCHAR(255) NULL DEFAULT NULL COMMENT '备注说明',
	PRIMARY KEY (`id`)
)
COMMENT='礼物表'
ENGINE=InnoDB
;

##20161123
CREATE TABLE `lm_support` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`supporter_id` INT(11) NOT NULL DEFAULT '0' COMMENT '支持者id',
	`supported_id` INT(11) NOT NULL DEFAULT '0' COMMENT '被支持者id',
	`gift_id` INT(11) NOT NULL DEFAULT '0' COMMENT '礼物id',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
	PRIMARY KEY (`id`)
)
COMMENT='支持列表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=5
;

##20161124
CREATE TABLE `lm_package` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '套餐名称',
	`type` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '套餐类型：1#vip套餐 2#充值套餐 3#其他套餐',
	`chat_num` INT(11) NOT NULL DEFAULT '0' COMMENT '美女聊天名额',
	`browse_num` INT(11) NOT NULL DEFAULT '0' COMMENT '查看动态名额',
	`vir_money` DOUBLE NOT NULL DEFAULT '0' COMMENT '美币数量',
	`price` DOUBLE NOT NULL DEFAULT '0' COMMENT '价格',
	`stock` INT(11) NOT NULL DEFAULT '0' COMMENT '库存',
	`vali_time` INT(11) NULL DEFAULT '0' COMMENT '有效期（单位:天）：-1表示无限',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建日期',
	`update_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改日期',
	`show_order` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '显示顺序',
	`is_used` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '是否启用：1#启用 0#禁用',
	PRIMARY KEY (`id`)
)
COMMENT='套餐表（包括vip、充值、其他等）'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=9
;


CREATE TABLE `lm_user_package` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL DEFAULT '0' COMMENT '套餐名称',
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '用户id',
	`package_id` INT(11) NOT NULL DEFAULT '0' COMMENT '套餐id',
	`chat_num` INT(11) NOT NULL DEFAULT '0' COMMENT '美女聊天名额',
	`rest_chat` INT(11) NOT NULL DEFAULT '0' COMMENT '剩余聊天名额',
	`browse_num` INT(11) NOT NULL DEFAULT '0' COMMENT '查看动态名额',
	`rest_browse` INT(11) NOT NULL DEFAULT '0' COMMENT '剩余查看动态名额',
	`type` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '套餐类型：1#vip套餐 2#充值套餐 3#其他套餐',
	`cost` DOUBLE NOT NULL DEFAULT '0' COMMENT '购买价格',
	`vir_money` DOUBLE NOT NULL DEFAULT '0' COMMENT '美币面额',
	`deathline` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '失效时间',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '购买时间',
	PRIMARY KEY (`id`)
)
COMMENT='用户-套餐购买记录表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


CREATE TABLE `lm_used_package` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '使用者id',
	`used_id` INT(11) NOT NULL DEFAULT '0' COMMENT '作用对象id',
	`package_id` INT(11) NOT NULL DEFAULT '0' COMMENT '所购买的套餐id',
	`type` INT(11) NOT NULL DEFAULT '0' COMMENT '消费类型：1#查看动态服务 2#聊天服务',
	`deadline` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '该消费有效期',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用日期',
	PRIMARY KEY (`id`)
)
COMMENT='用户使用套餐情况表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

##支付订单 对接支付宝和微信
CREATE TABLE `lm_payorder` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`type` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '订单类型1约见',
	`relate_id` INT(11) NOT NULL DEFAULT '0' COMMENT '关联id',
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '用户id(买家id)',
	`seller_id` INT(11) NOT NULL DEFAULT '0' COMMENT '卖家id',
	`title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '订单标题',
	`order_no` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '订单号',
	`out_trade_no` VARCHAR(50) NULL DEFAULT '' COMMENT '支付方的订单号',
	`paytype` TINYINT(4) NULL DEFAULT '0' COMMENT '实际支付方式：1微信2支付宝',
	`price` DECIMAL(10,2) NOT NULL COMMENT '定价',
	`fee` DECIMAL(10,2) NOT NULL COMMENT '实际支付',
	`remark` VARCHAR(50) NOT NULL COMMENT '备注',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '订单状态0未完成1已完成',
	`create_time` DATETIME NOT NULL,
	`update_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='支付订单表对接微信支付宝支付'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=108
;

##约拍管理表
CREATE TABLE `lm_yuepai` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`act_time` DATETIME NOT NULL COMMENT '约拍时间',
	`rest_num` SMALLINT(6) NOT NULL COMMENT '剩余名额',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '状态：1#正常 2#下架',
	PRIMARY KEY (`id`)
)
COMMENT='后台管理员添加的约拍表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=5
;

-- 动态表
CREATE TABLE `lm_movement` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '用户id',
	`type` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1:图片动态2.视频动态',
	`body` VARCHAR(550) NULL DEFAULT NULL COMMENT '动态内容',
	`images` TEXT NULL,
	`video` VARCHAR(250) NULL DEFAULT NULL,
	`video_cover` VARCHAR(250) NULL DEFAULT NULL,
	`view_nums` INT(11) NULL DEFAULT '0' COMMENT '查看数',
	`praise_nums` INT(11) NULL DEFAULT '0' COMMENT '点赞数',
	`status` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1待审核2审核通过3审核不通过',
	`create_time` DATETIME NOT NULL,
	`update_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='动态'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;


##约拍申请表
CREATE TABLE `lm_yuepai_user` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`yuepai_id` INT(11) NOT NULL COMMENT '约拍id',
	`user_id` INT(11) NOT NULL COMMENT '用户id',
	`name` VARCHAR(50) NOT NULL COMMENT '姓名',
	`phone` VARCHAR(50) NOT NULL COMMENT '手机号',
	`area` VARCHAR(50) NOT NULL COMMENT '所在地区',
	`checked` TINYINT(4) NOT NULL COMMENT '审核状态：1#审核通过 2#未审核 3#审核不通过',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	PRIMARY KEY (`id`)
)
COMMENT='约拍申请表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;


-- 2016-12-2
ALTER TABLE `lm_user`
	CHANGE COLUMN `status` `status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '审核状态1待审核2审核不通过3审核通过0不审核(男)' AFTER `money`;



CREATE TABLE `lm_withdraw` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '对象id',
	`admin_id` INT(11) NULL DEFAULT NULL,
	`amount` FLOAT NOT NULL DEFAULT '0' COMMENT '提现金额',
	`cardno` VARCHAR(50) NOT NULL COMMENT '银行卡号',
	`bank` VARCHAR(50) NOT NULL COMMENT '银行',
	`truename` VARCHAR(50) NOT NULL COMMENT '持卡人姓名',
	`fee` FLOAT NOT NULL DEFAULT '0' COMMENT '手续费',
	`remark` VARCHAR(200) NOT NULL DEFAULT '0' COMMENT '备注',
	`status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '状态,0未审核，1审核通过',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`update_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`)
)
COMMENT='提现表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
;

##动态点赞表
CREATE TABLE `lm_mvpraise` (
	`id` INT(11) NOT NULL,
	`movement_id` INT(11) NOT NULL COMMENT '动态id',
	`user_id` INT(11) NOT NULL COMMENT '用户id',
	`create_time` INT(11) NOT NULL COMMENT '点赞时间',
	PRIMARY KEY (`id`)
)
COMMENT='动态点赞表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;


##修改user
ALTER TABLE `lm_user`
	ADD COLUMN `imaccid` VARCHAR(150) NULL DEFAULT '' COMMENT '云信accid' AFTER `imtoken`,
	ADD UNIQUE INDEX `imaccid` (`imaccid`);
#大图轮播表
CREATE TABLE `lm_carousel` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NOT NULL,
	`position` TINYINT(4) NOT NULL COMMENT '轮播图位置',
	`to_url` VARCHAR(50) NOT NULL COMMENT '跳转链接',
	`url` VARCHAR(50) NOT NULL COMMENT '图片链接',
	`remark` VARCHAR(50) NOT NULL COMMENT '备注',
	`status` TINYINT(4) NOT NULL COMMENT '状态：1#正常 2#下架',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	`update_time` DATETIME NOT NULL COMMENT '修改时间',
	PRIMARY KEY (`id`)
)
COMMENT='轮播图表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;

#im 账号池
CREATE TABLE `lm_impool` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`accid` VARCHAR(50) NOT NULL,
	`token` VARCHAR(128) NOT NULL,
	`status` TINYINT(4) NOT NULL DEFAULT '0',
	`create_time` DATETIME NOT NULL,
	`update_time` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='im账号池'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;

#user表添加魅力值
ALTER TABLE `lm_user`
	ADD COLUMN `charm` FLOAT NULL DEFAULT '0' COMMENT '魅力值' AFTER `recharge`;

#技能表添加字段
ALTER TABLE `lm_skill`
	ADD COLUMN `class` VARCHAR(50) NOT NULL COMMENT '技能图标' AFTER `name`,
	ADD COLUMN `q_key` VARCHAR(50) NOT NULL COMMENT '地址关键字（多个关键字之间使用\'$\'隔开，最多10个关键字）' AFTER `class`,
	ADD COLUMN `poi_cls` VARCHAR(50) NOT NULL COMMENT 'POI分类' AFTER `q_key`,
	ADD COLUMN `is_shown` TINYINT NOT NULL DEFAULT '1' COMMENT '是否显示' AFTER `poi_cls`,
	ADD COLUMN `shown_order` SMALLINT NOT NULL DEFAULT '0' COMMENT '显示顺序，数值越小越靠前' AFTER `is_shown`;

#派对添加字段
ALTER TABLE `lm_activity`
	ADD COLUMN `cancelday` TINYINT NOT NULL DEFAULT '3' COMMENT '允许取消的时间必须早开始日期天数以上' AFTER `remark`;


#用户表添加字段
ALTER TABLE `lm_user`
	ADD COLUMN `consumed` FLOAT NULL DEFAULT '0' COMMENT '消费总额' AFTER `recharge`;

#约单表添加字段
ALTER TABLE `lm_dateorder`
	ADD COLUMN `is_read` TINYINT NOT NULL DEFAULT '0' COMMENT '是否已被阅读' AFTER `prepay_time`;
#订单删除
ALTER TABLE `lm_dateorder`
	ADD COLUMN `is_del` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0未删除1女性删除2男性删除3双方删除' AFTER `is_read`;
ALTER TABLE `lm_dateorder`
	CHANGE COLUMN `is_del` `is_del` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0未删除1男性2女性删除3双方删除' AFTER `is_read`;

#用户表添加字段
ALTER TABLE `lm_user`
	CHANGE COLUMN `status` `status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '审核状态1待审核2审核不通过3审核通过0不审核(男)' AFTER `money`,
	ADD COLUMN `id_status` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '身份认证状态：1#待审核 2#审核不通过 3#审核通过' AFTER `status`;

#订单删除
ALTER TABLE `lm_dateorder`
 ADD COLUMN `is_del` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0未删除1男性2女性删除3双方删除' AFTER `is_read`;
 
#提现表添加字段
ALTER TABLE `lm_withdraw`
	ADD COLUMN `type` TINYINT NOT NULL COMMENT '类型：1#支付宝2#银联' AFTER `cardno`;

#访客统计表
CREATE TABLE `lm_visitor` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`visitor_id` INT(11) NOT NULL DEFAULT '0' COMMENT '访客id',
	`visited_id` INT(11) NOT NULL DEFAULT '0' COMMENT '被访问者id',
	`create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
	`update_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最近访问时间',
	PRIMARY KEY (`id`)
)
COMMENT='访客统计'
ENGINE=InnoDB
;

#用户表添加访客数统计
ALTER TABLE `lm_user`
	ADD COLUMN `visitnum` INT NOT NULL DEFAULT '0' COMMENT '访客数' AFTER `charm`;

#提现表添加美币记录
ALTER TABLE `lm_withdraw`
	ADD COLUMN `viramount` FLOAT NOT NULL DEFAULT '0' COMMENT '兑换美币' AFTER `amount`;

#用户表添加邀请码
ALTER TABLE `lm_user`
	ADD COLUMN `invit_code` INT NULL COMMENT '邀请码' AFTER `imaccid`;

#用户表添加是否经纪人
ALTER TABLE `lm_user`
	ADD COLUMN `is_agent` TINYINT NOT NULL DEFAULT '1' COMMENT '是否是经纪人：1是2否' AFTER `invit_code`;




CREATE TABLE `report` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`type` TINYINT(4) NULL DEFAULT '1' COMMENT '举报类型',
	`user_id` INT(11) NULL DEFAULT NULL COMMENT '用户id',
	`create_time` DATETIME NULL DEFAULT NULL,
	`update_time` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='举报'
ENGINE=InnoDB
;


#邀请表添加获得佣金字段
ALTER TABLE `lm_invitation`
	ADD COLUMN `income` DOUBLE NOT NULL DEFAULT '0' COMMENT '获得佣金' AFTER `status`;

#平台消息表
CREATE TABLE `lm_ptmsg` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`towho` VARCHAR(50) NULL DEFAULT '1' COMMENT '推送对象：1#自定义 2#',
	`msg_type` TINYINT(4) NULL DEFAULT '1' COMMENT '消息类型',
	`title` VARCHAR(50) NOT NULL COMMENT '标题',
	`body` VARCHAR(255) NOT NULL COMMENT '内容',
	`to_url` VARCHAR(255) NOT NULL COMMENT '跳转链接',
	`create_time` DATETIME NOT NULL COMMENT '创建时间',
	`update_time` DATETIME NOT NULL COMMENT '最近修改时间',
	PRIMARY KEY (`id`)
)
COMMENT='平台消息'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=19
;

#平台消息推送表
CREATE TABLE `lm_msgpush` (
 `id` INT(11) NOT NULL AUTO_INCREMENT,
 `msg_id` INT(11) NOT NULL DEFAULT '0' COMMENT '消息id',
 `user_id` INT(11) NOT NULL DEFAULT '0' COMMENT '用户id',
 `is_read` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '是否已读：0#未读 1#已读',
 `is_del` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '是否删除：0#否 1#是',
 `create_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '发送时间',
 `update_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
 PRIMARY KEY (`id`)
)
COMMENT='消息推送表'
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=21
;


ALTER TABLE `lm_user`
	ALTER `user_token` DROP DEFAULT;
ALTER TABLE `lm_user`
	CHANGE COLUMN `user_token` `user_token` VARCHAR(32) NOT NULL COMMENT '用户标志' AFTER `pwd`;

#后台技能管理表
ALTER TABLE `lm_skill`
	CHANGE COLUMN `is_shown` `is_shown` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '是否显示在发现页' AFTER `poi_cls`,
	CHANGE COLUMN `shown_order` `shown_order` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT '在发现页显示顺序，数值越小越靠前' AFTER `is_shown`,
	CHANGE COLUMN `parent_id` `parent_id` INT(11) NOT NULL DEFAULT '0' COMMENT '上级id' AFTER `shown_order`,
	ADD COLUMN `order` INT(11) NOT NULL DEFAULT '0' COMMENT '顺序' AFTER `parent_id`;
