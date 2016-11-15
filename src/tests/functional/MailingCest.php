<?php


class MailingCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/mailing/create');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeCreateMailingPage(FunctionalTester $I)
    {
        $I->see('Create Mailing', 'h1');
    }

    public function seeTablesWithUsers(FunctionalTester $I)
    {
        $I->see('testUser1', '.grid-view td');
    }

    public function seeTablesTemplates(FunctionalTester $I)
    {
        $I->see('firstTemplate', '#templatesGrid td');
        $I->expectTo('see fields for placeholders');
        $I->see('User name', 'label');
        $I->see('Location', 'label');
        $I->see('Date', 'label');
    }

    public function seeSubmitButton(FunctionalTester $I)
    {
        $I->see('Save', '#createMailing');
    }

    public function createMailingSuccessful(\FunctionalTester $I)
    {
        $I->submitForm('#mailingForm', [
            'MailingForm[templateId]' => 1,
            'MailingForm[dateSend]' => '2016-11-18 11:55',
            'MailingForm[usersId]' => json_encode(['1']),
            'MailingForm[placeholders]' => json_encode(['date' => '2016-11-18 11:55', 'location' => 'kharkiv', 'user' => 'Vitia']),
        ]);
        $I->dontSeeElement('#mailingForm');
        $I->see('Mailings');
    }

    public function createMailingWithWrongUserAndWrongTemplate(\FunctionalTester $I)
    {
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
}
