<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = Yii::t('form', 'Create Companies');
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
