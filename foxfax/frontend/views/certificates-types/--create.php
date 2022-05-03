<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\CertificatesTypes */

$this->title = Yii::t('form', 'Create Certificates Types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
