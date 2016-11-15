<?php


class MailTemplateListCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/mail-template/list');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function seeTemplatesGrid(FunctionalTester $I)
    {
        $I->see('Mail Templates', 'h1');
        $I->see('firstTemplate', '.grid-view td');
        $I->see('template2', '.grid-view td');
        $I->see('template3', '.grid-view td');
    }

    public function seeCreateTemplateButton(FunctionalTester $I)
    {
        $I->see('Create Mail Template', '.btn');
    }
}
