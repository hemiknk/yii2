<?php


use app\tests\pages\LoginPage;
use yii\helpers\Url;

class MailingCest
{
    public function _before(AcceptanceTester $I)
    {
        $loginPage = LoginPage::openBy($I);
        $I->amGoingTo('submit login form with no data');
        $loginPage->login('neo', 'neo');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCreateMailingPage(FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/mailing/create'));
        $I->see('Create Mailing', 'h1');
    }
}
