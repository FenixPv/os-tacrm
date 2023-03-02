<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 * @noinspection PhpUnused
 */
class m230301_190637_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'                   => $this->primaryKey(),
            'created_at'           => $this->integer()->notNull(),
            'updated_at'           => $this->integer()->notNull(),
            'login'                => $this->string()->notNull(),
            'email_confirm_token'  => $this->string(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email'                => $this->string()->notNull(),
            'status'               => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        $this->createIndex('idx-user-login', '{{%users}}', 'login', true);
        $this->createIndex('idx-user-email', '{{%users}}', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
