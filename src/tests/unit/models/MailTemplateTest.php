<?php

namespace tests\models;

use app\models\tables\MailTemplate;
use Codeception\Test\Unit;

class MailTemplateTest extends Unit
{
    public function testGetTemplateList()
    {
        expect_that($templateList = MailTemplate::getTemplatesList());
        expect($templateList)->count(3);
    }

    public function testGetUserModel()
    {
        expect_that($mailTemplate = MailTemplate::find()->where(['id' => 1])->one());
        expect($mailTemplate->user)->isInstanceOf('app\models\tables\User');
    }

    public function testGetMailingsModel()
    {
        $mailTemplate = MailTemplate::find()->where(['id' => 1])->one();
        expect($mailTemplate->mailings[0])->isInstanceOf('app\models\tables\Mailing');
    }

    public function testFindTemplateNotExist()
    {
        $template = MailTemplate::find()->where(['id' => 222])->one();
        expect($template)->null();
    }

    public function testFindTemplate()
    {
        $template = MailTemplate::find()->where(['id' => 1])->one();
        expect($template)->isInstanceOf('app\models\tables\MailTemplate');
    }
}
