<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\tables\MailTemplate */

$this->title = Yii::t('mail', 'Update {modelClass}: ', [
    'modelClass' => 'Mail Template',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mail Admin page', 'url' => ['admin/mail']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('mail', 'Update');
?>
<div class="mail-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
