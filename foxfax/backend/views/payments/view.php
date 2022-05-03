<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Payments */

$this->title = "Payment for: " . $model->plan->plan_title;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'user_id',
            'plan.plan_title',
            'payment_cycle',
            'payer_id',
            'payment_id',
            'payment_state',
            'payment_amount',
            'payment_currency',
            'payment_method',
            'invoice_number',
            'status',
            'payer_email:email',
            'payer_first_name',
            'payer_last_name',
            'payer_phone',
            'payer_country_code',
            'plan_user_limit',
        ],
    ]) ?>

</div>
