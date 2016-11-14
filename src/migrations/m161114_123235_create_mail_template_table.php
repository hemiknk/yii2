<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mail_template`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m161114_123235_create_mail_template_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mail_template', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'body' => $this->text(),
            'name' => $this->string(250)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'subject' => $this->string(255),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-mail_template-user_id',
            'mail_template',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mail_template-user_id',
            'mail_template',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-mail_template-user_id',
            'mail_template'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-mail_template-user_id',
            'mail_template'
        );

        $this->dropTable('mail_template');
    }
}
