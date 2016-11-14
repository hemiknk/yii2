<?php

use app\models\tables\User;
use drsdre\wizardwidget\WizardWidget;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $mailing app\models\tables\Mailing */

$this->title = Yii::t('mail', 'Create Mailing');
$this->params['breadcrumbs'][] = ['label' => 'Mail Admin page', 'url' => ['admin/mail']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('mail', 'Mailings'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'mailingForm']); ?>
    <?= Html::activeLabel($mailing, 'templateId'); ?>
    <?= Html::error($mailing, 'templateId', ['style' => 'color: red;', 'class' => 'has-error']); ?>
    <?= Html::activeHiddenInput($mailing, 'templateId', ['id' => 'templateId']); ?>

    <?= Html::activeLabel($mailing, 'dateSend'); ?>
    <?= Html::error($mailing, 'dateSend', ['style' => 'color: red;', 'class' => 'has-error']); ?>
    <?= Html::activeHiddenInput($mailing, 'dateSend', ['id' => 'dateSend']); ?>

    <?= Html::activeLabel($mailing, 'usersId'); ?>
    <?= Html::error($mailing, 'usersId', ['style' => 'color: red;', 'class' => 'has-error']); ?>
    <?= Html::activeHiddenInput($mailing, 'usersId', ['id' => 'usersId']); ?>

    <?= Html::activeLabel($mailing, 'placeholders'); ?>
    <?= Html::error($mailing, 'placeholders', ['style' => 'color: red;', 'class' => 'has-error']); ?>
    <?= Html::activeHiddenInput($mailing, 'placeholders', ['id' => 'placeholders']); ?>

    <?php ActiveForm::end(); ?>

    <?php

    $selectUsers = GridView::widget([
        'id' => 'usersGrid',
        'dataProvider' => $userDataProvider,
        'filterModel' => $userSearch,
        'pjax' => true,
        'export' => false,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'beforeGrid' => '<h3>Choose users</h3>',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'username',
            'created_at:datetime',
            [
                'class' => 'kartik\grid\BooleanColumn',
                'attribute' => 'status',
                'vAlign' => 'middle'
            ],
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    return [
                        "value" => $model->id,
                    ];
                },
            ],
        ],
    ]);

    $selectTemplates = GridView::widget([
        'id' => 'templatesGrid',
        'dataProvider' => $mailDataProvider,
        'filterModel' => $mailSearch,
        'pjax' => true,
        'export' => false,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'beforeGrid' => '<h3>Choose mail template</h3>',
        ],
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '36px',
                'header' => '#',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'class' => 'kartik\grid\RadioColumn',
                'width' => '36px',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'radioOptions' => function ($model, $key, $index, $column) {
                    return [
                        'value' => $model->id,
                    ];
                }
            ],
            [
                'attribute' => 'name',
                'width' => '150px',
            ],
            [
                'attribute' => 'user_id',
                'label' => 'Author',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) {
                    return Html::a(
                        $model->user->username,
                        '#',
                        ['title' => 'View author detail']
                    );
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(User::find()->orderBy('username')->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Any author'],
                'format' => 'raw'
            ],
            'created_at:datetime',
        ],
    ]);

    $selectData = DateTimePicker::widget([
        'options' => ['placeholder' => 'Select send time'],
        'name' => 'widgetDateSend',
        'id' => 'widgetDateSend',
        'pluginOptions' => [
            'format' => 'yyyy-m-d H:i',
            'startDate' => date('Y-m-d'),
            'todayHighlight' => true
        ]
    ]);
    $templatePlaceholders = Html::label('User name') . '<br>';
    $templatePlaceholders .= Html::input('text', 'user', '', ['class' => 'form-control']) . '<br>';
    $templatePlaceholders .= Html::label('Location') . '<br>';
    $templatePlaceholders .= Html::input('text', 'location', '', ['class' => 'form-control']) . '<br>';
    $templatePlaceholders .= Html::label('Date') . '<br>';
    $templatePlaceholders .= Html::input('text', 'date', '', ['class' => 'form-control']) . '<br>';
    $templatePlaceholders = "<div class='placeholders'>$templatePlaceholders </div>";

    $wizardConfig = [
        'id' => 'stepwizard',
        'steps' => [
            'users' => [
                'title' => 'Users',
                'icon' => 'glyphicon glyphicon-user',
                'content' => $selectUsers,
                'buttons' => [
                    'next' => [
                        'title' => 'Next',
                        'options' => [
                            'class' => 'btn btn-default',
                            'id' => 'usersSelected'
                        ],
                    ],
                ],
            ],
            'templates' => [
                'title' => 'Templates',
                'icon' => 'glyphicon glyphicon-file',
                'content' => $selectTemplates,
            ],
            'date' => [
                'title' => 'Date',
                'icon' => 'glyphicon glyphicon-calendar',
                'content' => $selectData . $templatePlaceholders,
                'buttons' => [
                    'next' => [
                        'title' => 'Next',
                        'options' => [
                            'class' => 'btn btn-default',
                        ],
                    ],
                ],
            ],
        ],
        'complete_content' => Html::submitButton('Save', ['class' => 'btn btn-primary', 'id' => 'createMailing']),
        'start_step' => 'users',
    ];

    ?>
    <?= WizardWidget::widget($wizardConfig); ?>

</div>



