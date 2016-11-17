<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\tables\MailTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-template-form">

    <?php $form = ActiveForm::begin(['id' => 'mailTemplateForm']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'body')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'full'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('mail', 'Create') : Yii::t('mail', 'Update'),
            [
                'name' => 'template-button',
                'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
