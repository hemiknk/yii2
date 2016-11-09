<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\tables\Mailing */

$this->title = Yii::t('mail', 'Create Mailing');
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mailings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>



