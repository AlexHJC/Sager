<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\CertificatesTypesItems */

$this->title = Yii::t('form', 'Create Certificates Types Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Certificates Types Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-types-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
