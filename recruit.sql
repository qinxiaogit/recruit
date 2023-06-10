/*
 Navicat Premium Data Transfer

 Source Server         : local@5.7
 Source Server Type    : MySQL
 Source Server Version : 50727
 Source Host           : localhost:3306
 Source Schema         : recruit

 Target Server Type    : MySQL
 Target Server Version : 50727
 File Encoding         : 65001

 Date: 11/06/2023 06:14:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for app_user
-- ----------------------------
DROP TABLE IF EXISTS `app_user`;
CREATE TABLE `app_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'nickname',
  `real_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '性别：1.男，2.女',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `invite_code` char(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邀请码',
  `invite_uid` int(11) NOT NULL DEFAULT '0' COMMENT '邀请人',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `birthday` char(16) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户生日',
  `active_time` bigint(11) DEFAULT '0' COMMENT '最近活跃时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of app_user
-- ----------------------------
BEGIN;
INSERT INTO `app_user` VALUES (1, '2023-06-06 09:59:50', '2023-06-06 09:59:54', 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '测试', '嘿嘿', '1', '18227755586', '000001', 0, NULL, '20221102', 0);
INSERT INTO `app_user` VALUES (2, '2023-06-06 10:00:50', NULL, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '测试2', '呵呵', '2', '18227755588', '000002', 1, NULL, '20221211', 0);
COMMIT;

-- ----------------------------
-- Table structure for audit_log
-- ----------------------------
DROP TABLE IF EXISTS `audit_log`;
CREATE TABLE `audit_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '审核原因',
  `result` int(11) NOT NULL DEFAULT '0' COMMENT '审核结果：0.通过，1.驳回',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '审核人id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ref_id` int(11) DEFAULT '0' COMMENT '审核业务id',
  `bus_type` char(16) COLLATE utf8mb4_unicode_ci DEFAULT 'store' COMMENT '审核业务类型：store.店铺，feedback.反馈，job职位',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of audit_log
-- ----------------------------
BEGIN;
INSERT INTO `audit_log` VALUES (1, 'sdaasda', 1, 1, '2023-06-02 03:17:45', '2023-06-02 03:17:45', 0, 'store');
INSERT INTO `audit_log` VALUES (2, '2222', 1, 1, '2023-06-02 03:20:57', '2023-06-02 03:20:57', 0, 'store');
INSERT INTO `audit_log` VALUES (3, '6666', 1, 1, '2023-06-02 03:23:40', '2023-06-02 03:23:40', 0, 'store');
INSERT INTO `audit_log` VALUES (4, '系统异常', 1, 1, '2023-06-02 03:26:01', '2023-06-02 03:26:01', 0, 'store');
INSERT INTO `audit_log` VALUES (6, '6666', 1, 1, '2023-06-07 07:36:37', '2023-06-07 07:36:37', 0, 'store');
COMMIT;

-- ----------------------------
-- Table structure for balance_log
-- ----------------------------
DROP TABLE IF EXISTS `balance_log`;
CREATE TABLE `balance_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '审核原因',
  `direction` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.新增，2.扣除',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '操作人',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '金额变更数量',
  `source` tinyint(1) DEFAULT '1' COMMENT '来源：1.系统管理员',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of balance_log
-- ----------------------------
BEGIN;
INSERT INTO `balance_log` VALUES (6, '商户充值', 1, 1, 1000, 1, '2023-06-07 09:31:01', '2023-06-07 09:31:01');
INSERT INTO `balance_log` VALUES (7, '商户充值', 1, 1, 1000, 1, '2023-06-07 09:31:26', '2023-06-07 09:31:26');
INSERT INTO `balance_log` VALUES (8, '商户充值', 1, 1, 1000, 1, '2023-06-07 09:31:36', '2023-06-07 09:31:36');
INSERT INTO `balance_log` VALUES (9, '商户充值', 1, 1, 600, 1, '2023-06-07 09:32:01', '2023-06-07 09:32:01');
INSERT INTO `balance_log` VALUES (10, '扣除所有数据', 2, 1, 11, 1, '2023-06-07 09:34:25', '2023-06-07 09:34:25');
INSERT INTO `balance_log` VALUES (11, '扣除所有数据', 2, 1, 11, 1, '2023-06-07 09:34:46', '2023-06-07 09:34:46');
INSERT INTO `balance_log` VALUES (12, '1', 1, 1, 12, 1, '2023-06-07 09:36:28', '2023-06-07 09:36:28');
INSERT INTO `balance_log` VALUES (13, '1', 1, 1, 12, 1, '2023-06-07 09:36:50', '2023-06-07 09:36:50');
INSERT INTO `balance_log` VALUES (14, '2222', 1, 1, 1000, 1, '2023-06-07 09:38:02', '2023-06-07 09:38:02');
INSERT INTO `balance_log` VALUES (15, '2222', 1, 1, 1222, 1, '2023-06-07 09:54:30', '2023-06-07 09:54:30');
COMMIT;

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for feed_back
-- ----------------------------
DROP TABLE IF EXISTS `feed_back`;
CREATE TABLE `feed_back` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `feed_uid` int(11) NOT NULL DEFAULT '0' COMMENT '反馈用户id',
  `feed_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '反馈类型:1.收取费用，2.工资拖欠，3.放鸽子,4.虚假信息，5.刷单博彩，6.其他',
  `contact_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系方式',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '举报情况说明',
  `img_json` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片证明',
  `status` tinyint(4) NOT NULL COMMENT '处理状态:0.待处理，1.已处理',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '处理结果',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of feed_back
-- ----------------------------
BEGIN;
INSERT INTO `feed_back` VALUES (1, '2023-06-06 17:32:11', '2023-06-07 07:36:37', NULL, 1, 1, '346243025', '你到家啊时间啊技能等级拿手机拿手机奶萨缴纳手打加拿大缴纳', '[\"https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg\",\"https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg\"]', 2, ' ');
COMMIT;

-- ----------------------------
-- Table structure for job_cate
-- ----------------------------
DROP TABLE IF EXISTS `job_cate`;
CREATE TABLE `job_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '分类排序',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '分类等级',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0' COMMENT '负节点id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_cate
-- ----------------------------
BEGIN;
INSERT INTO `job_cate` VALUES (1, '2023-06-05 18:14:08', NULL, '简单易做', 1, 1, NULL, 0);
INSERT INTO `job_cate` VALUES (2, '2023-06-05 14:21:22', '2023-06-05 14:21:22', '技能才艺', 2, 1, NULL, 0);
INSERT INTO `job_cate` VALUES (3, '2023-06-05 14:21:46', '2023-06-05 14:21:46', '家教辅导', 3, 1, NULL, 0);
INSERT INTO `job_cate` VALUES (4, '2023-06-05 14:21:57', '2023-06-05 14:21:57', '聊天主播', 4, 1, NULL, 0);
INSERT INTO `job_cate` VALUES (5, '2023-06-05 14:22:38', '2023-06-05 14:22:38', '问卷调查', 1, 2, NULL, 1);
INSERT INTO `job_cate` VALUES (6, '2023-06-05 14:22:48', '2023-06-05 15:25:40', '线上推广', 1, 2, '2023-06-05 15:25:40', 1);
INSERT INTO `job_cate` VALUES (7, '2023-06-05 14:23:02', '2023-06-05 14:23:02', '主播', 1, 2, NULL, 2);
INSERT INTO `job_cate` VALUES (8, '2023-06-05 14:23:10', '2023-06-05 15:25:40', '美工设计', 1, 2, '2023-06-05 15:25:40', 2);
INSERT INTO `job_cate` VALUES (9, '2023-06-05 14:23:21', '2023-06-05 14:23:21', '答题批改', 1, 2, NULL, 3);
INSERT INTO `job_cate` VALUES (10, '2023-06-05 14:23:28', '2023-06-05 15:25:40', '线上家教', 1, 2, '2023-06-05 15:25:40', 3);
INSERT INTO `job_cate` VALUES (11, '2023-06-05 14:23:43', '2023-06-05 14:23:43', '聊天员', 1, 2, NULL, 4);
INSERT INTO `job_cate` VALUES (12, '2023-06-05 14:23:49', '2023-06-05 14:23:49', '主播', 1, 2, NULL, 4);
INSERT INTO `job_cate` VALUES (13, '2023-06-05 14:23:56', '2023-06-05 15:25:40', '其他', 1, 2, '2023-06-05 15:25:40', 4);
COMMIT;

-- ----------------------------
-- Table structure for job_report_records
-- ----------------------------
DROP TABLE IF EXISTS `job_report_records`;
CREATE TABLE `job_report_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0.待录用，1.已录用，2.不录用',
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '操作原因',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='报名记录';

-- ----------------------------
-- Records of job_report_records
-- ----------------------------
BEGIN;
INSERT INTO `job_report_records` VALUES (1, '2023-06-09 18:37:22', NULL, 1, 1, 1, '符合录用标准');
INSERT INTO `job_report_records` VALUES (2, '2023-06-09 18:37:34', NULL, 2, 1, 2, '不符原则');
COMMIT;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '职位名称',
  `sort` int(11) NOT NULL DEFAULT '99999' COMMENT '职位排序',
  `one_cate_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '一级分类id',
  `two_cate_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '二级分类id',
  `method` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.线上，2.线下',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1.男，2.女',
  `settlement` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算方式:1.日结，2.周结，3.月结，4.完工结，5.其他',
  `is_top` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否置顶:0.不置顶，1.置顶',
  `employ_count` int(11) NOT NULL DEFAULT '0' COMMENT '招募人数',
  `work_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '工作开始时间',
  `work_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '工作结束时间',
  `work_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工作内容',
  `work_require` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工作要求',
  `salary` decimal(8,2) NOT NULL COMMENT '薪资',
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '薪资单位',
  `salary_desc` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '薪资说明',
  `report_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '报名统计',
  `view_count` bigint(20) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '职位状态：0:待审核，1.上架，2.下架',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `age_start` tinyint(1) DEFAULT '0' COMMENT '年龄限制开始',
  `age_end` tinyint(1) NOT NULL DEFAULT '0' COMMENT '年龄限制结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------
BEGIN;
INSERT INTO `jobs` VALUES (1, '2023-06-05 14:35:07', '2023-06-05 09:42:41', '第一个职位', 50, 1, 5, 1, 1, 1, 1, 10, 20211103, 20211113, '时代楷模打啊看没看马上', '阿达大萨达', 10.00, '小时', '刀马旦卡密代码块开慢点', 100, 122, 1, 1, NULL, 0, 0);
INSERT INTO `jobs` VALUES (2, '2023-06-09 10:09:02', '2023-06-09 10:09:02', 'asdadasds', 99999, 2, 7, 2, 1, 2, 0, 1000, 20230605, 20230705, 'damdkakdkakmdkmakmdskmsdkmssads', 'dsmksdakmsdkmskmdsakmsadkmsd', 1.00, '天', 'dmkdskmdkasdksadkmdsakmdsa', 0, 0, 1, 0, NULL, 10, 12);
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2023_05_31_104152_create_super_admins_table', 1);
INSERT INTO `migrations` VALUES (7, '2023_05_31_175727_create_stores_table', 2);
INSERT INTO `migrations` VALUES (8, '2023_06_02_022821_audit_log', 3);
INSERT INTO `migrations` VALUES (10, '2023_06_02_085319_create_jobs_table', 4);
INSERT INTO `migrations` VALUES (11, '2023_06_02_093943_create_app_user_table', 5);
INSERT INTO `migrations` VALUES (12, '2023_06_02_094001_create_job_cate_table', 5);
INSERT INTO `migrations` VALUES (13, '2023_06_02_094038_create_feed_back_table', 5);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for store_account
-- ----------------------------
DROP TABLE IF EXISTS `store_account`;
CREATE TABLE `store_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户账号',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '头像',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '别名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of store_account
-- ----------------------------
BEGIN;
INSERT INTO `store_account` VALUES (1, 'admin', '$2y$10$pzkxg6MCDtlluoEF5yqrm..7Vv4mE5mN811.0hFYp6UVOmd3Q/2IK', 1, '2023-05-31 19:09:38', '2023-05-31 19:09:38', NULL, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '超级管理员');
COMMIT;

-- ----------------------------
-- Table structure for stores
-- ----------------------------
DROP TABLE IF EXISTS `stores`;
CREATE TABLE `stores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商户名称',
  `balance` int(11) NOT NULL DEFAULT '0' COMMENT '商户余额',
  `today_report_count` int(11) NOT NULL DEFAULT '0' COMMENT '今日报名数',
  `online_count` int(11) NOT NULL DEFAULT '0' COMMENT '当前在线职位数',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '店铺状态:0.待审核，1.审核通过',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'logo',
  `business_license` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '营业执照',
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '联系方式',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of stores
-- ----------------------------
BEGIN;
INSERT INTO `stores` VALUES (1, '第一个店铺', 1232, 12, 13, 2, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '18227755589', '2023-06-01 11:45:34', '2023-06-07 09:45:17', NULL);
INSERT INTO `stores` VALUES (2, '第二个店铺', 5601, 111, 122, 1, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '19288288282', '2023-06-02 16:35:06', '2023-06-07 09:45:20', NULL);
COMMIT;

-- ----------------------------
-- Table structure for super_admins
-- ----------------------------
DROP TABLE IF EXISTS `super_admins`;
CREATE TABLE `super_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '头像',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '别名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of super_admins
-- ----------------------------
BEGIN;
INSERT INTO `super_admins` VALUES (1, 'admin', '$2y$10$pzkxg6MCDtlluoEF5yqrm..7Vv4mE5mN811.0hFYp6UVOmd3Q/2IK', '2023-05-31 19:09:38', '2023-05-31 19:09:38', NULL, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '超级管理员');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
