<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model app\models\site */
/* @var $form ActiveForm */
?>

<?php
$this->title = 'Запрос и результат';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact container">
    <?php $form = ActiveForm::begin([
        'action' => '/parser/url'
    ]); ?>

    <?= $form->field($model, 'url') ?>
    <?= $form->field($model, 'text') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end();
    $dataProvider = new ActiveDataProvider([
        'query' => $site
    ]);

    ?>
</div>
<div class="container-fluid">
    <div class="row" style="">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $site,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered col-md-12',
                '',
            ],
            'rowOptions' => ['style' => 'table-layout: fixed;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'user.username',
                'url',
                'text',
                'result',
                'tag',
                'creation_time',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        return \yii\helpers\Url::to(['/parser/'. $action, 'id' => $model->id]);
                    }
                ]
            ],
        ]);
        ?>
    </div>
</div>

