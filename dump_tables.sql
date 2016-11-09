/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.5.50-0ubuntu0.14.04.1 : Database - vagrant_yii2_template
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`vagrant_yii2_template` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `vagrant_yii2_template`;

/*Table structure for table `mail_template` */

DROP TABLE IF EXISTS `mail_template`;

CREATE TABLE `mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `body` blob,
  `name` char(250) NOT NULL,
  `created_at` int(11) NOT NULL,
  `subject` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mail_template` */

LOCK TABLES `mail_template` WRITE;

UNLOCK TABLES;

/*Table structure for table `mailing` */

DROP TABLE IF EXISTS `mailing`;

CREATE TABLE `mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mail_template_id` int(11) NOT NULL,
  `status` tinyint(2) DEFAULT '1',
  `placeholders` text,
  `created_at` int(11) DEFAULT NULL,
  `date_send` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mail_template_id` (`mail_template_id`),
  CONSTRAINT `mailing_ibfk_1` FOREIGN KEY (`mail_template_id`) REFERENCES `mail_template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mailing` */

LOCK TABLES `mailing` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;