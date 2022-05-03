<?php


use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
$this->title = 'Subscription Status';
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Subscription'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Subscription Status'), 'url' => ['check-status']];
?>
<div class="subscription-check-status">
        <div class="row" style="display:block">
    <div class="main-header">
            <h2>Your Current Subscription</h2>
            <em style="font-weight: bold;color: #36535e;font-size: 14px;"><?php if(!empty($subscription['expire_at'])) { echo "expires at " . $subscription['expire_at'];} else { echo "current plan";} ?></em>
            <div class="balance-title pull-right">
                <h2 style="border:0 none;">
                    <span>Current Package: <?php if(!empty($subscription['current_plan_price'])) { echo "$" . $subscription['current_plan_price'] . "/" . $subscription['current_plan_cycle']; } else { ?> free <?php } ?></span>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">



                    </div>
                </div>
            </div>
        </div>

        <div>
            <ul class="quicklinks">
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['subscription/change-plan']);?>" class="btn btn-info" role="button"> Change Subscription</a></li>
            </ul>
        </div>


        <div class="page-header clearfix">
            <div class="row">
                <div class="col-md-6">
                    <h2> Subscription Status </h2>
                </div>
            </div>
            <!--row-->
        </div>
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
        <div class="row">
            <div class="col-md-12">
                <!--widget-head-->
                <div class="widget-content">
                    <div class="table-responsive table-widget membership-table">
                        <table class="table table-bordered" width="100%" cellspacing="0" cellpadding="0">
                            <thead>
                            <tr>
                                <th width="40%">Features</th>
                                <th width="15%">Purchased</th>
                                <th width="15%">Used</th>
                                <th width="15%">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Documents</th>
                                <th><?php echo $subscription['plan_doc_limit'];?></th>
                                <th><?php echo $subscription['plan_doc_used'];?></th>
                                <th><?php echo $subscription['plan_doc_balance'];?></th>
                            </tr>
                            <tr>
                                <th>User Accounts</th>
                                <th><?php echo $subscription['plan_user_limit'];?></th>
                                <th><?php echo $subscription['plan_user_used'];?></th>
                                <th><?php echo $subscription['plan_user_balance'];?></th>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--basic-plan-widget-inner-->
            </div>
        </div>
</div>
