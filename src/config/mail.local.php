<?php
return [
    'class' => 'yii\swiftmailer\Mailer',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => true,
    /*'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'goodeveningproj@gmail.com',
        'password' => 'good@evening',
        'port' => '587',
        'encryption' => 'tls',
    ],*/
];