<?php


use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
$this->title = 'Change Subscription';
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Subscription'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Change Plan'), 'url' => ['change-plan']];
?>



<div class="subscription-change-plan-view">

    <style>
        .lishowhide {
            display: none;
        }
    </style>
    <div class="main-header">
        <h2>Change plan</h2>
        <em>subscription</em>
    </div>

    <?php if(!empty($subscription->end_at) && $subscription->end_at > time()) { ?>
        <div class="alert alert-info alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4><i class="icon fa fa-check"></i>Notification</h4>
            <p>You already have a subscription active till <strong><?php echo date("d F Y", $subscription->end_at);?></strong>, you can continue after it will expire.</p>
        </div>
    <?php } ?>

    <div class="container">
        <h3>Payment type</h3>
        <div class="payment-period-group" id="payment-period-group" data-toggle="buttons">
            <label class="btn btn-default payment-period <?php echo ($default_cycle == 'month') ? 'active' : ''; ?>">
                <input type="radio" name="payment_type" id="payment_month" value="month" autocomplete="off"  <?php echo ($default_cycle == 'month') ? 'checked="checked"' :''; ?>/>
                <span class="radio-dot"></span>
                <span class="payment-period-word">per month</span>
            </label>

            <label class="btn btn-default payment-period <?php echo ($default_cycle == 'year') ? 'active' : ''; ?>">
                <input type="radio" name="payment_type" id="payment_year" value="year" autocomplete="off" <?php echo ($default_cycle == 'year') ? 'checked="checked"' :''; ?>/>
                <span class="radio-dot"></span>
                <span class="payment-period-word">per year</span>
            </label>
        </div>

    <div class="pricing-table">
        <div class="row">
            <div class="package-wrapper">
                <div class="col-lg-12 col-md-12 col-sm-12 pricing_table-panel">
                    <?php if(!empty($plans)){ ?>
                        <?php foreach($plans as $plan) { ?>
                            <div class="priceclm">
                                <div class="package bgcolor-white">
                                    <div class="header toppart-freeplan " style="background-color:#A6D395">
                                        <h4 id="payment_type_year" class="<?php echo ($default_cycle == 'month') ? 'hidden' : ''; ?>"><sup> $</sup><?php echo $plan->plan_price_year;?><sub>/year</sub></h4>
                                        <h4 id="payment_type_month" class="<?php echo ($default_cycle == 'year') ? 'hidden' : ''; ?>"><sup> $</sup><?php echo $plan->plan_price_month;?><sub>/month</sub></h4>
                                        <div class="sub-heading"><strong><?php echo $plan->plan_title;?></strong></div>
                                    </div>
                                    <!-- PACKAGE FEATURES -->
                                    <div class="package-features">
                                        <ul>
                                            <li>
                                                <div class="column-9p">
                                                    <?php echo ($plan->plan_doc_limit == 0 ) ? '<strong>unlimited</strong>' : $plan->plan_doc_limit;?>  Documents                </div>
                                            </li>
                                            <li>
                                                <div class="column-9p">
                                                    <?php echo ($plan->plan_user_limit == 0) ? '<strong>unlimited</strong>' : $plan->plan_user_limit;?>  User Accounts                </div>
                                            </li>
                                        </ul>
                                        <div class="bottom-row">
                                            <div class="column-10p text-center">
                                                <?php if(!empty($subscription) && !empty($plan->plan_price_month)){ ?>
                                                    <?php if(!empty($subscription->end_at) && $subscription->end_at > time()) { ?>
                                                        <?php if(!empty($subscription->plan_id) && ($subscription->plan_id == $plan->id)) { ?>
                                                            <?php if($subscription->plan_cycle == 'year') { ?>
                                                                <a href="javascript:void(0);" class="btn standard-button btn-success current-plan <?php echo ($subscription->plan_cycle != $default_cycle) ? 'hidden' : '';?>" data-plan_cycle="<?php echo $subscription->plan_cycle;?>">Current Plan</a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0);" class="btn standard-button btn-success current-plan <?php echo ($subscription->plan_cycle != $default_cycle) ? 'hidden' : '';?>" data-plan_cycle="<?php echo $subscription->plan_cycle;?>">Current Plan</a>
                                                                <a onclick="getPaymentForm(this);" class="btn standard-button btn-success apply-current-plan <?php echo ($subscription->plan_cycle == $default_cycle) ? 'hidden' : '';?>"  data-plan_cycle="<?php echo $default_cycle;?>" data-package="<?php echo $plan->id;?>" data-rel="<?php echo Yii::$app->urlManager->createUrl('subscription/confirm-new-plan?p=' .  $plan->plan_slug);?>" href="javascript:void(0);">Apply</a>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <a onclick="getPaymentForm(this);" class="btn standard-button btn-success apply-current-plan <?php echo ($subscription->plan_cycle == $default_cycle) ? 'visible' : '';?>"  data-plan_cycle="<?php echo $default_cycle;?>" data-package="<?php echo $plan->id;?>" data-rel="<?php echo Yii::$app->urlManager->createUrl('subscription/confirm-new-plan?p=' .  $plan->plan_slug);?>" href="javascript:void(0);">Apply</a>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <a onclick="getPaymentForm(this);" class="btn standard-button btn-success apply-current-plan <?php echo ($subscription->plan_cycle == $default_cycle) ? 'hidden' : '';?>"  data-plan_cycle="<?php echo $default_cycle;?>" data-package="<?php echo $plan->id;?>" data-rel="<?php echo Yii::$app->urlManager->createUrl('subscription/confirm-new-plan?p=' .  $plan->plan_slug);?>" href="javascript:void(0);">Apply</a>
                                                    <?php } ?>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    <?php } ?>
                    <!--/.priceclm-->
                </div>
            </div>
            <!--column-->
        </div>
    </div>	<!--/.pricing-table-->
        <div class="modal fade" id="pay-upgrade" role="dialog"  data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-money"></i> Choose a payment method</h4>
                    </div>
                    <div class="modal-body text-center">
                        <button onclick="getPaypalUrl(this);" class="btn btn-paypal" id="paypal_url" href="javascript:void(0);"><i class="fa fa-paypal"></i> Pay With Paypal <span class="show-price"></span> </button>
                    </div>
                </div>
            </div>
        </div>
</div>
