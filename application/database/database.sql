-- Create syntax for database `like_dl`
CREATE DATABASE IF NOT EXISTS like_dl;
USE like_dl;

-- Create syntax for table `users`
CREATE TABLE IF NOT EXISTS `users`(
  `user_id` BIGINT UNSIGNED PRIMARY KEY,
  `oauth_token` VARCHAR(255) NULL,
  `oauth_token_secret` VARCHAR(255) NULL,
  `token_expired_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `destroyed_at` DATETIME DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

-- Create syntax for table `favorites`
CREATE TABLE IF NOT EXISTS `tweets` (
  `tweet_id` BIGINT UNSIGNED PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `text` VARCHAR(160) NOT NULL DEFAULT '',
  `published_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `destroyed_at` DATETIME DEFAULT NULL,
  `lang` varchar(10) NOT NULL DEFAULT ''
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `favorites` (
  `favorite_id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `tweet_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  UNIQUE (`tweet_id`, `user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
  FOREIGN KEY (`tweet_id`) REFERENCES `tweets`(`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

-- Create syntax for table `media`
CREATE TABLE `media` (
  `media_id` BIGINT UNSIGNED,
  `media_type` VARCHAR(32) NULL,
  `media_thumb_url` VARCHAR(255) NULL,
  `tweet_id` BIGINT UNSIGNED NOT NULL,
  `media_url` VARCHAR(255) NULL,
  PRIMARY KEY(`media_id`, `media_type`),
  FOREIGN KEY (`tweet_id`) REFERENCES `tweets`(`tweet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;
