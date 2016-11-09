<?php

namespace app\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mailing".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $mail_template_id
 * @property integer $status
 * @property string $placeholders
 * @property integer $created_at
 * @property string $date_send
 *
 * @property MailTemplate $mailTemplate
 */
class Mailing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'mail_template_id'], 'required'],
            [['user_id', 'mail_template_id', 'status', 'created_at'], 'integer'],
            [['placeholders'], 'string'],
            [['date_send'], 'safe'],
            [['mail_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailTemplate::className(), 'targetAttribute' => ['mail_template_id' => 'id']],
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
            'mail_template_id' => Yii::t('mail', 'Mail Template ID'),
            'status' => Yii::t('mail', 'Status'),
            'placeholders' => Yii::t('mail', 'Placeholders'),
            'created_at' => Yii::t('mail', 'Created At'),
            'date_send' => Yii::t('mail', 'Date Send'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplate()
    {
        return $this->hasOne(MailTemplate::className(), ['id' => 'mail_template_id']);
    }

    /**
     * @inheritdoc
     * @return MailingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailingQuery(get_called_class());
    }
}
