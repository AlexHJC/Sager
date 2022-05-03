<?php

use yii\helpers\Html;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CertificatesTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Certificates Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificates-types-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="fa fa-plus-circle"></i> '.Yii::t('form', 'Create new'), ['create'], ['class' => 'add_new']) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'title_en',
        'title_fr',
        'status',
        'position',
        [
            'class' => 'kartik\grid\ActionColumn',
            'dropdown' => false,
            'vAlign'=>'middle',
            'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([Yii::$app->controller->id.'/'.$action, 'id' => $key]); 
            },
            'viewOptions'=>['title'=>Yii::t('form', 'view'), 'data-toggle'=>'tooltip'],
            'updateOptions'=>['title'=>Yii::t('form', 'update'), 'data-toggle'=>'tooltip'],
            'deleteOptions'=>['title'=>Yii::t('form', 'delete'), 'data-toggle'=>'tooltip'], 
        ],
        // ['class' => 'kartik\grid\CheckboxColumn']
    ];
    echo GridView::widget([
        'id' => 'wgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'autoXlFormat'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            ['content'=>
                '{export}'
            ],
        ],
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::CSV => ['label' => 'CSV'],
            // GridView::HTML => ['label' => 'HTML'],
            GridView::PDF => ['label' => 'PDF'],
            GridView::EXCEL => ['label' => 'XLS'],
        ],
        'pjax' => true,
        'bordered' => false,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => false,
        'pageSummaryRowOptions' => [
            ['class' => 'kv-page-summary warning']
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            '{pager}',
            'heading' =>false,
        ],
    ]);

    
    ?>

</div>
