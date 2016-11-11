<?php

namespace app\models\forms;

use app\models\tables\Mailing;
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
//            [['usersId'], 'usersExist'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'usersId' => 'Users Id',
        ];
    }

    public function save()
    {
        $errors = '';
        foreach (json_decode($this->usersId, true) as $userId) {
            $mailing = $this->getMailing($userId);
            if (!$mailing->validate()) {
                $errors = $mailing->getErrors();
                continue;
            }
            $mailing->save();
        }

        return $errors;
    }

    protected function getMailing($userId)
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