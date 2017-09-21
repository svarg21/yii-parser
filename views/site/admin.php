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
$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <?php $form = ActiveForm::begin([
            'action'=>'/parser/url'
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
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $site,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'user.username',
            'url',
            'text',
            'result',
            'tag',
            'creation_time',
    ],
]);
    ?>
</div>
