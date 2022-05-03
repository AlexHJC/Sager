<?php

use yii\helpers\Url;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="fa fa-plus-circle"></i> '.Yii::t('form', 'Create new'), ['create'], ['class' => 'add_new']) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php


    ?>


    <?php
    $gridColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'cod',
        'title_en',
        'title_fr',
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
        ['class' => 'kartik\grid\CheckboxColumn']
    ];

    $aExportColumns = [
        ['class' => 'kartik\grid\SerialColumn'],
        'cod',
        'title_en',
        'title_fr',
    ]; ?>
    <div class="col-md-12 export_config_sp text-right">
    <?php
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $aExportColumns,
        'target' => GridView::TARGET_BLANK,
        'fontAwesome' => true,
        'exportConfig' => [

        ]
    ]);
    ?>
    </div>
    <?php

    echo GridView::widget([
        'id' => 'wgrid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'autoXlFormat'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' => [
            [

            ],
        ],
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false, // true
            'target'=>GridView::TARGET_BLANK,
            'downloadProgress' => 'Generating file. Please wait...',
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
