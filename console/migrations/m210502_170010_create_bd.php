<?php

use yii\db\Expression;
use yii\db\Migration;

class m210502_170010_create_bd extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'icon' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull()->unique(),
            'profession' => $this->string(255)->unique(),
        ]);

        $this->createTable('cities', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'city' => $this->string(255)->notNull()->unique(),
            'latitude' => $this->string(255)->notNull(),
            'longitude' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull()->unique(),
        ]);

        $this->createTable('users', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'about' => $this->text(),
            'avatar' => $this->string(255),
            'birthday' => $this->date(),
            'city_id' => $this->integer(11)->notNull(),
            'created_tasks' => $this->integer(11)->defaultValue(0)->notNull(),
            'done_tasks' => $this->integer(11)->defaultValue(0)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()'))->notNull(),
            'email' => $this->string(255)->notNull()->unique(),
            'failed_tasks' => $this->integer(11)->defaultValue(0)->notNull(),
            'last_activity_time' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'name' => $this->string(255)->notNull(),
            'opinions_count' => $this->integer(11)->defaultValue(0)->notNull(),
            'password' => $this->string(255)->notNull(),
            'phone' => $this->string(255),
            'rating' => $this->float(3.2),
            'skype' => $this->string(255),
            'telegram' => $this->string(255),
            'user_role' => $this->string(255)->notNull(),
            'vk_id' => $this->string(255),
        ]);

        $this->addForeignKey(
            'city_id',
            'users',
            'city_id',
            'cities',
            'id',
            'CASCADE'
        );

        $this->createTable('user_category', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'category_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'user_cat_id',
            'user_category',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'category_us_id',
            'user_category',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->createTable('user_option_set', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'is_hidden_account' => $this->integer(1)->notNull(),
            'is_hidden_contacts' => $this->integer(1)->notNull(),
            'is_subscribed_actions' => $this->integer(1)->notNull(),
            'is_subscribed_messages' => $this->integer(1)->notNull(),
            'is_subscribed_reviews' => $this->integer(1)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            ]);

        $this->addForeignKey(
            'user_opt_id',
            'user_option_set',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createTable('tasks', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'address' => $this->string(255),
            'budget' => $this->integer(5),
            'category_id' => $this->integer(11)->notNull(),
            'city_id' => $this->integer(11),
            'client_id' => $this->integer(11)->notNull(),
            'description' => $this->text()->notNull(),
            'doer_id' => $this->integer(11),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'expire' => $this->date(),
            'latitude' => $this->string(255),
            'longitude' => $this->string(255),
            'name' => $this->string(255)->notNull(),
            'online' => $this->integer(11)->notNull(),
            'responses_count' => $this->integer(1)->defaultValue(0)->notNull(),
            'status_task' => $this->string(255)->notNull(),
        ]);

        $this->addForeignKey(
            'category_t_id',
            'tasks',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'city_t_id',
            'tasks',
            'city_id',
            'cities',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'doer_t_id',
            'tasks',
            'doer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'client_t_id',
            'tasks',
            'client_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createTable('favourites', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'favourite_person_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'user_f_id',
            'favourites',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'favourite_person_id',
            'favourites',
            'favourite_person_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createTable('file_task', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'file_item' => $this->string(255)->notNull(),
            'task_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'task_ft_id',
            'file_task',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('messages', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'message' => $this->text()->notNull(),
            'published_at' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'recipient_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
            'unread' => $this->integer(1)->notNull(),
            'writer_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'user_m_id',
            'messages',
            'writer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'user_mr_id',
            'messages',
            'recipient_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'task_m_id',
            'messages',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('notifications_categories', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'name' => $this->string(255)->notNull()->unique(),
            'type' => $this->string(255)->notNull(),
        ]);

        $this->createTable('notifications', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'notification_category_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'visible' => $this->integer(1)->notNull()
        ]);

        $this->addForeignKey(
            'user_n_id',
            'notifications',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'notification_category_id',
            'notifications',
            'notification_category_id',
            'notifications_categories',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'task_n_id',
            'notifications',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('opinions', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'client_id' => $this->integer(11)->notNull(),
            'completion' => $this->integer(1)->notNull(),
            'description' => $this->text(),
            'doer_id' => $this->integer(11)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'rate' => $this->integer(1),
            'task_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'doer_o_id',
            'opinions',
            'doer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'client_o_id',
            'opinions',
            'client_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'task_o_id',
            'opinions',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('portfolio_photo', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'photo' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'user_pp_id',
            'portfolio_photo',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->createTable('responses', [
            'id' => $this->primaryKey(11)->notNull() .' AUTO_INCREMENT',
            'budget' => $this->integer(5)->notNull(),
            'comment' => $this->text()->notNull(),
            'doer_id' => $this->integer(11)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'is_refused' => $this->integer(1)->notNull(),
            'task_id' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            'doer_r_id',
            'responses',
            'doer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'task_r_id',
            'responses',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('categories');
        $this->dropTable('cities');
        $this->dropTable('favourites');
        $this->dropTable('file_task');
        $this->dropTable('messages');
        $this->dropTable('notifications');
        $this->dropTable('notifications_categories');
        $this->dropTable('opinions');
        $this->dropTable('portfolio_photo');
        $this->dropTable('responses');
        $this->dropTable('tasks');
        $this->dropTable('users');
        $this->dropTable('user_categories');
    }
}
