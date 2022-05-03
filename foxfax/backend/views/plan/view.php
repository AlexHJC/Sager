<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Plan */

$this->title = "Plan::" . $model->plan_title;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?php
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    $model->plan_price_year = money_format('%.2n', $model->plan_price_year);
    $model->plan_price_month = money_format('%.2n', $model->plan_price_month);
    ?>
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'plan_slug',
            'plan_title',
            'plan_price_year',
            'plan_price_month',
            'plan_doc_limit',
            'plan_user_limit',
        ],
    ]) ?>

</div>
