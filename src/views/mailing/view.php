<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\tables\Mailing */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mail Admin page', 'url' => ['admin/mail']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mailings'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('mail', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('mail', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('mail', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'mail_template_id',
            'status',
            'placeholders:ntext',
            'created_at',
            'date_send',
        ],
    ]) ?>

</div>
