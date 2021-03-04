CREATE
DATABASE TaskForce DEFAULT CHARACTER SET UTF8 DEFAULT COLLATE UTF8_GENERAL_CI;
USE
TaskForce;
/*Пользователи*/
CREATE TABLE USERS
(
    id                        INT AUT0INCREMENT PRIMARY KEY,
    date_registration         DATE, /*дата регистрации пользователя формата 1900-01-01*/
    email                     char(128),
    password                  char(128),
    avatar                    char(128),
    name                      char(128),
    id_city                   char(128),
    birthday                  DATE, /*день рождения, формат 1900-01-01*/
    description               text, /*о себе*/
    rating                    decimal(3, 2), /*десятичная дробь - одна цифра целая часть, и две цифры после запятой */
    phone                     int(10),
    skype                     char(128),
    telegram                  char(128),
    alert_new_message         bull, /*оповещение о новом сообщении*/
    alert_action_task         bull, /*оповещение о действии по заданию*/
    alert_new_comment         bull, /*оповещение о новом отзыве*/
    show_contacts_only_client bull, /*показывать сонтакты только заказчику*/
    hide_my_account           bull /*не показывать мой профиль*/
)
/*Задания*/
CREATE TABLE tasks
(
    id               INT AUT0INCREMENT PRIMARY KEY,
    name             char(128),
    id_category      char(128),
    date             DATETIME, /*время создания задания вида 1900-01-01 00:00:00*/
    price            int(5),
    description      text,
    id_city          int(10),
    latitude         int(3), /* широта*/
    longitude        int(3), /* долгота*/
    address          char(128),
    location_comment char(128), /*комментарии о местоположении - как пройти, код домофона, квартира и т.д.*/
    status           char(128),
    id_doer          int(10), /*id исполнителя*/
    id_client        int(10), /*id заказчика*/
    deadline         DATETIME /*до какого времени надо выполнить*/
)
/*категории*/
CREATE TABLE categories
(
    id          INT AUT0INCREMENT PRIMARY KEY,
    name        char(128),
    work_online bool
)
/*Города*/
CREATE TABLE cities
(
    id   INT AUT0INCREMENT PRIMARY KEY,
    name char(128),
)
/*примеры работ пользователей*/
CREATE TABLE work_example
(
    id      INT AUT0INCREMENT PRIMARY KEY,
    id_user int(10),
    photo   char(128)
)
/*файлы задания*/
CREATE TABLE file_task
(
    id      INT AUT0INCREMENT PRIMARY KEY,
    id_task int(128),
    file    char(128),
)
/*сообщения*/
CREATE TABLE messages
(
    id        INT AUT0INCREMENT PRIMARY KEY,
    text      text,
    id_doer   int(10),
    id_client int(10),
    id_task   int(10),
    time      DATETIME /*время отправки сообщения*/
)
/*отклили*/
CREATE TABLE response_task
(
    id      INT AUT0INCREMENT PRIMARY KEY,
    id_task int(128),
    id_doer int(128),
    text    text,
    time    DATETIME, /*время отклика*/
)
/*категории пользователей*/
CREATE TABLE user_category
(
    id_user     int(10),
    id_category int(10)
)
/*отзывы*/
CREATE TABLE opinions
(
    id        INT AUT0INCREMENT PRIMARY KEY,
    text      text,
    id_doer   int(10),
    id_client int(10),
    id_task   int(10),
    time      DATETIME
)
