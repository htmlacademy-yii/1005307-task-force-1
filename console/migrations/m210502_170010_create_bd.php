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
            'name' => $this->string(128)->notNull()->unique(),
            'icon' => $this->string(128)->notNull()->unique(),
            'profession' => $this->string(128)->unique()
        ]);

        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'city' => $this->string(128)->notNull()->unique(),
            'lat' => $this->float(8.6)->notNull()->unique(),
            'long' => $this->float(8.6)->notNull()->unique()
        ]);

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string(128)->notNull()->unique(),
            'name' => $this->string(128)->notNull()->unique(),
            'password' => $this->string(128)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
        ]);

        $this->createTable('profiles', [
            'id' => $this->primaryKey(),
            'address' => $this->string(128),
            'bd' => $this->date(),
            'avatar' => $this->string(128),
            'about' => $this->text(),
            'phone' => $this->integer(10)->unsigned(),
            'skype' => $this->string(128),
            'telegram' => $this->string(128),
            'rate' => $this->float(3.2)->unsigned(),
            'user_id' => $this->integer(11)->notNull(),
            'city_id' => $this->integer(11)
        ]);

        $this->addForeignKey(
            'user_id',
            'profiles',
            'user_id',
            'users',
            'id',
            'cascade'
        );

        $this->addForeignKey(
            'city_id',
            'profiles',
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


        $this->createTable('status_task', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull()->unique()
        ]);

        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'category_id' => $this->integer(11),
            'description' => $this->text()->notNull(),
            'expire' => $this->date(),
            'name' => $this->string(128)->notNull(),
            'address' => $this->string(128),
            'budget' => $this->integer(5),
            'lat' => $this->float(8.6),
            'long' => $this->float(8.6),
            'location_comment' => $this->string(128),
            'city_id' => $this->integer(11),
            'doer_id' => $this->integer(11),
            'client_id' => $this->integer(11)->notNull(),
            'status_task_id' => $this->integer(11)->notNull()
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

        $this->addForeignKey(
            'status_task_id',
            'tasks',
            'status_task_id',
            'status_task',
            'id',
            'CASCADE'
        );

        $this->createTable('favourites', [
            'id' => $this->primaryKey(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'type_favourite' => $this->string(128),
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
            'file_item' => $this->string(128)->notNull(),
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
            'title' => $this->string(128)->notNull(),
            'is_view' => $this->integer(1)->notNull(),
            'dt_add' => $this->timestamp()->notNull()->defaultValue(new Expression('NOW()')),
            'type' => $this->string(128)->notNull(),
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
            'title' => $this->string(128)->notNull(),
            'description' => $this->text()->notNull(),
            'rate' => $this->float(3.2),
            'writer_id' => $this->integer(11)->notNull(),
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
            'task_o_id',
            'opinions',
            'task_id',
            'tasks',
            'id',
            'CASCADE'
        );

        $this->createTable('portfolio_photo', [
            'id' => $this->primaryKey(),
            'photo' => $this->string(128)->notNull(),
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
            'title' => $this->string(128)->notNull(),
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
