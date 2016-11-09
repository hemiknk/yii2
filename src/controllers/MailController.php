<?php

namespace app\controllers;

use app\models\mail\Mailing;
use yii\web\Controller;

class MailController extends Controller
{
    public function actionSend()
    {
        $manager = new Mailing();

        \Yii::$app->mailer->compose()
            ->setFrom($manager->getFrom())
            ->setTo($manager->getTo())
            ->setSubject($manager->getSubject())
            ->setHtmlBody($manager->getBody())
            ->send();
    }

}