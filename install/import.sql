CREATE TABLE `page_server` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `server_name` varchar(64) NOT NULL COMMENT '服务器名称',
  `ip` varchar(20) NOT NULL DEFAULT '0.0.0.0' COMMENT 'IP地址',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '服务器状态标记',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_ip` (`ip`),
  UNIQUE KEY `unq_name` (`server_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5011 DEFAULT CHARSET=utf8 COMMENT='服务器列表';

CREATE TABLE `page_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `website` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sms_alert_switch` tinyint(1) DEFAULT '1' COMMENT '是否开启短信报警',
  `crash_sever_cron_switch` tinyint(1) DEFAULT '0' COMMENT 'server挂掉之后是否自动切换',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `page_crontab` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `timer` varchar(128) NOT NULL DEFAULT '' COMMENT '定时器',
  `exec_file` varchar(255) NOT NULL COMMENT '可执行文件的绝对路径',
  `args` text NOT NULL COMMENT '命令参数',
  `redirect` varchar(255) NOT NULL DEFAULT '' COMMENT '重定向文件',
  `timeout` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '程序最长执行时间(秒), 0表示永远不超时',
  `server_id` int(11) NOT NULL DEFAULT '0' COMMENT 'serverid',
  `repeat_num` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许重启, 1允许, 0不允许',
  `timeout_kill_type` int(4) DEFAULT '0' COMMENT '超时之后的重启方式0为温柔的重启, 1为强制重启',
  `exit_code` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退出码,0表示正常退出',
  `process_restart_type` varchar(50) DEFAULT NULL COMMENT '手动杀死进程之后的重启方式',
  `start_time` bigint(20) DEFAULT '0' COMMENT '开始时间（精确至毫秒）',
  `finish_time` bigint(20) DEFAULT '0' COMMENT '结束时间(精确到毫秒)',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '有值表示删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='计划任务配置';

INSERT INTO `page_config` (`id`, `website`, `name`, `sms_alert_switch`, `crash_sever_cron_switch`, `create_time`, `update_time`)
VALUES
	(1, 'http://cron.weibo.com:8716', 'page团队cron调度系统', 0, 0, '2017-11-05 10:06:00', '2017-11-05 10:20:32');


