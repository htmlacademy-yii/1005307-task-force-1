CREATE
DATABASE IF NOT EXISTS TaskForce DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE UTF8_GENERAL_CI;
USE
TaskForce;

CREATE TABLE IF NOT EXISTS `categories`
(
    `id`    INT AUTO_INCREMENT PRIMARY KEY,
    `name`  varchar(128),
    `icon`  varchar(128)
);

CREATE TABLE IF NOT EXISTS `cities`
(
    `id`    INT AUTO_INCREMENT PRIMARY KEY,
    `city`  varchar(128),
    `lat`   DECIMAL(8, 6) DEFAULT NULL,
    `long`  DECIMAL(8, 6) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `users` (
    `id`        INT AUTO_INCREMENT PRIMARY KEY,
    `email`     varchar(128),
    `name`      varchar(128),
    `password`  varchar(128),
    `dt_add`    DATE
);

CREATE TABLE IF NOT EXISTS `profiles` (
    `id`        INT AUTO_INCREMENT PRIMARY KEY,
    `address`   varchar(128),
    `bd`        DATE,
    `about`     text,
    `phone`     int(10),
    `skype`     varchar(128),
    `telegram`  varchar(128),
    `user_id`   int(10),
    `city_id`   int(10),
    `avatar`    varchar(128),
    `rating`    decimal(3, 2),
    FOREIGN KEY (`city_id`) REFERENCES cities(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `user_category`
(
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`      int(10),
    `category_id`  int(10),
    FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `tasks` (
    `id`                INT AUTO_INCREMENT PRIMARY KEY,
    `dt_add`            DATETIME,
    `category_id`       int(10),
    `description`       text,
    `expire`            DATETIME,
    `name`              varchar(128),
    `city_id`           int(10),
    `address`           varchar(128),
    `budget`            int(5),
    `lat`               decimal(3, 2),
    `long`              decimal(3, 2),
    `location_comment`  varchar(128),
    `doer_id`           int(10),
    `client_id`         int(10),
    `statusTask`        varchar(128),
    FOREIGN KEY (`category_id`) REFERENCES categories(`id`),
    FOREIGN KEY (`city_id`) REFERENCES cities(`id`),
    FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    FOREIGN KEY (`client_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `favourites`
(
    `id`              INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`         int(10),
    `title`           varchar(128),
    `is_view`         TINYINT(1),
    `dt_add`          DATETIME,
    `type_favourite`  varchar(128),
    `task_id`         int(10),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `file_task`
(
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `task_id`    int(10),
    `file_item`  varchar(128),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
);

CREATE TABLE IF NOT EXISTS `messages`
(
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `doer_id`    int(10),
    `client_id`  int(10),
    `text`       text,
    `task_id`    int(10),
    `dt_add`     DATETIME,
    FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    FOREIGN KEY (`client_id`) REFERENCES users(`id`),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
);

CREATE TABLE IF NOT EXISTS `notifications`
(
    `id`       INT  AUTO_INCREMENT PRIMARY KEY,
    `user_id`  int(10),
    `task_id`  int(10),
    `title`    varchar(128),
    `is_view`  TINYINT(1),
    `dt_add`   DATETIME,
    `TYPE`     varchar(128),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`)
);

CREATE TABLE IF NOT EXISTS `opinions`
(
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `dt_add`       DATETIME,
    `title`        varchar(128),
    `description`  text,
    `rate`         decimal(3, 2),
    `doer_id`      int(10),
    `client_id`    int(10),
    `task_id`      int(10),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    FOREIGN KEY (`doer_id`) REFERENCES users(`id`),
    FOREIGN KEY (`client_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `portfolio_photo`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`  int(10),
    `photo`    varchar(128),
    FOREIGN KEY (`user_id`) REFERENCES users(`id`)
);

CREATE TABLE IF NOT EXISTS `replies`
(
    `id`           INT AUTO_INCREMENT PRIMARY KEY,
    `dt_add`       DATETIME,
    `rate`         decimal(3, 2),
    `description`  text,
    `task_id`      int(10),
    `doer_id`      int(10),
    `title`        varchar(128),
    FOREIGN KEY (`task_id`) REFERENCES tasks(`id`),
    FOREIGN KEY (`doer_id`) REFERENCES users(`id`)
);
