<?php

use app\models\tables\Mailing;
use app\models\tables\MailTemplate;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Mailing */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'mail_template_id')->dropDownList(MailTemplate::getTemplatesList()) ?>

    <?= $form->field($model, 'status')->dropDownList([
        Mailing::ACTIVE => \Yii::t('mail', 'Active'),
        Mailing::INACTIVE => \Yii::t('mail', 'Not active'),
    ], [
        'prompt' => \Yii::t('mail', 'Choose status'),
    ]) ?>

    <?= $form->field($model, 'placeholders')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_send')->widget(DateTimePicker::className(), [
        'options' => ['placeholder' => \Yii::t('mail', 'Enter send time')],
        'pluginOptions' => [
            'autoclose' => true,
            'startDate' => date("yy-mm-dd"),
            'minDate' => false,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('mail', 'Create') : Yii::t('mail', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
