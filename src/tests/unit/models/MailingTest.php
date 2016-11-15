<?php

namespace tests\models;

use app\models\tables\Mailing;
use Codeception\Test\Unit;

class MailingTest extends Unit
{
    public function testGetUserModel()
    {
        expect_that($mailing = Mailing::find()->where(['id' => 1])->one());
        expect($mailing->user)->isInstanceOf('app\models\tables\User');
    }

    public function testGetMailTemplateModel()
    {
        expect_that($mailing = Mailing::find()->where(['id' => 1])->one());
        expect($mailing->mailTemplate)->isInstanceOf('app\models\tables\MailTemplate');
    }

    public function testGetMailingModel()
    {
        expect_that($mailing = Mailing::find()->where(['id' => 1])->one());
        expect($mailing)->isInstanceOf('app\models\tables\Mailing');
    }

    public function testFindMailingNotExist()
    {
        $template = Mailing::find()->where(['id' => 222])->one();
        expect($template)->null();
    }
}
