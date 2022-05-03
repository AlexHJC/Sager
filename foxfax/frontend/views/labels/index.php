<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LabelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('form', 'Labels');

?>


    <h1>
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="fa fa-plus-circle"></i> '.Yii::t('form', 'Create new'), ['index'], ['class' => 'add_new']) ?>
    </h1>


<?php /*
<div class="labels-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'color',
            'status',
            'position',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
*/ ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
  <div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Saved!</h4>
  <?= Yii::$app->session->getFlash('success') ?>
  </div>
<?php endif; ?>


<div class="table-responsive table-widget doc_status">
    <table class="table table-bordered" cellpadding="0" cellspacing="0">
        <thead class="table-header">
            <tr>
                <th colspan="3"><strong><i class="fa fa-tasks fa-fw"></i> Labels List</strong></th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th class="essential persist">Status</th>
                <th class="essential">Color</th>
                <th class="essential">Position</th>
                <th class="essential">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($dataProvider->models as $labels_list) { ?>
                <tr>
                    <td><?=$labels_list->title;?></td>
                    <td>
                        <span class="colorbox_label" style="background-color:#<?=$labels_list->color;?>"></span>
                    </td>
                    <td>
                        <?=$labels_list->position;?>
                    </td>
                    <td>
                    <ul class="desktop_expiry_panel">
                        <li> 
                            <a href="<?=Yii::$app->urlManager->createUrl(['labels/index', 'id'=>$labels_list->id]);?>" data-toggle="tooltip" title="" data-original-title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </li>
                        <?php /*
                        <li> 
                            <a href="#" data-toggle="tooltip" title="" data-original-title="View">
                                <i class="fa fa-eye"></i>
                            </a>
                        </li>
                        */ ?>
                        <li> 
                        <?php /*
                            <a href="<?=Yii::$app->urlManager->createUrl(['labels/delete', 'id'=>$labels_list->id]);?>" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                            <a href="<?=Yii::$app->urlManager->createUrl(['labels/delete', 'id'=>$labels_list->id]);?>" data-toggle="tooltip" class="tash_icon" title="" data-original-title="Trash">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            */ ?>
                            <a href="<?=Yii::$app->urlManager->createUrl(['labels/delete', 'id'=>$labels_list->id]);?>" class="tash_icon" data-toggle="tooltip" title="" data-method="post" data-confirm="Are you sure you want to delete this item?" data-original-title="Delete"> 
                            <i class="fa fa-trash-o"></i>
                            </a>
                        </li>
                    </ul>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php
/*
$this->title = Yii::t('form', 'Update {modelClass}: ', [
    'modelClass' => 'Labels',
]) . $model->title;
*/ ?>

<div class="p10"></div>



<div class="labels-update">

    <?= $this->render('_form', [
        'model' => $model,
        'maxPos' => $maxPos,
    ]) ?>

</div>


