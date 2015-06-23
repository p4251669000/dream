/*
SQLyog Job Agent v11.24 (32 bit) Copyright(c) Webyog Inc. All Rights Reserved.


MySQL - 5.6.21-log : Database - dream
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dream` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `dream`;

/*Table structure for table `drauthassignment` */

DROP TABLE IF EXISTS `drauthassignment`;

CREATE TABLE `drauthassignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `drauthassignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `drauthitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `drauthassignment` */

insert  into `drauthassignment` values ('超级管理员','20150622085155',1434994919),('超级管理员','20150622174943',1434995383);

/*Table structure for table `drauthitem` */

DROP TABLE IF EXISTS `drauthitem`;

CREATE TABLE `drauthitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `drauthitem_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `drauthrule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `drauthitem` */

insert  into `drauthitem` values ('第二permission1',2,'我的测试',NULL,NULL,1432011656,1434988590),('超级管理员',1,'超级管理员',NULL,NULL,1434992886,1434992886);

/*Table structure for table `drauthitemchild` */

DROP TABLE IF EXISTS `drauthitemchild`;

CREATE TABLE `drauthitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `drauthitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `drauthitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `drauthitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `drauthitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `drauthitemchild` */

insert  into `drauthitemchild` values ('超级管理员','第二permission1');

/*Table structure for table `drauthrolemenu` */

DROP TABLE IF EXISTS `drauthrolemenu`;

CREATE TABLE `drauthrolemenu` (
  `id` varchar(100) COLLATE utf8_bin NOT NULL,
  `rolename` varchar(100) COLLATE utf8_bin NOT NULL,
  `menuid` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `drauthrolemenu` */

insert  into `drauthrolemenu` values ('14349928861963','超级管理员','20150517031202'),('14349928868032','超级管理员','20150608152655'),('14349928872934','超级管理员','20150617143851'),('14349928873694','超级管理员','20150617143955'),('14349928875335','超级管理员','20150517034251'),('14349928876517','超级管理员','20150608152740'),('14349928876819','超级管理员','20150608152841'),('14349928877595','超级管理员','20150517032700'),('14349928878876','超级管理员','20150517034223'),('14349928881841','超级管理员','20150617144049'),('14349928889228','超级管理员','20150617144248'),('14349928889655','超级管理员','20150617144345');

/*Table structure for table `drauthrule` */

DROP TABLE IF EXISTS `drauthrule`;

CREATE TABLE `drauthrule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `drauthrule` */

/*Table structure for table `drmenu` */

DROP TABLE IF EXISTS `drmenu`;

CREATE TABLE `drmenu` (
  `id` char(100) COLLATE utf8_bin NOT NULL,
  `name` char(100) COLLATE utf8_bin NOT NULL,
  `ico` char(50) COLLATE utf8_bin DEFAULT NULL,
  `parentid` char(100) COLLATE utf8_bin DEFAULT NULL,
  `url` char(50) COLLATE utf8_bin DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `drmenu` */

insert  into `drmenu` values ('20150608152655','用户管理','fa fa-users','20150517031202','###','2015-06-08 15:26:55',50),('20150517034251','添加菜单','','20150517032700','system/menu/create','2015-05-17 03:42:51',50),('20150517034223','菜单列表','','20150517032700','system/menu/index','2015-05-17 03:42:23',50),('20150517032700','菜单管理','fa fa-cubes','20150517031202','','2015-05-17 03:27:00',50),('20150608152740','添加用户','fa fa-none','20150608152655','system/user/create','2015-06-08 15:27:40',50),('20150517031202','系统设置','fa fa-windows','0','###','2015-05-17 03:12:02',50),('20150608152841','用户列表','fa fa-none','20150608152655','system/user/index','2015-06-08 15:28:41',50),('20150617143851','权限管理','fa fa-sitemap','20150517031202','###','2015-06-17 14:38:51',50),('20150617143955','权限列表','','20150617143851','system/auth/authitemlist?type=2','2015-06-17 14:39:55',50),('20150617144049','角色列表','','20150617143851','system/auth/authitemlist?type=1','2015-06-17 14:40:49',50),('20150617144248','添加权限','','20150617143851','system/auth/createpermission','2015-06-17 14:42:48',50),('20150617144345','添加角色','','20150617143851','system/auth/createrole','2015-06-17 14:43:45',50);

/*Table structure for table `druser` */

DROP TABLE IF EXISTS `druser`;

CREATE TABLE `druser` (
  `id` varchar(50) COLLATE utf8_bin NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_bin NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `img` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '用户图像',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `druser` */

insert  into `druser` values ('20150622085155','uZVxZA1OAhNkgxxLWoODBbmu_EA_mfaT','408580741@qq.com','programmer','$2y$13$Rl5jgM.Eqp5cBwO2TslzJOhEUq1klYRrAEGfqhykSNMdw6A3T7F/q',NULL,10,'assets/admin/layout/img/avatar3_small.jpg',1434995383,1434995383);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `migration` */

insert  into `migration` values ('m000000_000000_base',1431928394),('m140506_102106_rbac_init',1431932001);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
