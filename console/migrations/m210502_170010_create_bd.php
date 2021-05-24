<?php

use yii\db\Migration;
use yii\db\Expression;

/**
 * Class m210502_170010_crate_bd
 */
class m210502_170010_create_bd extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'icon' => $this->string(255)->notNull()->unique(),
            'profession' => $this->string(255)->unique()
        ]);

        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'city' => $this->string(255)->notNull(),
            'latitude' => $this->string(255)->notNull(),
            'longitude' => $this->string(255)->notNull()
        ]);

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'user_role' => $this->string(255)->notNull(),
            'address' => $this->string(255),
            'bd' => $this->date(),
            'avatar' => $this->string(255),
            'about' => $this->text(),
            'phone' => $this->string(255),
            'skype' => $this->string(255),
            'telegram' => $this->string(255),
            'city_id' => $this->integer(11),
            'last_activity_time' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
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
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'category_id' => $this->integer(11)->notNull()
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

        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'category_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'expire' => $this->date(),
            'name' => $this->string(255)->notNull(),
            'address' => $this->string(255),
            'budget' => $this->integer(5),
            'latitude' => $this->string(255),
            'longitude' => $this->string(255),
            'location_comment' => $this->string(255),
            'city_id' => $this->integer(11),
            'doer_id' => $this->integer(11),
            'client_id' => $this->integer(11)->notNull(),
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
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'type_favourite' => $this->string(255),
            'user_id' => $this->integer(11)->notNull(),
            'favourite_person_id' => $this->integer(11)->notNull()
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
            'id' => $this->primaryKey(),
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
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'writer_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'writer_m_id',
            'messages',
            'writer_id',
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

        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'is_view' => $this->integer(1)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'type' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull()
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
            'task_n_id',
            'notifications',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('opinions', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'rate' => $this->float(3.2),
            'writer_id' => $this->integer(11)->notNull(),
            'about_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'writer_o_id',
            'opinions',
            'writer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'about_o_id',
            'opinions',
            'about_id',
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
            'id' => $this->primaryKey(),
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

        $this->createTable('replies', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'rate' => $this->float(3.2),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'doer_id' => $this->integer(11)->notNull(),
            'task_id' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey(
            'doer_r_id',
            'replies',
            'doer_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'task_r_id',
            'replies',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('user_search_form', [
            'id' => $this->primaryKey(),
            'free_now' => $this->integer(1)->notNull(),
            'online_now' => $this->integer(1)->notNull(),
            'has_opinions' => $this->integer(1)->notNull(),
            'is_favourite' => $this->integer(1)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('categories');
        $this->dropTable('cities');
        $this->dropTable('favourites');
        $this->dropTable('file_task');
        $this->dropTable('messages');
        $this->dropTable('notifications');
        $this->dropTable('opinions');
        $this->dropTable('portfolio_photo');
        $this->dropTable('profiles');
        $this->dropTable('replies');
        $this->dropTable('status_task');
        $this->dropTable('tasks');
        $this->dropTable('user_categories');
        $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210502_170010_crate_bd cannot be reverted.\n";

        return false;
    }
    */
}
