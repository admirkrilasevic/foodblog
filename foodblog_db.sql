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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`foodblog` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;

USE `foodblog`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`) values 
(1,'Desserts'),
(3,'Pasta'),
(4,'Snack'),
(5,'Appetizer');

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `comment_text` varchar(1000) COLLATE utf8_bin NOT NULL,
  `comment_timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_user` (`user_id`),
  KEY `fk_comment_post` (`post_id`),
  CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `comments` */

insert  into `comments`(`id`,`user_id`,`post_id`,`comment_text`,`comment_timestamp`) values 
(12,15,1,'Great recipe!','2021-06-25 15:02:12'),
(13,15,2,'Recipe is very easy to follow!','2021-06-28 16:41:14'),
(14,15,4,'They turn out so crispy!','2021-06-28 16:41:43'),
(15,15,5,'So quick to prepare!','2021-06-28 16:42:08'),
(21,15,5,'Amazing!','2021-06-28 20:41:23'),
(22,15,5,'So deliciuos!','2021-06-28 20:45:13'),
(23,15,2,'Best cheesecake ever!','2021-06-28 20:57:48'),
(31,15,5,'So good!','2021-06-28 21:09:07');

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recipe_id` int(10) unsigned NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `time_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` blob DEFAULT NULL,
  `avg_rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posts_recipes` (`recipe_id`),
  CONSTRAINT `fk_posts_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `posts` */

insert  into `posts`(`id`,`recipe_id`,`title`,`description`,`time_posted`,`image`,`avg_rating`) values 
(1,2,'Easy cheesecake recipe','If you are looking for a quick dessert recipe...','2021-06-27 23:29:53','https://cdn.krilasevic.me.fra1.cdn.digitaloceanspaces.com/cheesecake.jpg',0),
(2,5,'Delicious tagliatelle alfredo','This classic Italian dish will impress you...','2021-06-27 23:47:40','https://cdn.krilasevic.me.fra1.cdn.digitaloceanspaces.com/tagliatelle.jpg',NULL),
(4,9,'Crispy onion rings','A great snack to prepare if you have friends coming over...','2021-06-27 23:45:53','https://cdn.krilasevic.me.fra1.cdn.digitaloceanspaces.com/onion-rings.jpg',NULL),
(5,10,'Mediterranean appetizer','A great start to a fancy dinner...','2021-06-27 23:46:11','https://cdn.krilasevic.me.fra1.cdn.digitaloceanspaces.com/baguette.jpg',NULL);

/*Table structure for table `ratings` */

DROP TABLE IF EXISTS `ratings`;

CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `rating_value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_rating` (`user_id`),
  KEY `fk_recipe_rating` (`post_id`),
  CONSTRAINT `fk_post_rating` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  CONSTRAINT `fk_user_rating` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `ratings` */

insert  into `ratings`(`id`,`user_id`,`post_id`,`rating_value`) values 
(1,15,1,5),
(2,15,2,5),
(3,15,4,5),
(4,15,5,5);

/*Table structure for table `recipes` */

DROP TABLE IF EXISTS `recipes`;

CREATE TABLE `recipes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `time_req` varchar(256) COLLATE utf8_bin NOT NULL,
  `procedure_steps` varchar(4000) COLLATE utf8_bin NOT NULL,
  `ingredients` varchar(4000) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `recipes` */

insert  into `recipes`(`id`,`category_name`,`title`,`time_req`,`procedure_steps`,`ingredients`) values 
(2,'Dessert','Cheesecake','1 hour','Prepare a baking dish...','1 kg of cream cheese...'),
(5,'Pasta','Tagliatelle alfredo','30 minutes','Cook the pasta...','100g of parmesan...'),
(9,'Snack','Onion Rings','30 minutes','Peel the onions and cut into rings...','2 onions...'),
(10,'Appetizer','Baguettes with cherry tomatoes and mozarella','20 minutes','Chop the tomatoes...','5 cherry tomatoes...');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `username` varchar(256) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `password` varchar(256) COLLATE utf8_bin NOT NULL,
  `role` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT 'USER',
  `status` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT 'pending',
  `token` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`password`,`role`,`status`,`token`,`created_at`,`token_created_at`) values 
(4,'Eldar Jahić','eldarjahic','eldar.jahic@stu.ibu.edu.ba','1234','USER','ACTIVE',NULL,'2021-03-27 00:54:33',NULL),
(15,'Admir Krilašević','admirkrilasevic','admir.krilasevic@stu.ibu.edu.ba','de4235022440baabbfe8a353f986b286','ADMIN','ACTIVE','6a49a88eaaf14c496cfe0874d6718b22','2021-04-04 14:52:57',NULL),
(16,'Vedran Selak','vedranselak','vedran.selak@stu.ibu.edu.ba','a395c2e6d1311817a2dab836c1a764bb','USER','ACTIVE',NULL,'2021-04-04 14:54:54','2021-04-07 15:15:11'),
(17,'Admir 2','admir2','krilasevic.admir@gmail.com','202cb962ac59075b964b07152d234b70','USER','ACTIVE',NULL,'2021-04-12 09:39:49','2021-06-24 19:30:04'),
(18,'Ramiz Krilasevic','ramiz','ramizkrilasevic@gmail.com','88ecd479a18802361132b736b929e33f','USER','ACTIVE',NULL,'2021-04-12 20:48:57',NULL),
(39,'John Doe','johndoe','johndoee@gmail.com','202cb962ac59075b964b07152d234b70','USER','ACTIVE',NULL,'2021-06-24 18:33:02',NULL),
(41,'a','a','a','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(49,'b','b','b','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(50,'c','c','c','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(51,'d','d','d','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(52,'e','e','e','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(53,'f','f','f','','USER','pending',NULL,'0000-00-00 00:00:00',NULL),
(54,'Adi Krilasevic','adi','krilasevica@gmail.com','9f74eaae7e20589a0cc3cb9189e45fcf','USER','ACTIVE',NULL,'2021-06-27 15:12:41',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
