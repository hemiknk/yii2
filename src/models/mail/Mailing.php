<?php

namespace app\models\mail;

class Mailing
{
    /**
     * Array with users email's to send
     * @var array
     */
    protected $to = [];

    /**
     * From email address
     * @var string
     */
    protected $from = '';

    protected $subject = '';

    protected $body = '';

    /**
     * @return array
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    protected function init()
    {
        $this->from = \Yii::$app->user->identity->email;
    }

}