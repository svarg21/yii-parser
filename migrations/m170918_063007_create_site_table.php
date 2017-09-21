<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site`.
 */
class m170918_063007_create_site_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createTable('site', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'url' => $this->string(),
            'text' => $this->string(),
            'result' => $this->string(),
            'tag' => $this->string(),
            'creation_time'=>$this->dateTime()
        ]);
        $this->createIndex('FK_site_user', 'site', 'user_id');
        $this->addForeignKey(
            'FK_site_user', 'site', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('site');
        $this->dropTable('user');
    }
}
