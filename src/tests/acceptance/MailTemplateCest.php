<?php


use app\tests\pages\LoginPage;
use yii\helpers\Url;

class MailTemplateCest
{
    public function _before(AcceptanceTester $I)
    {
        $loginPage = LoginPage::openBy($I);
        $I->amGoingTo('submit login form with no data');
        $loginPage->login('neo', 'neo');
        $I->amOnPage(Url::toRoute('/mail-template/create'));
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function seeCreatingTemplateForm(FunctionalTester $I)
    {
        $I->see('Create Mail Template', 'h1');
        $I->see('', '#mailtemplate-name');
        $I->see('', '#mailtemplate-subject');
        $I->see('', '#mailtemplate-body');
        $I->see('Create', 'button[name="template-button"]');
    }

    public function createTemplateSuccessful(FunctionalTester $I)
    {
        $I->amGoingTo('try to fill form');
        $I->fillField('#mailtemplate-name', 'tester');
        $I->fillField('#mailtemplate-subject', 'tester subject');
        $I->fillField('#mailtemplate-body', 'tester body');
        $I->click('template-button');
        $I->dontSeeElement('#mailTemplateForm');
    }

    public function submitEmptyForm(FunctionalTester $I)
    {
        $I->fillField('#mailtemplate-name', '');
        $I->fillField('#mailtemplate-subject', '');
        $I->fillField('#mailtemplate-body', '');
        $I->expectTo('see validation error');
        $I->see('Name cannot be blank.');
    }
}
