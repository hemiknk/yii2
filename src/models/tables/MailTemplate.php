<?php

namespace app\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mail_template".
 *
 * @property integer $id
 * @property integer $user_id
 * @property resource $body
 * @property string $name
 * @property integer $created_at
 * @property string $subject
 *
 * @property Mailing[] $mailings
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['body'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mail', 'ID'),
            'user_id' => Yii::t('mail', 'User ID'),
            'body' => Yii::t('mail', 'Body'),
            'name' => Yii::t('mail', 'Name'),
            'created_at' => Yii::t('mail', 'Created At'),
            'subject' => Yii::t('mail', 'Subject'),
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailings()
    {
        return $this->hasMany(Mailing::className(), ['mail_template_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MailTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailTemplateQuery(get_called_class());
    }
}
