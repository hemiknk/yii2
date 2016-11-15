<?php
$db = require(__DIR__ . '/db.php');
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=localhost;dbname=vagrant_yii2_template_tests';
$db['username'] = 'root';
$db['password'] = '';
$db['class'] = 'yii\db\Connection';
return $db;