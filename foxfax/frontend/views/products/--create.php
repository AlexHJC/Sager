<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Products */

$this->title = Yii::t('form', 'Create Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
