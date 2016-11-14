<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\tables\MailingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('mail', 'Mailings');
$this->params['breadcrumbs'][] = ['label' => 'Mail Admin page', 'url' => ['admin/mail']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('mail', 'Create Mailing'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user.username',
            'mailTemplate.name',
            'status',
            'placeholders:ntext',
             'created_at:datetime',
             'date_send:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
