<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Reminders */

$this->title = Yii::t('form', 'Create Reminders');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Reminders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reminders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
