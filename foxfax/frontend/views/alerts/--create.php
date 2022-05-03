<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Alerts */

$this->title = Yii::t('form', 'Create Alerts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Alerts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
