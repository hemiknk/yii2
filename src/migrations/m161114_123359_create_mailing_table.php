<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mailing`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `mail_template`
 */
class m161114_123359_create_mailing_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mailing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'mail_template_id' => $this->integer()->notNull(),
            'status' => $this->integer(2)->defaultValue(1),
            'placeholders' => $this->text(),
            'created_at' => $this->integer(11),
            'date_send' => $this->timestamp(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-mailing-user_id',
            'mailing',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mailing-user_id',
            'mailing',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `mail_template_id`
        $this->createIndex(
            'idx-mailing-mail_template_id',
            'mailing',
            'mail_template_id'
        );

        // add foreign key for table `mail_template`
        $this->addForeignKey(
            'fk-mailing-mail_template_id',
            'mailing',
            'mail_template_id',
            'mail_template',
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
            'fk-mailing-user_id',
            'mailing'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-mailing-user_id',
            'mailing'
        );

        // drops foreign key for table `mail_template`
        $this->dropForeignKey(
            'fk-mailing-mail_template_id',
            'mailing'
        );

        // drops index for column `mail_template_id`
        $this->dropIndex(
            'idx-mailing-mail_template_id',
            'mailing'
        );

        $this->dropTable('mailing');
    }
}
