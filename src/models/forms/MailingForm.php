<?php

namespace app\models\forms;

use app\models\tables\Mailing;
use app\models\tables\MailTemplate;
use app\models\tables\User;
use Yii;
use yii\base\Model;
use yii\validators\ExistValidator;

class MailingForm extends Model
{
    /**
     * @var string json with users
     */
    public $usersId = '';

    /**
     * @var integer contains mail template id
     */
    public $templateId = null;

    /**
     * @var string placeholders for template
     */
    public $placeholders = null;

    /**
     * @var integer status of mailing for current user
     */
    public $status = null;

    /**
     * @var string datetime for sending email
     */
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usersId' => 'Users Id',
        ];
    }

    /**
     * Validator. If all users exist in system return true
     *
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function usersExist($attribute, $params)
    {
        $usersId = json_decode($this->$attribute, true);
        if (count($usersId) <= 0) {
            $this->addError($attribute, 'Please, choose users');
            return false;
        }
        $validator = new ExistValidator([
            'allowArray' => true,
            'skipOnError' => true,
            'targetClass' => User::className(),
            'targetAttribute' => 'id'
        ]);
        if (!$validator->validate($usersId)) {
            $this->addError($attribute, 'Not add users exists');
            return false;
        }
        return true;
    }

    /**
     * Save mailing info for users
     *
     * @return bool
     */
    public function save()
    {
        foreach (json_decode($this->usersId, true) as $userId) {
            $mailing = $this->getMailingForUser($userId);
            $mailing->save();
        }
        return true;
    }

    /**
     * Return Mailing object by user id
     *
     * @param $userId
     * @return Mailing
     */
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
