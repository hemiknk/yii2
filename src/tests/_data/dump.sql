/*
SQLyog Community v11.52 (32 bit)
MySQL - 5.5.50-0ubuntu0.14.04.1 : Database - vagrant_yii2_template_tests
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vagrant_yii2_template_tests` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `vagrant_yii2_template_tests`;

/*Table structure for table `mail_template` */

DROP TABLE IF EXISTS `mail_template`;

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `body` text,
  `name` varchar(250) NOT NULL,
  `created_at` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-mail_template-user_id` (`user_id`),
  CONSTRAINT `fk-mail_template-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mail_template` */

LOCK TABLES `mail_template` WRITE;

insert  into `mail_template`(`id`,`user_id`,`body`,`name`,`created_at`,`subject`) values (1,1,NULL,'firstTemplate',0,NULL),(2,1,NULL,'template2',0,NULL),(3,1,NULL,'template3',0,NULL);

UNLOCK TABLES;

/*Table structure for table `mailing` */

DROP TABLE IF EXISTS `mailing`;

CREATE TABLE `mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mail_template_id` int(11) NOT NULL,
  `status` int(2) DEFAULT '1',
  `placeholders` text,
  `created_at` int(11) DEFAULT NULL,
  `date_send` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx-mailing-user_id` (`user_id`),
  KEY `idx-mailing-mail_template_id` (`mail_template_id`),
  CONSTRAINT `fk-mailing-mail_template_id` FOREIGN KEY (`mail_template_id`) REFERENCES `mail_template` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-mailing-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mailing` */

LOCK TABLES `mailing` WRITE;

insert  into `mailing`(`id`,`user_id`,`mail_template_id`,`status`,`placeholders`,`created_at`,`date_send`) values (1,1,1,1,NULL,NULL,'2016-11-15 12:47:05'),(2,1,1,1,NULL,NULL,'2016-11-15 12:47:06');

UNLOCK TABLES;

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

LOCK TABLES `migration` WRITE;

UNLOCK TABLES;

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profile_user_id` (`user_id`),
  CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `profile` */

LOCK TABLES `profile` WRITE;

UNLOCK TABLES;

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `role` */

LOCK TABLES `role` WRITE;

insert  into `role`(`id`,`name`,`created_at`,`updated_at`,`can_admin`) values (1,'user',NULL,NULL,0);

UNLOCK TABLES;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logged_in_at` timestamp NULL DEFAULT NULL,
  `created_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  `banned_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`),
  UNIQUE KEY `user_username` (`username`),
  KEY `user_role_id` (`role_id`),
  CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

LOCK TABLES `user` WRITE;

insert  into `user`(`id`,`role_id`,`status`,`email`,`username`,`password`,`auth_key`,`access_token`,`logged_in_ip`,`logged_in_at`,`created_ip`,`created_at`,`updated_at`,`banned_at`,`banned_reason`) values (1,1,0,'test.usert@mail.com','testUser1','123',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,1,'neo@neo.com','neo','$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O','DiSiAVfZdw076beE_kH-1F8SVp80eJmP','-90ZCGTh5Dvk7sa1P8-lPAASLG3DUG1b','127.0.0.1','2016-11-17 10:36:41',NULL,'2016-11-09 13:48:30',NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `user_auth` */

DROP TABLE IF EXISTS `user_auth`;

CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_auth_provider_id` (`provider_id`),
  KEY `user_auth_user_id` (`user_id`),
  CONSTRAINT `user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_auth` */

LOCK TABLES `user_auth` WRITE;

UNLOCK TABLES;

/*Table structure for table `user_token` */

DROP TABLE IF EXISTS `user_token`;

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` smallint(6) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `expired_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_token_token` (`token`),
  KEY `user_token_user_id` (`user_id`),
  CONSTRAINT `user_token_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user_token` */

LOCK TABLES `user_token` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
