<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Notifications */

$this->title = Yii::t('form', 'Create Notifications');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Notifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notifications-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
