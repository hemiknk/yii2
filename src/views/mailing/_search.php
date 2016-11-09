<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\MailingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'mail_template_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'placeholders') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'date_send') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('mail', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('mail', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
