<?php

namespace app\models\forms;

use app\models\tables\Mailing;
use app\models\tables\MailTemplate;
use Yii;
use yii\base\Model;

class MailingForm extends Model
{
    public $usersId = '';

    public $templateId = null;

    public $placeholders = null;

    public $status = null;

    public $dateSend = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usersId', 'templateId', 'dateSend'], 'required'],
            [['templateId', 'status'], 'integer'],
            [['placeholders'], 'string'],
            [['date_send'], 'safe'],
            [
                ['templateId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => MailTemplate::className(),
                'targetAttribute' => ['templateId' => 'id']
            ],
            [['placeholders'], 'string'],
            [['usersId'], 'usersExist'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'usersId' => 'Users Id',
        ];
    }

    public function usersExist($attribute, $params)
    {
        var_dump($attribute);
        if ($this->$attribute) {
            return true;
        }
        return false;
    }

    public function save()
    {
        foreach (json_decode($this->usersId, true) as $userId) {
            $mailing = $this->getMailingForUser($userId);
            $mailing->save();
        }
    }

    protected function getMailingForUser($userId)
    {
        $mailing = new Mailing();
        $mailing->attributes = $this->attributes;
        $mailing->user_id = $userId;
        $mailing->mail_template_id = $this->templateId;
        $mailing->date_send = $this->dateSend;
        $mailing->status = Mailing::ACTIVE;
        $mailing->placeholders = '';
        return $mailing;
    }

}