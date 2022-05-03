<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Labels */

$this->title = Yii::t('form', 'Update {modelClass}: ', [
    'modelClass' => 'Labels',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Labels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('form', 'Update');
?>
<div class="labels-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
