<?php


use app\tests\pages\LoginPage;
use yii\helpers\Url;

class MailTemplateListCest
{
    public function _before(AcceptanceTester $I)
    {
        $loginPage = LoginPage::openBy($I);
        $I->amGoingTo('submit login form with no data');
        $loginPage->login('neo', 'neo');
        $I->amOnPage(Url::toRoute('/mail-template/list'));
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCreateTemplateButton(FunctionalTester $I)
    {
        $I->see('Create Mail Template', '.btn');
    }

    public function seeTemplatesGrid(FunctionalTester $I)
    {
        $I->see('Mail Templates', 'h1');
        $I->see('firstTemplate', '.grid-view td');
        $I->see('Name', '.grid-view th');
        $I->see('Author', '.grid-view th');
        $I->see('Subject', '.grid-view th');
        $I->see('template2', '.grid-view td');
        $I->see('template3', '.grid-view td');
    }
}
