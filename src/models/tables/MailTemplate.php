<?php

namespace app\models\tables;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property User $user
 * @property Mailing[] $mailings
 */
class MailTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_template';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['body'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['subject'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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

    /**
     * Create array with templates name
     *
     * @return array
     */
    public static function getTemplatesList()
    {
        $parents = self::find()
            ->select(['id', 'name'])
            ->distinct(true)
            ->all();
        return ArrayHelper::map($parents, 'id', 'name');
    }
}
