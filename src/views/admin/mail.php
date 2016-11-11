<?php
use yii\widgets\Menu;

$this->title = Yii::t('mail', 'Mail admin page');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1>Mail Admin page</h1>

<?=  Menu::widget([
    'items' => [
        ['label' => \Yii::t('mail', 'E-mail templates'), 'url' => ['mail-template/list']],
        ['label' => \Yii::t('mail', 'Add template'), 'url' => ['mail-template/create']],

        ['label' => \Yii::t('mail', 'View mailings'), 'url' => ['mailing/list']],
        ['label' => \Yii::t('mail', 'Create Mailing'), 'url' => ['mailing/create']],

        ['label' => \Yii::t('mail', 'Send test e-mail'), 'url' => ['mail/send']],
    ],
]); ?>

