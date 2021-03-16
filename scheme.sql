CREATE
DATABASE IF NOT EXISTS TaskForce DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE UTF8_GENERAL_CI;
USE
TaskForce;

CREATE TABLE IF NOT EXISTS categories (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name_categories varchar(128),
    work_online     TINYINT(1)
);

CREATE TABLE IF NOT EXISTS cities
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    name_city varchar(128)
);

CREATE TABLE IF NOT EXISTS favourites
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    user_id        int(10),
    title          varchar(128),
    is_view        TINYINT(1),
    createTime     DATETIME,
    type_favourite varchar(128),
    task_id        int(10)
);

CREATE TABLE IF NOT EXISTS file_task
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    task_id   int(10),
    file_item varchar(128)
);

CREATE TABLE IF NOT EXISTS messages
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    text        text,
    doer_id     int(10),
    client_id   int(10),
    task_id     int(10),
    time_create DATETIME
);

CREATE TABLE IF NOT EXISTS notifications
(
id INT AUTO_INCREMENT PRIMARY KEY,
user_id int(10),
title varchar(128),
is_view TINYINT(1),
createTime DATETIME,
type varchar(128),
task_id int(10)
);

CREATE TABLE IF NOT EXISTS opinions
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    title        varchar(128),
    text_opinion text,
    doer_id      int(10),
    client_id    int(10),
    task_id      int(10),
    time_create  DATETIME
);

CREATE TABLE IF NOT EXISTS portfolio_photo
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    user_id int(10),
    photo   varchar(128)
);

CREATE TABLE IF NOT EXISTS response_task
(
    id            INT AUTO_INCREMENT PRIMARY KEY,
    task_id       int(10),
    doer_id       int(10),
    title         varchar(128),
    text_response text,
    time_create   DATETIME
);


CREATE TABLE IF NOT EXISTS tasks (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    name_task         varchar(128),
    id_category      int(10),
    date_create      DATETIME,
    price            int(5),
    description      text,
    city_id          int(10),
    latitude         int(3),
    longitude        int(3),
    address          varchar(128),
    location_comment varchar(128),
    statusTask       varchar(128),
    doer_id          int(10),
    client_id        int(10),
    deadline         DATETIME
);


CREATE TABLE IF NOT EXISTS USERS (
    id                        INT AUTO_INCREMENT PRIMARY KEY,
    date_registration         DATE,
    email                     varchar(128),
    user_password             varchar(128),
    avatar                    varchar(128),
    name_user                 varchar(128),
    city_id                   int(10),
    birthday                  DATE,
    description               text,
    rating                    decimal(3, 2),
    phone                     int(10),
    skype                     varchar(128),
    telegram                  varchar(128),
    alert_new_message         TINYINT(1),
    alert_action_task         TINYINT(1),
    alert_new_comment         TINYINT(1),
    show_contacts_only_client TINYINT(1),
    hide_my_account           TINYINT(1)
);

CREATE TABLE IF NOT EXISTS user_category
(
    user_id     int(10),
    category_id int(10)
);
