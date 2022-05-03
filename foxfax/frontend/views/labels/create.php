<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Labels */

$this->title = Yii::t('form', 'Create Labels');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Labels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="labels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
