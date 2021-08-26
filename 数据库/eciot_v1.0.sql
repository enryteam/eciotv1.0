
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------
--
-- 表的结构 `eciot_admin`
--

CREATE TABLE IF NOT EXISTS `eciot_admin` (
`admin_id` int(6) unsigned NOT NULL COMMENT '管理员id',
  `user_id` int(11) DEFAULT NULL COMMENT '学生id',
  `school_id` int(11) DEFAULT '1' COMMENT '学校id',
  `user_name` varchar(20) DEFAULT NULL COMMENT '用户名',
  `real_name` varchar(255) DEFAULT NULL COMMENT '真实姓名',
  `token` varchar(40) DEFAULT NULL COMMENT '登录token',
  `admin_role` smallint(1) NOT NULL COMMENT '用户角色，1是局方 2校方 3班主任 4教师 5 校医 6家长',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `sex` varchar(255) DEFAULT '未知' COMMENT '性别 1为男 2为女',
  `addr` varchar(255) DEFAULT NULL COMMENT '地址',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `openid` varchar(80) DEFAULT NULL COMMENT '公众号openid',
  `qq` varchar(255) DEFAULT NULL COMMENT 'QQ号码',
  `wechat` varchar(255) DEFAULT NULL COMMENT '微信号码',
  `ctime` varchar(15) DEFAULT NULL COMMENT '创建时间',
  `card_id` varchar(30) DEFAULT NULL COMMENT '身份证号',
  `is_del` varchar(255) DEFAULT '0' COMMENT '是否删除 0否1是',
  `photo` varchar(255) DEFAULT NULL COMMENT '近期照片',
  `status` varchar(255) DEFAULT '0',
  `gid` smallint(2) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员用户表';

--
-- 转存表中的数据 `eciot_admin`
--

INSERT INTO `eciot_admin` (`admin_id`, `user_id`, `school_id`, `user_name`, `real_name`, `token`, `admin_role`, `password`, `sex`, `addr`, `phone`, `openid`, `qq`, `wechat`, `ctime`, `card_id`, `is_del`, `photo`, `status`, `gid`) VALUES
(1, NULL, 1, 'admin', '管理员', 'c4ca4238a0b923820dcc509a6f75849b', 1, '081fc7c54fedf50b9decc9baa8a53d08', '男', '', '15866666666', NULL, '123', '321', '1494295556', '', '0', '', '0', 1);

-- --------------------------------------------------------

--
-- 表的结构 `eciot_admin_group`
--

CREATE TABLE IF NOT EXISTS `eciot_admin_group` (
`id` int(8) unsigned NOT NULL,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` mediumtext NOT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `remark` varchar(255) DEFAULT NULL COMMENT '说明'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户组表';

--
-- 转存表中的数据 `eciot_admin_group`
--

INSERT INTO `eciot_admin_group` (`id`, `title`, `status`, `rules`, `remark`) VALUES
(1, '管理员', 1, 'index::,terminal::,system::,logs::,dashboard::,workorder::,admininfo::edit,admininfo::change_pwd,terminal::terminal_index,gateway::index,product::index,protocol::index,protocol::drive_index,gateway::gateway_edit,product::edit,product::remove,product::nature,product::nature_edit,product::nature_remove,product::product_edit,product::ability,product::gateway_state,product::gateway_state_edit,product::gateway_state_remove,protocol::edit,protocol::protocol_remove,protocol::protocol_start,protocol::drive_edit,terminal::terminal_edit,terminal::terminal_remove,terminal::state_edit,terminal::terminal_synchro,building::index,system::roles_index,system::admin_index,system::department_index,system::user_index,building::edit,building::remove,system::log_index,system::department_edit,system::department_remove,system::user_edit,system::user_remove,system::admin_add,system::admin_remove,system::roles_add,system::roles_remove,logs::smsmsg,logs::mqttmsg,dashboard::device,dashboard::chart,dashboard::building,dashboard::device_open,dashboard::building_all,workorder::todo,workorder::done,workorder::warn,workorder::repair,workorder::flow,workorder::flow_edit,workorder::flow_remove,workorder::todo_lists', '总权限');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_admin_log`
--

CREATE TABLE IF NOT EXISTS `eciot_admin_log` (
`id` int(10) NOT NULL,
  `admin_id` int(10) DEFAULT NULL COMMENT '管理员id',
  `admin_name` varchar(200) DEFAULT NULL COMMENT '管理员名称',
  `loginip` varchar(200) DEFAULT NULL COMMENT '登录IP',
  `ctime` varchar(22) DEFAULT NULL COMMENT '登录时间',
  `action` varchar(255) DEFAULT NULL COMMENT '当前c::a',
  `content` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `eciot_admin_log`
--

INSERT INTO `eciot_admin_log` (`id`, `admin_id`, `admin_name`, `loginip`, `ctime`, `action`, `content`) VALUES
(1, 1, 'superadmin', '127.0.0.1', '2019-06-18 16:22:18', 'logs::smsmsg', '');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_admin_side_action`
--

CREATE TABLE IF NOT EXISTS `eciot_admin_side_action` (
`id` int(11) unsigned NOT NULL,
  `uid` varchar(50) DEFAULT NULL COMMENT '管理员ID',
  `controller` varchar(50) DEFAULT NULL COMMENT '控制器',
  `title` varchar(150) DEFAULT NULL COMMENT '控制器名称',
  `icon_img` varchar(150) DEFAULT NULL COMMENT '图标',
  `action` varchar(100) DEFAULT NULL COMMENT '方法名',
  `module` varchar(100) DEFAULT NULL COMMENT '控制器::方法名',
  `sore` int(10) DEFAULT '1' COMMENT '排序 越小越靠前',
  `fid` varchar(50) DEFAULT NULL COMMENT '父级ID',
  `is_show` int(1) DEFAULT '1' COMMENT '1 显示 ',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=1069 DEFAULT CHARSET=utf8 COMMENT='管理员后台 模块表';

--
-- 转存表中的数据 `eciot_admin_side_action`
--

INSERT INTO `eciot_admin_side_action` (`id`, `uid`, `controller`, `title`, `icon_img`, `action`, `module`, `sore`, `fid`, `is_show`, `status`) VALUES
(1, NULL, 'index', '首页', NULL, 'layui-icon-home', 'index::', 1, '1018', 0, 1),
(401, NULL, 'terminal', '设备管理', 'layui-icon-set', 'terminal_index', 'terminal::terminal_index', 3, '1018', 1, 1),
(602, NULL, 'system', '账号管理', 'layui-icon-user', 'admin_index', 'system::admin_index', 8, '1018', 1, 1),
(1016, NULL, 'gateway', '网关管理', 'layui-icon-senior', 'index', 'gateway::index', 0, '1018', 1, 1),
(1018, NULL, 'index', '控制台', NULL, 'layui-icon-home', 'index::', 1, '0', 1, 1),
(1002, NULL, 'product', '产品管理', 'layui-icon-templeate-1', 'index', 'product::index', 2, '1018', 1, 1),
(1003, NULL, 'protocol', '协议管理', 'layui-icon-list', 'index', 'protocol::index', 1, '1018', 1, 1),
(1026, NULL, 'gateway', '网关编辑', NULL, 'gateway_edit', 'gateway::gateway_edit', 0, '1018', 2, 1),
(1027, NULL, 'product', '产品编辑', NULL, 'edit', 'product::edit', 2, '1018', 2, 1),
(1028, NULL, 'product', '产品删除', NULL, 'remove', 'product::remove', 2, '1018', 2, 1),
(1029, NULL, 'product', '产品属性', NULL, 'nature', 'product::nature', 2, '1018', 2, 1),
(1030, NULL, 'product', '产品属性编辑', NULL, 'nature_edit', 'product::nature_edit', 2, '1018', 2, 1),
(1031, NULL, 'product', '产品属性删除', NULL, 'nature_remove', 'product::nature_remove', 2, '1018', 2, 1),
(1032, NULL, 'product', '脚本编辑页面', NULL, 'product_edit', 'product::product_edit', 2, '1018', 2, 1),
(1033, NULL, 'product', '产品功能', NULL, 'ability', 'product::ability', 2, '1018', 2, 1),
(1034, NULL, 'product', '产品事件', NULL, 'gateway_state', 'product::gateway_state', 2, '1018', 2, 1),
(1035, NULL, 'product', '产品事件编辑', NULL, 'gateway_state_edit', 'product::gateway_state_edit', 2, '1018', 2, 1),
(1036, NULL, 'product', '产品事件删除', NULL, 'gateway_state_remove', 'product::gateway_state_remove', 2, '1018', 2, 1),
(1037, NULL, 'protocol', '协议编辑', NULL, 'edit', 'protocol::edit', 1, '1018', 2, 1),
(1038, NULL, 'protocol', '协议删除', NULL, 'protocol_remove', 'protocol::protocol_remove', 1, '1018', 2, 1),
(1039, NULL, 'protocol', '协议禁用', NULL, 'protocol_start', 'protocol::protocol_start', 1, '1018', 2, 1),
(1046, NULL, 'system', '账号编辑', NULL, 'admin_add', 'system::admin_add', 8, '1018', 2, 1),
(1047, NULL, 'system', '账号删除', NULL, 'admin_remove', 'system::admin_remove', 8, '1018', 2, 1),
(1050, NULL, 'terminal', '设备编辑', NULL, 'terminal_edit', 'terminal::terminal_edit', 3, '1018', 2, 1),
(1051, NULL, 'terminal', '设备删除', NULL, 'terminal_remove', 'terminal::terminal_remove', 3, '1018', 2, 1),
(1052, NULL, 'terminal', '设备操作', NULL, 'state_edit', 'terminal::state_edit', 3, '1018', 2, 1),
(1053, NULL, 'terminal', '设备管理', NULL, 'terminal_synchro', 'terminal::terminal_synchro', 3, '1018', 2, 1),
(1068, NULL, 'admininfo', '资料编辑', NULL, 'edit', 'admininfo::edit', 2, '1018', 2, 1),
(1067, NULL, 'admininfo', '修改密码', NULL, 'change_pwd', 'admininfo::change_pwd', 1, '1018', 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `eciot_bmslogin`
--

CREATE TABLE IF NOT EXISTS `eciot_bmslogin` (
`id` int(11) NOT NULL COMMENT 'id',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `time` datetime DEFAULT NULL COMMENT '后台登录时间',
  `ip` varchar(20) DEFAULT NULL COMMENT '登录IP'
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='系统管理员登录记录';

--
-- 转存表中的数据 `eciot_bmslogin`
--

INSERT INTO `eciot_bmslogin` (`id`, `uid`, `time`, `ip`) VALUES
(1, 1, '2019-04-25 13:57:46', '180.110.209.202');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_gateway`
--

CREATE TABLE IF NOT EXISTS `eciot_gateway` (
`id` int(8) NOT NULL COMMENT '网关ID',
  `company_code` varchar(200) DEFAULT NULL COMMENT '所属企业代号',
  `project_code` varchar(200) DEFAULT NULL COMMENT '项目代号',
  `sn` varchar(100) NOT NULL COMMENT '网关编码',
  `type` varchar(100) NOT NULL COMMENT '网关类型',
  `client_id` varchar(100) NOT NULL COMMENT 'mqtt的client_id',
  `topic` varchar(100) NOT NULL COMMENT 'mqtt的topic',
  `up_topic` varchar(100) DEFAULT NULL COMMENT '上报topic',
  `is_reg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1未注册   2已注册',
  `ctime` varchar(22) DEFAULT NULL COMMENT '注册时间',
  `heartbeat_time` varchar(22) NOT NULL COMMENT '心跳时间',
  `is_online` int(1) DEFAULT '0' COMMENT '0 不在线  1 在线'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='网关列表';

--
-- 转存表中的数据 `eciot_gateway`
--

INSERT INTO `eciot_gateway` (`id`, `company_code`, `project_code`, `sn`, `type`, `client_id`, `topic`, `up_topic`, `is_reg`, `ctime`, `heartbeat_time`, `is_online`) VALUES
(2, 'ceshi', 'eciot', 'ECIOT803151', 'ECIOT-2M', '', 'iTHq1HPLyM', 'CESHI/ECIOT_CESHI/ECIOT803151', 1, '2019-01-18 15:30:05', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `eciot_gateway_terminal`
--

CREATE TABLE IF NOT EXISTS `eciot_gateway_terminal` (
`id` int(11) NOT NULL COMMENT '终端设备ID',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `gateway_id` int(11) NOT NULL COMMENT '网关ID',
  `shebei_id` smallint(4) NOT NULL COMMENT '设备ID 注册设备的时候 , 网关给设备的编号',
  `product_id` int(10) DEFAULT NULL COMMENT '产品ID',
  `addr` varchar(100) NOT NULL COMMENT '位置信息',
  `sn` varchar(100) NOT NULL COMMENT '设备唯一编号',
  `iottype` int(1) NOT NULL DEFAULT '0' COMMENT '1 485 2 zigbee 3 lora 4 wifi 5 4G ',
  `state` smallint(4) NOT NULL COMMENT '设备状态',
  `is_disable` int(1) DEFAULT '1' COMMENT '1 正常 2 禁用',
  `fault` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常2故障3告警',
  `online` tinyint(1) NOT NULL DEFAULT '2' COMMENT '设备是否在线  1在线  2离线',
  `ctime` varchar(11) NOT NULL COMMENT '添加设备的时间',
  `uptime` int(11) NOT NULL COMMENT '更新资料时间',
  `topic` varchar(100) NOT NULL,
  `extend1` varchar(200) NOT NULL COMMENT '扩展1',
  `extend2` varchar(200) NOT NULL COMMENT '扩展2'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='终端设备表';

--
-- 转存表中的数据 `eciot_gateway_terminal`
--

INSERT INTO `eciot_gateway_terminal` (`id`, `name`, `gateway_id`, `shebei_id`, `product_id`, `addr`, `sn`, `iottype`, `state`, `is_disable`, `fault`, `online`, `ctime`, `uptime`, `topic`, `extend1`, `extend2`) VALUES
(2, '测试LED灯', 2, 0, 2, '测试', 'lue0TowHzd', 0, 0, 1, 1, 2, '1624011109', 0, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product`
--

CREATE TABLE IF NOT EXISTS `eciot_product` (
`id` int(8) NOT NULL COMMENT '类型ID',
  `cate_id` int(10) DEFAULT NULL COMMENT '产品分类ID',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `tablename` varchar(50) NOT NULL COMMENT '类型对应的表名',
  `image` varchar(255) DEFAULT NULL COMMENT '产品图片',
  `thingtype` int(3) DEFAULT NULL COMMENT '驱动ID',
  `iottype` int(3) DEFAULT NULL COMMENT '通信类型',
  `protocol_id` int(10) DEFAULT NULL COMMENT '传输协议ID',
  `is_connect` int(1) DEFAULT '0' COMMENT '1直连设备 2 网关子设备',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='设备类型表';

--
-- 转存表中的数据 `eciot_product`
--

INSERT INTO `eciot_product` (`id`, `cate_id`, `name`, `tablename`, `image`, `thingtype`, `iottype`, `protocol_id`, `is_connect`, `remark`) VALUES
(2, 5, 'LED灯', '', 'http://localhost/eciot/imgs/20190429/1619667366283.png', 3, 1, 1, 2, '');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_1`
--

CREATE TABLE IF NOT EXISTS `eciot_product_1` (
`id` int(11) NOT NULL,
  `terminal_id` int(11) NOT NULL COMMENT '设备ID',
  `sn` varchar(50) DEFAULT NULL COMMENT '设备SN',
  `ctime` varchar(22) DEFAULT NULL COMMENT '时间',
  `1` varchar(255) DEFAULT '1' COMMENT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='eciot_product_1表';

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_2`
--

CREATE TABLE IF NOT EXISTS `eciot_product_2` (
`id` int(11) NOT NULL,
  `terminal_id` int(11) NOT NULL COMMENT '设备ID',
  `sn` varchar(50) DEFAULT NULL COMMENT '设备SN',
  `ctime` varchar(22) DEFAULT NULL COMMENT '时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='eciot_product_2表';

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_cate`
--

CREATE TABLE IF NOT EXISTS `eciot_product_cate` (
`id` int(10) NOT NULL COMMENT 'ID',
  `cate_title` varchar(100) DEFAULT NULL COMMENT '产品分类名称',
  `cate_img` varchar(255) DEFAULT NULL COMMENT '产品分类图片',
  `is_show` int(1) DEFAULT '1' COMMENT '1 显示'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='产品分类表';

--
-- 转存表中的数据 `eciot_product_cate`
--

INSERT INTO `eciot_product_cate` (`id`, `cate_title`, `cate_img`, `is_show`) VALUES
(1, '仪表类', 'https://localhost/portal/img/t/y1.png', 1),
(2, '环境类', 'https://localhost/portal/img/t/hj4.png', 1),
(3, '暖通类', 'https://localhost/portal/img/t/nt2.png', 1),
(4, '数控类', 'https://localhost/portal/img/t/lk2.png', 1),
(5, '设备类', 'https://localhost/portal/img/t/s1.png', 1),
(6, '摄像类', 'https://localhost/portal/img/t/sx2.png', 1);

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_icon`
--

CREATE TABLE IF NOT EXISTS `eciot_product_icon` (
`id` int(11) NOT NULL COMMENT '驱动ID',
  `icon_img` varchar(255) DEFAULT NULL COMMENT '图标地址',
  `ctime` varchar(22) DEFAULT NULL COMMENT '更新时间'
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COMMENT='协议';

--
-- 转存表中的数据 `eciot_product_icon`
--

INSERT INTO `eciot_product_icon` (`id`, `icon_img`, `ctime`) VALUES
(3, 'http://localhost/eciot/imgs/20190429/1619667327247.png', '2019-04-29 11:35:27'),
(2, 'http://localhost/eciot/imgs/20190429/1619667294946.png', '2019-04-29 11:34:54'),
(4, 'http://localhost/eciot/imgs/20190429/1619667330230.png', '2019-04-29 11:35:30'),
(5, 'http://localhost/eciot/imgs/20190429/1619667333730.png', '2019-04-29 11:35:33'),
(6, 'http://localhost/eciot/imgs/20190429/1619667335392.png', '2019-04-29 11:35:35'),
(7, 'http://localhost/eciot/imgs/20190429/1619667338273.png', '2019-04-29 11:35:38'),
(8, 'http://localhost/eciot/imgs/20190429/1619667340350.png', '2019-04-29 11:35:40'),
(9, 'http://localhost/eciot/imgs/20190429/1619667342872.png', '2019-04-29 11:35:43'),
(10, 'http://localhost/eciot/imgs/20190429/1619667345679.png', '2019-04-29 11:35:45'),
(11, 'http://localhost/eciot/imgs/20190429/1619667347117.png', '2019-04-29 11:35:47'),
(12, 'http://localhost/eciot/imgs/20190429/1619667350671.png', '2019-04-29 11:35:50'),
(13, 'http://localhost/eciot/imgs/20190429/1619667353942.png', '2019-04-29 11:35:53'),
(14, 'http://localhost/eciot/imgs/20190429/161966735889.png', '2019-04-29 11:35:58'),
(15, 'http://localhost/eciot/imgs/20190429/1619667360373.png', '2019-04-29 11:36:00'),
(16, 'http://localhost/eciot/imgs/20190429/1619667362912.png', '2019-04-29 11:36:02'),
(17, 'http://localhost/eciot/imgs/20190429/1619667366283.png', '2019-04-29 11:36:06'),
(18, 'http://localhost/eciot/imgs/20190429/161966736991.png', '2019-04-29 11:36:09'),
(19, 'http://localhost/eciot/imgs/20190429/1619667372135.png', '2019-04-29 11:36:12'),
(20, 'http://localhost/eciot/imgs/20190429/1619667375292.png', '2019-04-29 11:36:15'),
(21, 'http://localhost/eciot/imgs/20190429/1619667378739.png', '2019-04-29 11:36:18'),
(22, 'http://localhost/eciot/imgs/20190429/1619667381653.png', '2019-04-29 11:36:21'),
(23, 'http://localhost/eciot/imgs/20190429/1619667384997.png', '2019-04-29 11:36:24'),
(24, 'http://localhost/eciot/imgs/20190429/1619667387529.png', '2019-04-29 11:36:27'),
(25, 'http://localhost/eciot/imgs/20190429/1619667390655.png', '2019-04-29 11:36:30'),
(26, 'http://localhost/eciot/imgs/20190429/1619667393245.png', '2019-04-29 11:36:33'),
(27, 'http://localhost/eciot/imgs/20190429/161966739752.png', '2019-04-29 11:36:38'),
(28, 'http://localhost/eciot/imgs/20190429/1619667401843.png', '2019-04-29 11:36:41'),
(29, 'http://localhost/eciot/imgs/20190429/1619667404873.png', '2019-04-29 11:36:44'),
(30, 'http://localhost/eciot/imgs/20190429/1619667407835.png', '2019-04-29 11:36:47'),
(31, 'http://localhost/eciot/imgs/20190429/1619667413894.png', '2019-04-29 11:36:53'),
(32, 'http://localhost/eciot/imgs/20190429/1619667423951.png', '2019-04-29 11:37:03'),
(33, 'http://localhost/eciot/imgs/20190429/1619667426737.png', '2019-04-29 11:37:06'),
(34, 'http://localhost/eciot/imgs/20190429/1619667431891.png', '2019-04-29 11:37:11'),
(35, 'http://localhost/eciot/imgs/20190429/1619667435617.png', '2019-04-29 11:37:15'),
(36, 'http://localhost/eciot/imgs/20190429/161966743873.png', '2019-04-29 11:37:18'),
(37, 'http://localhost/eciot/imgs/20190429/161966744292.png', '2019-04-29 11:37:22'),
(38, 'http://localhost/eciot/imgs/20190429/1619667446383.png', '2019-04-29 11:37:26'),
(39, 'http://localhost/eciot/imgs/20190429/1619667451815.png', '2019-04-29 11:37:31'),
(40, 'http://localhost/eciot/imgs/20190429/1619667457927.png', '2019-04-29 11:37:37'),
(41, 'http://localhost/eciot/imgs/20190429/1619667463281.png', '2019-04-29 11:37:43'),
(42, 'http://localhost/eciot/imgs/20190429/1619667467779.png', '2019-04-29 11:37:47'),
(43, 'http://localhost/eciot/imgs/20190429/1619667471581.png', '2019-04-29 11:37:51'),
(44, 'http://localhost/eciot/imgs/20190429/1619667474733.png', '2019-04-29 11:37:55'),
(45, 'http://localhost/eciot/imgs/20190429/1619667478148.png', '2019-04-29 11:37:58'),
(46, 'http://localhost/eciot/imgs/20190429/161966748249.png', '2019-04-29 11:38:02'),
(47, 'http://localhost/eciot/imgs/20190429/1619667487509.png', '2019-04-29 11:38:07'),
(48, 'http://localhost/eciot/imgs/20190429/1619667491208.png', '2019-04-29 11:38:12'),
(49, 'http://localhost/eciot/imgs/20190429/161966749736.png', '2019-04-29 11:38:17'),
(50, 'http://localhost/eciot/imgs/20190429/1619667503660.png', '2019-04-29 11:38:23'),
(51, 'http://localhost/eciot/imgs/20190429/1619667508693.png', '2019-04-29 11:38:28'),
(52, 'http://localhost/eciot/imgs/20190429/1619667512572.png', '2019-04-29 11:38:32'),
(53, 'http://localhost/eciot/imgs/20190429/1619667516789.png', '2019-04-29 11:38:36'),
(54, 'http://localhost/eciot/imgs/20190429/1619667520582.png', '2019-04-29 11:38:40'),
(55, 'http://localhost/eciot/imgs/20190429/1619667525727.png', '2019-04-29 11:38:45'),
(56, 'http://localhost/eciot/imgs/20190429/1619667528544.png', '2019-04-29 11:38:48'),
(57, 'http://localhost/eciot/imgs/20190429/1619667535751.png', '2019-04-29 11:38:55'),
(58, 'http://localhost/eciot/imgs/20190429/1619667541283.png', '2019-04-29 11:39:01'),
(59, 'http://localhost/eciot/imgs/20190429/1619667545703.png', '2019-04-29 11:39:06'),
(60, 'http://localhost/eciot/imgs/20190429/1619667552342.png', '2019-04-29 11:39:12'),
(61, 'http://localhost/eciot/imgs/20190429/1619667559766.png', '2019-04-29 11:39:19'),
(62, 'http://localhost/eciot/imgs/20190429/1619667562732.png', '2019-04-29 11:39:23'),
(63, 'http://localhost/eciot/imgs/20190429/1619667568217.png', '2019-04-29 11:39:29'),
(64, 'http://localhost/eciot/imgs/20190429/1619667574684.png', '2019-04-29 11:39:34'),
(65, 'http://localhost/eciot/imgs/20190429/1619667586178.png', '2019-04-29 11:39:47'),
(66, 'http://localhost/eciot/imgs/20190429/1619667591398.png', '2019-04-29 11:39:51'),
(67, 'http://localhost/eciot/imgs/20190429/1619667598362.png', '2019-04-29 11:39:58'),
(68, 'http://localhost/eciot/imgs/20190429/1619667602791.png', '2019-04-29 11:40:02'),
(69, 'http://localhost/eciot/imgs/20190429/1619667607830.png', '2019-04-29 11:40:07'),
(70, 'http://localhost/eciot/imgs/20190429/1619667612249.png', '2019-04-29 11:40:12'),
(71, 'http://localhost/eciot/imgs/20190429/1619667617732.png', '2019-04-29 11:40:17'),
(72, 'http://localhost/eciot/imgs/20190429/1619667622379.png', '2019-04-29 11:40:22'),
(73, 'http://localhost/eciot/imgs/20190429/161966762765.png', '2019-04-29 11:40:27'),
(74, 'http://localhost/eciot/imgs/20190429/1619667632755.png', '2019-04-29 11:40:32'),
(75, 'http://localhost/eciot/imgs/20190429/1619667637420.png', '2019-04-29 11:40:37'),
(76, 'http://localhost/eciot/imgs/20190429/1619667642669.png', '2019-04-29 11:40:43'),
(77, 'http://localhost/eciot/imgs/20190429/1619667647729.png', '2019-04-29 11:40:47'),
(78, 'http://localhost/eciot/imgs/20190429/1619667653884.png', '2019-04-29 11:40:53'),
(79, 'http://localhost/eciot/imgs/20190429/161966765720.png', '2019-04-29 11:40:57'),
(80, 'http://localhost/eciot/imgs/20190429/1619667661379.png', '2019-04-29 11:41:01'),
(81, 'http://localhost/eciot/imgs/20190429/1619667668164.png', '2019-04-29 11:41:08'),
(82, 'http://localhost/eciot/imgs/20190429/1619667673104.png', '2019-04-29 11:41:13'),
(83, 'http://localhost/eciot/imgs/20190429/1619667678626.png', '2019-04-29 11:41:19'),
(84, 'http://localhost/eciot/imgs/20190429/1619667684728.png', '2019-04-29 11:41:24'),
(85, 'http://localhost/eciot/imgs/20190429/1619667695214.png', '2019-04-29 11:41:35'),
(86, 'http://localhost/eciot/imgs/20190429/1619667703386.png', '2019-04-29 11:41:43'),
(87, 'http://localhost/eciot/imgs/20190429/1619667709831.png', '2019-04-29 11:41:49'),
(88, 'http://localhost/eciot/imgs/20190429/1619667715434.png', '2019-04-29 11:41:55'),
(89, 'http://localhost/eciot/imgs/20190429/1619667721223.png', '2019-04-29 11:42:01'),
(90, 'http://localhost/eciot/imgs/20190429/1619667733196.png', '2019-04-29 11:42:13'),
(91, 'http://localhost/eciot/imgs/20190429/1619667740730.png', '2019-04-29 11:42:21'),
(92, 'http://localhost/eciot/imgs/20190429/1619667746716.png', '2019-04-29 11:42:27'),
(93, 'http://localhost/eciot/imgs/20190429/161966775535.png', '2019-04-29 11:42:35'),
(94, 'http://localhost/eciot/imgs/20190429/1619667762504.png', '2019-04-29 11:42:42'),
(95, 'http://localhost/eciot/imgs/20190429/1619667768916.png', '2019-04-29 11:42:48'),
(96, 'http://localhost/eciot/imgs/20190429/1619667773293.png', '2019-04-29 11:42:53'),
(97, 'http://localhost/eciot/imgs/20190429/1619667778993.png', '2019-04-29 11:42:58'),
(98, 'http://localhost/eciot/imgs/20190429/1619667785780.png', '2019-04-29 11:43:05'),
(99, 'http://localhost/eciot/imgs/20190429/1619667791482.png', '2019-04-29 11:43:11'),
(100, 'http://localhost/eciot/imgs/20190429/1619667794383.png', '2019-04-29 11:43:14'),
(101, 'http://localhost/eciot/imgs/20190429/1619667798942.png', '2019-04-29 11:43:18'),
(102, 'http://localhost/eciot/imgs/20190429/1619667802991.png', '2019-04-29 11:43:22');

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_nature`
--

CREATE TABLE IF NOT EXISTS `eciot_product_nature` (
`id` int(10) NOT NULL COMMENT '产品属性ID',
  `product_id` int(10) DEFAULT NULL COMMENT '对应产品ID',
  `nature` varchar(150) DEFAULT NULL COMMENT '属性标识',
  `nature_name` varchar(200) DEFAULT NULL COMMENT '属性名称',
  `type` char(50) DEFAULT NULL COMMENT '属性类型',
  `default_value` varchar(100) DEFAULT NULL COMMENT '默认值',
  `nature_float` int(3) DEFAULT '0' COMMENT '精确小数点',
  `remark` varchar(255) DEFAULT NULL COMMENT '说明',
  `ctime` varchar(22) DEFAULT NULL COMMENT '时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品属性表-创建表字段';

-- --------------------------------------------------------

--
-- 表的结构 `eciot_product_state`
--

CREATE TABLE IF NOT EXISTS `eciot_product_state` (
`id` int(8) NOT NULL COMMENT 'ID',
  `product_id` tinyint(2) NOT NULL COMMENT '产品ID',
  `name` varchar(20) NOT NULL COMMENT '名称',
  `content` varchar(255) NOT NULL COMMENT '操作'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设备类型表';

-- --------------------------------------------------------

--
-- 表的结构 `eciot_protocol`
--

CREATE TABLE IF NOT EXISTS `eciot_protocol` (
`protocol_id` int(11) NOT NULL COMMENT '协议ID',
  `protocol_name` varchar(80) NOT NULL COMMENT '协议名称',
  `protocol_script` varchar(255) NOT NULL COMMENT '协议脚本文件',
  `protocol_publish` int(1) NOT NULL COMMENT '0:未发布1:已发布',
  `protocol_ctime` varchar(11) NOT NULL COMMENT '协议更新时间',
  `protocol_remark` varchar(80) NOT NULL COMMENT '协议备注'
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='协议';

--
-- 转存表中的数据 `eciot_protocol`
--

INSERT INTO `eciot_protocol` (`protocol_id`, `protocol_name`, `protocol_script`, `protocol_publish`, `protocol_ctime`, `protocol_remark`) VALUES
(1, 'eciot2M', 'eciot2m.php', 1, '2019-04-22 ', '小迈网关M2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eciot_admin`
--
ALTER TABLE `eciot_admin`
 ADD PRIMARY KEY (`admin_id`), ADD UNIQUE KEY `用户名` (`user_name`) USING HASH;

--
-- Indexes for table `eciot_admin_group`
--
ALTER TABLE `eciot_admin_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_admin_log`
--
ALTER TABLE `eciot_admin_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_admin_side_action`
--
ALTER TABLE `eciot_admin_side_action`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `eciot_bmslogin`
--
ALTER TABLE `eciot_bmslogin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_gateway`
--
ALTER TABLE `eciot_gateway`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `eciot_gateway_terminal`
--
ALTER TABLE `eciot_gateway_terminal`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product`
--
ALTER TABLE `eciot_product`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_1`
--
ALTER TABLE `eciot_product_1`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_2`
--
ALTER TABLE `eciot_product_2`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_cate`
--
ALTER TABLE `eciot_product_cate`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_icon`
--
ALTER TABLE `eciot_product_icon`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_nature`
--
ALTER TABLE `eciot_product_nature`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_product_state`
--
ALTER TABLE `eciot_product_state`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eciot_protocol`
--
ALTER TABLE `eciot_protocol`
 ADD PRIMARY KEY (`protocol_id`), ADD KEY `protocol_index_name` (`protocol_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eciot_admin`
--
ALTER TABLE `eciot_admin`
MODIFY `admin_id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `eciot_admin_group`
--
ALTER TABLE `eciot_admin_group`
MODIFY `id` int(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `eciot_admin_log`
--
ALTER TABLE `eciot_admin_log`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=255;
--
-- AUTO_INCREMENT for table `eciot_admin_side_action`
--
ALTER TABLE `eciot_admin_side_action`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1069;
--
-- AUTO_INCREMENT for table `eciot_bmslogin`
--
ALTER TABLE `eciot_bmslogin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `eciot_gateway`
--
ALTER TABLE `eciot_gateway`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '网关ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `eciot_gateway_terminal`
--
ALTER TABLE `eciot_gateway_terminal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '终端设备ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `eciot_product`
--
ALTER TABLE `eciot_product`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '类型ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `eciot_product_1`
--
ALTER TABLE `eciot_product_1`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `eciot_product_2`
--
ALTER TABLE `eciot_product_2`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `eciot_product_cate`
--
ALTER TABLE `eciot_product_cate`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `eciot_product_icon`
--
ALTER TABLE `eciot_product_icon`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '驱动ID',AUTO_INCREMENT=103;
--
-- AUTO_INCREMENT for table `eciot_product_nature`
--
ALTER TABLE `eciot_product_nature`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '产品属性ID';
--
-- AUTO_INCREMENT for table `eciot_product_state`
--
ALTER TABLE `eciot_product_state`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `eciot_protocol`
--
ALTER TABLE `eciot_protocol`
MODIFY `protocol_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '协议ID',AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
