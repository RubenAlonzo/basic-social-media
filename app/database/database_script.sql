CREATE DATABASE `social_media_20186966` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

use `social_media_20186966`;

CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `profile_pic` varchar(100) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_confirmed` tinyint DEFAULT NULL,
  `hash` varchar(45) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `text_content` varchar(2000) DEFAULT NULL,
  `image_content` varchar(45) DEFAULT NULL,
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`),
  KEY `user_post_idx` (`id_user`),
  CONSTRAINT `user_post` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `reply` (
  `id_reply` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_post` int NOT NULL,
  `id_parent` int DEFAULT '0',
  `text_content` varchar(2000) DEFAULT NULL,
  `image_content` varchar(45) DEFAULT NULL,
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reply`),
  KEY `reply-user_idx` (`id_user`),
  KEY `reply-post_idx` (`id_post`),
  CONSTRAINT `reply-post` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE CASCADE,
  CONSTRAINT `reply-user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `friend` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user_one` int NOT NULL,
  `id_user_two` int NOT NULL,
  `status` tinyint(1) unsigned zerofill NOT NULL,
  `id_last_user_action` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  `id_event` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_event`),
  KEY `user-event_idx` (`id_user`),
  CONSTRAINT `user-event` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `invitation` (
  `id_invitation` int NOT NULL AUTO_INCREMENT,
  `id_event` int NOT NULL,
  `id_invited` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_invitation`),
  KEY `invitation-event_idx` (`id_event`),
  KEY `invitation-user_idx` (`id_invited`),
  CONSTRAINT `invitation-event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE,
  CONSTRAINT `invitation-user` FOREIGN KEY (`id_invited`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;






