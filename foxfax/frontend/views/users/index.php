<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users (' . $aUsers['nUsers'] . '/' . $aUsers['nMaxUsers'] . ')';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')){ ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Success</h4>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php } ?>

    <?php if (Yii::$app->session->hasFlash('error')){ ?>
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Error</h4>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php } ?>

    <?php if(!empty($aUsers['nRemain'])) { ?>
        <p>
            <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
             'email:email',
             'created_at:datetime',
             'logged_at:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
