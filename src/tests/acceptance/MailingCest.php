<?php

use app\tests\pages\LoginPage;
use yii\helpers\Url;

class MailingCest
{
    public function _before(AcceptanceTester $I)
    {
        $loginPage = LoginPage::openBy($I);
        $I->amGoingTo('login on the site');
        $loginPage->login('neo', 'neo');
        $I->amOnPage(Url::toRoute('/mailing/create'));
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCreateMailingPage(FunctionalTester $I)
    {
        $I->see('Create Mailing', 'h1');
        $I->amOnPage(Url::toRoute('/mailing/create'));
    }

    public function seeTablesTemplates(FunctionalTester $I)
    {
        $I->seeRecord('app\models\tables\User', ['username' => 'testUser1']);
        $I->seeElement('.grid-view td');
        $I->see('testUser1');
        $I->see('firstTemplate', '#templatesGrid td');
        $I->expectTo('see fields for placeholders');
        $I->see('User name', 'label');
        $I->see('Location', 'label');
        $I->see('Date', 'label');
    }

    public function createMailingWithWrongUserAndWrongTemplate(\FunctionalTester $I)
    {
        $I->amGoingTo('submit form with wrong users');
        $I->submitForm('#mailingForm', [
            'MailingForm[templateId]' => 333,
            'MailingForm[dateSend]' => '2016-11-18 11:55',
            'MailingForm[usersId]' => json_encode(['333', '123']),
            'MailingForm[placeholders]' => json_encode(['date' => '2016-11-18 11:55', 'location' => 'kharkiv', 'user' => 'Vitia']),
        ]);
        $I->seeElement('#mailingForm');
        $I->see('Not all users exists');
    }

    public function createMailingWithEmptyDateAndEmptyUsers(\FunctionalTester $I)
    {
        $I->amGoingTo('submit form with empty data and users field');
        $I->submitForm('#mailingForm', [
            'MailingForm[templateId]' => 1,
            'MailingForm[dateSend]' => '',
            'MailingForm[usersId]' => json_encode([]),
            'MailingForm[placeholders]' => json_encode(['date' => '2016-11-18 11:55', 'location' => 'kharkiv', 'user' => 'Vitia']),
        ]);
        $I->seeElement('#mailingForm');
        $I->see('Date Send cannot be blank');
        $I->see('Please, choose users');
    }

    public function createMailing(FunctionalTester $I)
    {
        $I->amGoingTo('try to fill form');
        $I->submitForm('#mailingForm', [
            'MailingForm[templateId]' => 1,
            'MailingForm[dateSend]' => '2016-11-18 11:55',
            'MailingForm[usersId]' => json_encode(['1']),
            'MailingForm[placeholders]' => json_encode(['date' => '2016-11-18 11:55', 'location' => 'kharkiv', 'user' => 'Vitia']),
        ]);
        $I->dontSeeElement('Create Mailing');
        $I->dontSeeElement('#mailingForm');
        $I->see('Mailings');
    }

}
