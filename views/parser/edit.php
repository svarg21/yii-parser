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
$this->title = 'Редактирование запроса';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact container">
    <?php $form = ActiveForm::begin([
        'action' => '/parser/url'
    ]); ?>

    <?= $form->field($model, 'url')->textInput(['value' => $site['url']]) ?>
    <?= $form->field($model, 'text')->textInput(['value' => $site['text']]) ?>
    <h5>Результат поиска:</h5>
    <ul>
        <li>Результат:<?= htmlspecialchars($site['result']) ?></li>
        <li>Тэг:<?= htmlspecialchars($site['tag']) ?></li>
        <li>Когда искали:<?= $site['creation_time'] ?></li>
    </ul>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end();
    $dataProvider = new ActiveDataProvider([
        'query' => $site
    ]);

    ?>
    </h6>
</div>

