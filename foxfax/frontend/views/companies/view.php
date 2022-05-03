<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use frontend\models\CertificatesTypes;
use frontend\models\CertificatesTypesItems;


/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('form', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('form', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('form', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('form', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'adress:ntext',
            'phone',
            'email:email',
            'description:ntext',
            'sender_name',
            'sender_email:email',
            'alert_email:email',
            'alert_sms',
            'alert_default',
            'country_id',
            'sms_time',
            'shared',
            'date_added',
            'last_modify',
        ],
    ]) ?>

        <div class="col-md-12 export_config_sp text-right">
        <?php

        $exportColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            'id',
            [
                'attribute'=>'parent_id',
                'width'=>'250px',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->parentName;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(CertificatesTypesItems::find()->orderBy('parent_id')->asArray()->all(), 'id', 'title_'.Yii::$app->language),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Any type'],
                'group'=>true,  // enable grouping
                // 'subGroupOf'=>1 // supplier column index is the parent group
            ],
            'title_en',
            'title_fr',
            [
                'label' => 'Category',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'parent_id',
                'value'=>function ($model, $key, $index) {
                    $cat = CertificatesTypesItems::find()->where(['id' => $model->parent_id])->one();
                    return $cat['title'];
                },
                'group'=>true,  // enable grouping
                'groupedRow'=>true,
                // 'subGroupOf'=>1 // supplier column index is the parent group
            ],
            [
                'label' => 'Type',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'typeName',
                'vAlign'=>'middle',
            ],
            // 'type_id',
            [
                'attribute'=>'added',
                'format'=>['date', 'php:d-m-Y'],
                'width'=>'100px'
            ],
            [
                'attribute'=>'expire',
                'format'=>['date', 'php:d-m-Y'],
                'width'=>'100px'
            ],
            'valable',
            [
                'attribute'=>'modify_by',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->userName;
                }
            ],
        ];
        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $exportColumns,
            'showConfirmAlert'=>false, // true
            'target'=>GridView::TARGET_BLANK,
            'exportConfig' => [],
        ]);
        ?>

    </div>
    <div class="col-md-12">

        <?php

        $get_var = Yii::$app->getRequest()->getQueryParam('CertificatesSearch2');
        $parent_id = $get_var['type_id'];

        if(isset($parent_id)&&strlen($parent_id)>0){
            $arr_map_subct = CertificatesTypesItems::find()
                ->orderBy('title_'.Yii::$app->language)
                ->where(['parent_id' => $parent_id])
                ->asArray()
                ->all();
        }else{
            $arr_map_subct = CertificatesTypesItems::find()
                ->orderBy('title_'.Yii::$app->language)
                // ->where(['parent_id' => $parent_id])
                ->asArray()
                ->all();
        }

        $gridColumns = [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Type',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'typeName',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'parent_id',
                'label' => 'Category',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->parentName;
                },
                'group'=>true,  // enable grouping
            ],
            /*[
                'label' => 'Category',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'parentName',
                'vAlign'=>'middle',
            ],*/
            [
                'label' => 'Supplier',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'companyName',
                'vAlign'=>'middle',
            ],
            [
                'attribute'=>'expire',
                'format'=>['date', 'php:d-m-Y'],
                'width'=>'100px'
            ],
            [
                'label' => 'Product',
                'class'=>'kartik\grid\DataColumn',
                'attribute'=>'productName',
                'vAlign'=>'middle',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) {
                    return Url::to([Yii::$app->controller->id.'/'.$action, 'id' => $key]);
                },
                'buttons'=>[
                    'delete' => function(){ return '';},
                    'update' => function(){ return '';},
                ],
                'viewOptions'=>['title'=>Yii::t('form', 'view'), 'data-toggle'=>'tooltip'],
                //'updateOptions'=>['title'=>Yii::t('form', 'update'), 'data-toggle'=>'tooltip'],
                //'deleteOptions'=>['title'=>Yii::t('form', 'delete'), 'data-toggle'=>'tooltip'],
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
                 // Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                 // '{range}'.' '.
                 // '{search}'.' '.
                     '{export}'.' '.
                     '{refresh}'. ' '
                ],
            ],
            'export'=>[
                'fontAwesome'=>true,
                'showConfirmAlert'=>false, // true
                'target'=>GridView::TARGET_BLANK,
                'downloadProgress' => 'Generating file. Please wait...',
            ],
            'exportConfig' => [
                GridView::CSV => ['label' => 'CSV'],
                // GridView2::HTML => ['label' => 'HTML'],
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



</div>
