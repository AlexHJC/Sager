<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'user.username',
            'plan.plan_title',
            'payment_cycle',
            'payer_id',
            // 'payment_id',
            // 'payment_state',
            'payment_amount:currency',
            // 'payment_currency',
            // 'payment_method',
            'invoice_number',
            // 'status',
            // 'payer_email:email',
            // 'payer_first_name',
            // 'payer_last_name',
            // 'payer_phone',
            // 'payer_country_code',
            // 'plan_user_limit',

            [
                'class'   => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function () {
                        return '';
                    },
                    'update' => function () {
                        return '';
                    },
                ]
            ],

        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
