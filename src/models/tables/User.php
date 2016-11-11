<?php

namespace app\models\tables;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $status
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $logged_in_ip
 * @property string $logged_in_at
 * @property string $created_ip
 * @property string $created_at
 * @property string $updated_at
 * @property string $banned_at
 * @property string $banned_reason
 *
 * @property MailTemplate[] $mailTemplates
 * @property Mailing[] $mailings
 * @property Profile[] $profiles
 * @property Role $role
 * @property UserAuth[] $userAuths
 * @property UserToken[] $userTokens
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'status'], 'required'],
            [['role_id', 'status'], 'integer'],
            [['logged_in_at', 'created_at', 'updated_at', 'banned_at'], 'safe'],
            [['email', 'username', 'password', 'auth_key', 'access_token', 'logged_in_ip', 'created_ip', 'banned_reason'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
//            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mail', 'ID'),
            'role_id' => Yii::t('mail', 'Role ID'),
            'status' => Yii::t('mail', 'Status'),
            'email' => Yii::t('mail', 'Email'),
            'username' => Yii::t('mail', 'Username'),
            'password' => Yii::t('mail', 'Password'),
            'auth_key' => Yii::t('mail', 'Auth Key'),
            'access_token' => Yii::t('mail', 'Access Token'),
            'logged_in_ip' => Yii::t('mail', 'Logged In Ip'),
            'logged_in_at' => Yii::t('mail', 'Logged In At'),
            'created_ip' => Yii::t('mail', 'Created Ip'),
            'created_at' => Yii::t('mail', 'Created At'),
            'updated_at' => Yii::t('mail', 'Updated At'),
            'banned_at' => Yii::t('mail', 'Banned At'),
            'banned_reason' => Yii::t('mail', 'Banned Reason'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailTemplates()
    {
        return $this->hasMany(MailTemplate::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailings()
    {
        return $this->hasMany(Mailing::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }
}
