<?php

namespace tests\models;

use app\models\forms\MailingForm;
use app\models\tables\Mailing;
use Codeception\Test\Unit;

class MailFormTest extends Unit
{
    /**
     * @var MailingForm
     */
    private $model;

    public function testValidateUsersNotExist()
    {
        $this->model = new MailingForm([
            'usersId' => json_encode(['10', '11']),
            'templateId' =>  '1',
            'placeholders' => json_encode(['user' => 'Vasia', 'date' => '11.11.17']),
            'dateSend' => '2016-11-19 15:55',
            'status' => Mailing::ACTIVE,
        ]);
        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('usersId');
    }

    public function testValidateTemplateNotExist()
    {
        $this->model = new MailingForm([
            'usersId' => json_encode(['1']),
            'templateId' =>  '111',
            'placeholders' => json_encode(['user' => 'Vasia', 'date' => '11.11.17']),
            'dateSend' => '2016-11-19 15:55',
            'status' => Mailing::ACTIVE,
        ]);
        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('templateId');
    }

    public function testValidateWrongPlaceholders()
    {
        $this->model = new MailingForm([
            'usersId' => json_encode(['1']),
            'templateId' =>  '1',
            'placeholders' => json_encode(['time' => '12:15', 'date' => '11.11.17']),
            'dateSend' => '2016-11-19 15:55',
            'status' => Mailing::ACTIVE,
        ]);
        expect_not($this->model->validate());
        expect($this->model->errors)->hasKey('placeholders');
    }

    public function testValidateCorrectData()
    {
        $this->model = new MailingForm([
            'usersId' => json_encode(['1']),
            'templateId' =>  '1',
            'placeholders' => json_encode(['user' => 'Vasia', 'date' => '11.11.17']),
            'dateSend' => '2016-11-19 15:55',
            'status' => Mailing::ACTIVE,
        ]);
        expect_that($this->model->validate());
        expect($this->model->errors)->isEmpty('placeholders');
    }
}
