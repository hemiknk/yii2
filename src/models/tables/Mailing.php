<?php

namespace app\models\tables;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
 * @property User $user
 */
class Mailing extends ActiveRecord
{

    /**
     * Mail must be sending
     */
    const ACTIVE = 1;

    /**
     * Mail already send
     */
    const INACTIVE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailing';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mail_template_id'], 'required'],
            [['user_id', 'mail_template_id', 'status'], 'integer'],
            [['placeholders'], 'string'],
            [['date_send'], 'safe'],
            [
                ['mail_template_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => MailTemplate::className(),
                'targetAttribute' => ['mail_template_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mail', 'ID'),
            'user_id' => Yii::t('mail', 'User'),
            'mail_template_id' => Yii::t('mail', 'Mail Template'),
            'status' => Yii::t('mail', 'Status'),
            'placeholders' => Yii::t('mail', 'Placeholders'),
            'created_at' => Yii::t('mail', 'Created At'),
            'date_send' => Yii::t('mail', 'Date Send'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
