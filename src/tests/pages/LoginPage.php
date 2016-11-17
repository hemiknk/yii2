<?php

namespace app\tests\pages;

use yii\codeception\BasePage;
use app\models\LoginForm;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\AcceptanceTester|\tests\codeception\frontend\FunctionalTester|\tests\codeception\backend\AcceptanceTester|\tests\codeception\backend\FunctionalTester $actor
 */
class LoginPage extends BasePage
{
    public $route = '/user/login';

    /**
     * @param string $username
     * @param string $password
     */
    public function login($username, $password)
    {
        $loginForm = new LoginForm;

        $this->actor->fillField('input[name="' . $loginForm->formName() . '[email]"]', $username);
        $this->actor->fillField('input[name="' . $loginForm->formName() . '[password]"]', $password);
        $this->actor->click('.btn');
    }
}
