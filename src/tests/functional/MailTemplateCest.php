<?php

class MailTemplateCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/mail-template/create');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function submitEmptyForm(FunctionalTester $I)
    {
        $I->see('Create Mail Template', 'h1');
        $I->submitForm('#mailTemplateForm', []);
        $I->expectTo('see validation error');
        $I->see('Name cannot be blank.');
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#mailTemplateForm', [
            'MailTemplate[name]' => 'tester',
            'MailTemplate[subject]' => 'tester subject',
            'MailTemplate[body]' => 'tester body',
        ]);
        $I->dontSeeElement('#mailTemplateForm');
        $I->see('Template Id is invalid.');
    }
}
