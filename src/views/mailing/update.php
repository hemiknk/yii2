<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Mailing */

$this->title = Yii::t('mail', 'Update {modelClass}: ', [
    'modelClass' => 'Mailing',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mailings'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('mail', 'Update');
?>
<div class="mailing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
