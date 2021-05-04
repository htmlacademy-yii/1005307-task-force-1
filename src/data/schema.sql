CREATE
DATABASE IF NOT EXISTS TaskForce DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE UTF8_GENERAL_CI;
USE
TaskForce;

CREATE TABLE IF NOT EXISTS `categories`
(
    `id`          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`        varchar(128) NOT NULL unique,
    `icon`        varchar(128) NOT NULL unique,
    `profession`  varchar(128) NOT NULL unique
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `cities`
(
    `id`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `city`  varchar(128) NOT NULL unique,
    `lat`   float(8, 6) NOT NULL unique,
    `long`  float(8, 6) NOT NULL unique
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `user_role` {
    `id`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`  varchar(128) NOT NULL unique
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `users` (
    `id`            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email`         varchar(128) NOT NULL unique,
    `name`          varchar(128) NOT NULL unique,
    `password`      varchar(128) NOT NULL,
    `dt_add`    timestamp DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    `user_role_id`  varchar(128) NOT NULL,
    KEY `user_role_id` (`user_role_id`),
    CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`),
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `profiles` (
    `id`        INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `address`   varchar(128),
    `bd`        DATE,
    `about`     text,
    `phone`     int(10),
    `skype`     varchar(128),
    `telegram`  varchar(128),
    `avatar`    varchar(128),
    `rate`      float(3, 2) NOT NULL,
    `user_id`   int(10),
    `city_id`   int(10),
    KEY `city_id` (`city_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`),
    CONSTRAINT `profiles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `user_category`
(
    `id`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`      int(10) NOT NULL,
    `category_id`  int(10) NOT NULL,
    KEY `city_id` (`category_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `user_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    CONSTRAINT `user_category_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `status_task` (
    `id`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`  varchar(128) NOT NULL unique
    `type`  varchar(128) NOT NULL unique
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `tasks` (
    `id`                INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `dt_add`            timestamp DEFAULT current_timestamp() NOT NULL,
    `category_id`       int(10),
    `description`       text NOT NULL,
    `expire`            DATETIME,
    `name`              varchar(128) NOT NULL,
    `address`           varchar(128),
    `budget`            int(5),
    `lat`               float(3, 2),
    `long`              float(3, 2),
    `client_id`         int(10) NOT NULL,
    `status_task_id`    int(10) NOT NULL,
    `location_comment`  varchar(128),
    `city_id`           int(10),
    `doer_id`           int(10),
    KEY `category_id` (`category_id`),
    KEY `city_id` (`city_id`),
    KEY `doer_id` (`doer_id`),
    KEY `client_id` (`client_id`),
    CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES cities(`id`),
    CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`client_id`) REFERENCES users(`id`),
    CONSTRAINT `tasks_ibfk_5` FOREIGN KEY (`status_task_id`) REFERENCES status_task(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `favourites`
(
    `id`                   INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title`                varchar(128) NOT NULL,
    `dt_add`               timestamp DEFAULT current_timestamp() NOT NULL,
    `type_favourite`       varchar(128),
    `user_id`              int(10) NOT NULL,
    `favourite_person_id`  int(10) NOT NULL,
    KEY `user_id` (`user_id`),
    KEY `favourite_person_id` (`favourite_person_id`),
    CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`favourite_person_id`) REFERENCES users(`id`),
    CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `file_task`
(
    `id`         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `file_item`  varchar(128) NOT NULL,
    `task_id`    int(10) NOT NULL,
    KEY `task_id` (`task_id`),
    CONSTRAINT `file_task_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `messages`
(
    `id`         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `text`       text NOT NULL,
    `dt_add`     timestamp DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    `writer_id`  int(10) NOT NULL,
    `task_id`    int(10) NOT NULL,
    KEY `writer` (`writer_id`),
    KEY `task_id` (`task_id`),
    CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`writer_id`) REFERENCES users(`id`),
    CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `notifications`
(
    `id`       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title`    varchar(128) NOT NULL,
    `is_view`  TINYINT(1),
    `dt_add`   timestamp DEFAULT current_timestamp() NOT NULL,
    `type`     varchar(128) NOT NULL,
    `user_id`  int(10) NOT NULL,
    `task_id`  int(10) NOT NULL,
    KEY `user_id` (`user_id`),
    KEY `task_id` (`task_id`),
    CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `opinions`
(
    `id`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `dt_add`       timestamp NOT NULL DEFAULT current_timestamp() NOT NULL,
    `title`        varchar(128) NOT NULL,
    `description`  text NOT NULL,
    `rate`         decimal(3, 2),
    `writer_id`    int(10) NOT NULL,
    `task_id`      int(10) NOT NULL,
    KEY `writer_id` (`writer_id`),
    KEY `task_id` (`task_id`),
    CONSTRAINT `opinions_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    CONSTRAINT `opinions_ibfk_2` FOREIGN KEY (`writer_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `portfolio_photo`
(
    `id`       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `photo`    varchar(128) NOT NULL,
    `user_id`  int(10) NOT NULL,
    KEY `user_id` (`user_id`),
    CONSTRAINT `portfolio_photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `replies`
(
    `id`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `dt_add`       timestamp NOT NULL DEFAULT current_timestamp() NOT NULL,
    `rate`         float(3, 2),
    `description`  text NOT NULL,
    `title`        varchar(128) NOT NULL,
    `task_id`      int(10) NOT NULL,
    `doer_id`      int(10) NOT NULL,
    KEY `task_id` (`task_id`),
    KEY `doer_id` (`doer_id`),
    CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    CONSTRAINT `replies_ibfk_2taskforce` FOREIGN KEY (`doer_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
