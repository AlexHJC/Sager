<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Certificates */

$this->title = Yii::t('form', 'Create Certificates');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
