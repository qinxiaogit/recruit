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

 Date: 28/07/2023 22:52:12
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
  `openid` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '小程序openid',
  `password` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '用户密码:默认123456 兼容框架',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for citys
-- ----------------------------
DROP TABLE IF EXISTS `citys`;
CREATE TABLE `citys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '城市名称',
  `index` char(8) NOT NULL DEFAULT '' COMMENT '城市首字母',
  `key` char(8) NOT NULL DEFAULT '' COMMENT '城市唯一码',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

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
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='报名记录';

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
  `contact_qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '联系方式二维码地址',
  `contact_qq` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '联系方式-qq',
  `contact_wx` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '联系方式-wx',
  `contact_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '联系方式二维码',
  `city` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '职位所在城市code',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

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
  `uid` int(11) DEFAULT '0' COMMENT '店铺所属小程序用户id',
  `album` text CHARACTER SET utf8mb4 COMMENT '企业相册',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

INSERT INTO `recruit`.`super_admins`(`id`, `username`, `password`, `created_at`, `updated_at`, `deleted_at`, `avatar`, `name`) VALUES (1, 'admin', '$2y$10$pzkxg6MCDtlluoEF5yqrm..7Vv4mE5mN811.0hFYp6UVOmd3Q/2IK', '2023-05-31 19:09:38', '2023-05-31 19:09:38', NULL, 'https://img2.woyaogexing.com/2023/05/31/c94dfa3d65b642ceb393235f7ceea65c.jpg', '超级管理员');

SET FOREIGN_KEY_CHECKS = 1;
