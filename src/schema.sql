CREATE
DATABASE IF NOT EXISTS TaskForce DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE UTF8_GENERAL_CI;
USE
TaskForce;

CREATE TABLE IF NOT EXISTS `categories`
(
    `id`          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `icon`        varchar(128) NOT NULL unique,
    `name`        varchar(128) NOT NULL unique,
    `profession`  varchar(128) unique
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `cities`
(
    `id`         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `city`       varchar(128) NOT NULL unique,
    `latitude`   varchar(128) NOT NULL,
    `longitude`  varchar(128) NOT NULL,
    `value`      varchar(128) NOT NULL unique
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `users` (
    `id`                  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `avatar`              varchar(128),
    `about`               text,
    `birthday`            DATE,
    `city_id`             int(10) NOT NULL,
    `created_tasks`       int(11) NOT NULL DEFAULT 0,
    `done_tasks`          int(11) NOT NULL DEFAULT 0,
    `dt_add`              timestamp DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    `email`               varchar(128) NOT NULL unique,
    `failed_tasks`        int(11) NOT NULL DEFAULT 0,
    `last_activity_time`  timestamp DEFAULT current_timestamp() NOT NULL,
    `name`                varchar(128) NOT NULL,
    `opinions_count`      int(10) NOT NULL DEFAULT 0,
    `password`            varchar(128) NOT NULL,
    `phone`               varchar(128),
    `rating`              float(3, 2),
    `skype`               varchar(128),
    `telegram`            varchar(128),
    `user_role`           varchar(128) NOT NULL,
    `vk_id`               varchar(128),
    KEY `city_id` (`city_id`),
    CONSTRAINT `city_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `user_category`
(
    `id`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `category_id`  int(10) NOT NULL,
    `user_id`      int(10) NOT NULL,
    KEY `category_id` (`category_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `user_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    CONSTRAINT `user_category_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `user_option_set`
(
    `id`                      INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `is_hidden_account`       TINYINT(1) NOT NULL,
    `is_hidden_contacts`      TINYINT(1) NOT NULL,
    `is_subscribed_actions`   TINYINT(1) NOT NULL,
    `is_subscribed_messages`  TINYINT(1) NOT NULL,
    `is_subscribed_reviews`   TINYINT(1) NOT NULL,
    `user_id`                 int(10) NOT NULL,
    KEY `user_id` (`user_id`),
    CONSTRAINT `user_option_set_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `tasks` (
    `id`               INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `address`          varchar(128),
    `budget`           int(5),
    `category_id`      int(10) NOT NULL,
    `city_id`          int(10),
    `client_id`        int(10) NOT NULL,
    `description`      text NOT NULL,
    `doer_id`          int(10),
    `dt_add`           timestamp DEFAULT current_timestamp() NOT NULL,
    `expire`           DATETIME,
    `latitude`         varchar(128),
    `longitude`        varchar(128),
    `name`             varchar(128) NOT NULL,
    `online`           TINYINT(1) NOT NULL,
    `responses_count`  int(10) DEFAULT 0 NOT NULL,
    `status_task`      varchar(128) NOT NULL,
    KEY `category_id` (`category_id`),
    KEY `city_id` (`city_id`),
    KEY `client_id` (`client_id`),
    KEY `doer_id` (`doer_id`),
    CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES cities(`id`),
    CONSTRAINT `tasks_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES users(`id`),
    CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`doer_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `favourites`
(
    `id`                   INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `dt_add`               timestamp DEFAULT current_timestamp() NOT NULL,
    `favourite_person_id`  int(10) NOT NULL,
    `user_id`              int(10) NOT NULL,
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
    `id`            INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `message`       text NOT NULL,
    `published_at`  timestamp DEFAULT CURRENT_TIMESTAMP() NOT NULL,
    `recipient_id`  int(10) NOT NULL,
    `task_id`       int(10) NOT NULL,
    `unread`        TINYINT(1) NOT NULL,
    `writer_id`     int(10) NOT NULL,
    KEY `recipient_id` (`recipient_id`),
    KEY `task_id` (`task_id`),
    KEY `writer_id` (`writer_id`),
    CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES tasks(`id`),
    CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`writer_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `notifications_categories`
(
    `id`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`  varchar(128) NOT NULL,
    `type`  varchar(128) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
CREATE TABLE IF NOT EXISTS `notifications`
(
    `id`                        INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `dt_add`                    timestamp DEFAULT current_timestamp() NOT NULL,
    `notification_category_id`  varchar(128) NOT NULL,
    `task_id`                   int(10) NOT NULL,
    `user_id`                   int(10) NOT NULL,
    `visible`                   TINYINT(1) NOT NULL,
    KEY `notification_category_id` (`notification_category_id`),
    KEY `task_id` (`task_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES notifications_categories(`id`),
    CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `opinions`
(
    `id`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `client_id`    int(10) NOT NULL,
    `completion`   TINYINT(1) NOT NULL,
    `description`  text,
    `doer_id`      int(10) NOT NULL,
    `dt_add`       timestamp NOT NULL DEFAULT current_timestamp() NOT NULL,
    `rate`         TINYINT(1) NOT NULL,
    `task_id`      int(10) NOT NULL,
    KEY `client_id` (`client_id`),
    KEY `doer_id` (`doer_id`),
    KEY `task_id` (`task_id`),
    CONSTRAINT `opinions_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES users(`id`),
    CONSTRAINT `opinions_ibfk_2` FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    CONSTRAINT `opinions_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `portfolio_photo`
(
    `id`       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `photo`    varchar(128) NOT NULL,
    `user_id`  int(10) NOT NULL,
    KEY `user_id` (`user_id`),
    CONSTRAINT `portfolio_photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES users(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

CREATE TABLE IF NOT EXISTS `responses`
(
    `id`          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `budget`      int(5) NOT NULL,
    `comment`     text NOT NULL,
    `doer_id`     int(10) NOT NULL,
    `dt_add`      timestamp NOT NULL DEFAULT current_timestamp() NOT NULL,
    `is_refused`  TINYINT(1) NOT NULL,
    `task_id`     int(10) NOT NULL,
    KEY `doer_id` (`doer_id`),
    KEY `task_id` (`task_id`),
    CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
