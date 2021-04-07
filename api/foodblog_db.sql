/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - foodblog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`foodblog` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `foodblog`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `categories` */

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `recipe_id` int(11) unsigned NOT NULL,
  `text` longtext COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_comment_user` (`user_id`),
  KEY `fk_comment_post` (`recipe_id`),
  CONSTRAINT `fk_comment_post` FOREIGN KEY (`recipe_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `comments` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `time_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` blob DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  `avg_rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_recipes` (`recipe_id`),
  CONSTRAINT `fk_posts_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `posts` */

/*Table structure for table `ratings` */

DROP TABLE IF EXISTS `ratings`;

CREATE TABLE `ratings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `recipe_id` int(11) unsigned NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_rating` (`user_id`),
  KEY `fk_recipe_rating` (`recipe_id`),
  CONSTRAINT `fk_recipe_rating` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  CONSTRAINT `fk_user_rating` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ratings` */

/*Table structure for table `recipecategories` */

DROP TABLE IF EXISTS `recipecategories`;

CREATE TABLE `recipecategories` (
  `recipe_id` int(11) unsigned NOT NULL,
  `category_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`recipe_id`,`category_id`),
  KEY `fk_rc_category` (`category_id`),
  CONSTRAINT `fk_rc_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `fk_rc_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `recipecategories` */

/*Table structure for table `recipes` */

DROP TABLE IF EXISTS `recipes`;

CREATE TABLE `recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `time_req` varchar(256) COLLATE utf8_bin NOT NULL,
  `procedure` longtext COLLATE utf8_bin NOT NULL,
  `ingredients` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `recipes` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `username` varchar(256) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `profile_picture` blob DEFAULT NULL,
  `status` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  `token` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`password`,`admin`,`profile_picture`,`status`,`token`,`created_at`,`token_created_at`) values 
(4,'Eldar Jahić','eldarjahic','eldar.jahic@stu.ibu.edu.ba','1234',0,NULL,'ACTIVE','9501c57c5a7f5fe79d7cdd68f8fd8aae','2021-03-27 00:54:33',NULL),
(13,'Adi Krilašević','adi','krilasevica@gmail.com','7360409d967a24b667afc33a8384ec9e',0,NULL,'ACTIVE','8c970fd68b37c841204efa685932d01a','2021-04-04 14:44:48',NULL),
(15,'Admir Krilašević','admirkrilasevic','admir.krilasevic@stu.ibu.edu.ba','de4235022440baabbfe8a353f986b286',1,NULL,'ACTIVE','6a49a88eaaf14c496cfe0874d6718b22','2021-04-04 14:52:57',NULL),
(16,'Vedran Selak','vedranselak','vedran.selak@stu.ibu.edu.ba','a395c2e6d1311817a2dab836c1a764bb',0,NULL,'ACTIVE','dac39b33b1116f58261b63353b7916a2','2021-04-04 14:54:54',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
