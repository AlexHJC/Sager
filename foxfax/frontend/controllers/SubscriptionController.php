<?php

namespace frontend\controllers;

use frontend\models\Payments;
use frontend\models\Plan;
use frontend\models\Subscription;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 * SubscriptionController implements the CRUD actions for Subscription model.
 */
class SubscriptionController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionChangePlan()
    {

        $subscrption = Subscription::find()->with('plan')->where(array('user_id' => Yii::$app->user->identity->id))->one();
        $default_cycle = (!empty($subscrption->plan_cycle)) ? $subscrption->plan_cycle : 'month';
        $oPlan = Plan::find()->orderBy('plan_price_year ASC')->all();
        return $this->render('change-plan', ['plans' => $oPlan, 'subscription' => $subscrption, 'default_cycle' => $default_cycle]);
    }

    /**
     * @return string
     */
    public function actionCheckStatus()
    {
        $user = Yii::$app->user->identity;
        $subscription = Subscription::find()->where(array('user_id' => $user->id))->with('plan')->one();
        $aUsers = $this->getNumberOfRemainUsers();
        $nUsedAccounts = 0;
        $sExpireAt = null;
        $sCurrentPlanCycle = 'month';
        $nUsedDocs = $this->nDocActive;

        if (!empty($subscription)) {
            $sExpireAt = ($subscription->end_at < time()) ? null : date("d F Y", $subscription->end_at);
            $sCurrentPlanCycle = (!empty($subscription->plan_cycle)) ? $subscription->plan_cycle : 'month';
            $nCurrentPlanPrice = $subscription->plan->{'plan_price_' . $subscription->plan_cycle};
            $nCurrentPlanDocLimit = ($subscription->plan->plan_doc_limit != 0) ? $subscription->plan->plan_doc_limit : 'unlimited';
            $nCurrentPlanDocBalance = (is_numeric($nCurrentPlanDocLimit)) ? (int)($nCurrentPlanDocLimit - $nUsedDocs) : 'unlimited';

        } else {
            $oPlan = Plan::find()->where(array('plan_price_year' => 0, 'plan_price_month' => 0))->one();
            $nCurrentPlanPrice = 0;
            $nCurrentPlanDocLimit = $oPlan->plan_doc_limit;
            $nCurrentPlanDocBalance = (int)($nCurrentPlanDocLimit - $nUsedDocs);
        }

        $aSubscription = array(
            'current_plan_price' => $nCurrentPlanPrice,
            'current_plan_cycle' => $sCurrentPlanCycle,
            'plan_doc_limit'     => $nCurrentPlanDocLimit,
            'plan_doc_used'      => $nUsedDocs,
            'plan_doc_balance'   => $nCurrentPlanDocBalance,
            'plan_user_limit'    => $aUsers['nMaxUsers'],
            'plan_user_used'     => $aUsers['nUsers'],
            'plan_user_balance'  => $aUsers['nRemain'],
            'expire_at'          => $sExpireAt,

        );

        return $this->render('check-status', array('subscription' => $aSubscription, 'aUsers' => $aUsers));
    }

    /**
     * @param $p
     *
     * @return string
     */
    public function actionConfirmNewPlan($p)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $aResult = array('type' => 'error', 'msg' => 'Something went wrong. Selected option does not exists.');
        $user = Yii::$app->user->identity;

        $oCurrentSubscription = Subscription::find()->where(array('user_id' => $user->id))->one();

        if (!empty($oCurrentSubscription) && $oCurrentSubscription->plan_cycle == 'year' && $oCurrentSubscription->end_at > time()) {
            $aResult['msg'] = "You already have a subscription active, you can continue after it will expire";
        } elseif (!empty($p)) {
            $plan_type = Yii::$app->request->post('type');
            $plan = Plan::find()->where(['plan_slug' => $p])->one();
            $priceColumn = ($plan_type == 'month') ? 'plan_price_month' : 'plan_price_year';
            $price = $plan->{$priceColumn};

            if (!empty($plan->{$priceColumn}) && !empty($plan->plan_title)) {

                    $payer = new Payer();
                    $payer->setPaymentMethod("paypal");

                    $item = new Item();
                    $item->setName($plan->plan_title)->setCurrency('USD')->setQuantity(1)->setPrice($price);
                    $itemList = new ItemList();
                    $itemList->setItems(array($item));

                    $details = new Details();
                    $details->setSubtotal($price);

                    $amount = new Amount();
                    $amount->setCurrency('USD')->setTotal($price)->setDetails($details);

                    $transaction = new Transaction();
                    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Pay For ' . $plan->plan_title . ' Membership')->setInvoiceNumber(uniqid());
                    $redirectUrls = new RedirectUrls();

                    $redirectUrls->setReturnUrl(Yii::$app->urlManager->createAbsoluteUrl('subscription/payment-complete'))
                        ->setCancelUrl(Yii::$app->urlManager->createAbsoluteUrl('subscription/payment-cancel'));

                    $payment = new Payment();
                    $payment->setIntent("sale")->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array($transaction));

                    try {
                        $payment->create($this->_getApiContext());

                        if ($payment->getState() == 'created') {
                            $oPayer = $payment->getPayer();
                            $oTransaction = $payment->transactions[0];
                            $oModelPayments = new Payments();

                            $oModelPayments->payment_id = $payment->getId();
                            $oModelPayments->user_id = $user->id;
                            $oModelPayments->plan_id = $plan->id;
                            $oModelPayments->payment_cycle = $plan_type;
                            $oModelPayments->payment_state = $payment->getState();
                            $oModelPayments->payment_amount = $oTransaction->amount->total;
                            $oModelPayments->payment_currency = $oTransaction->amount->currency;
                            $oModelPayments->payment_method = $oPayer->getPaymentMethod();
                            $oModelPayments->invoice_number = $oTransaction->invoice_number;
                            $oModelPayments->status = $oPayer->getStatus();

                            $oModelPayments->save();

                            $aResult = array('type' => 'success', 'status' => 200, 'price' => $price, 'url' => $payment->getApprovalLink());
                        } else {
                            $aResult['msg'] = "Payment can't be created.";
                        }

                    }
                    catch (PayPalConnectionException  $e) {

                        $aResult['msg'] = \GuzzleHttp\json_decode($e->getData());
                    }
            }
        }


        return $aResult;
    }

    /**
     * @return \PayPal\Rest\ApiContext
     */
    protected function _getApiContext()
    {
        $oApiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                Yii::$app->params['paypal_client_id'],     // ClientID
                Yii::$app->params['paypal_client_secret']     // ClientSecret
            )
        );

        $oApiContext->setConfig(
            array(
                'mode' => Yii::$app->params['paypal_mode']
            )
        );
        return $oApiContext;
    }

    /**
     * @return string
     */
    public function actionPaymentCancel()
    {
        return $this->render('payment-cancel');
    }

    /**
     * @return void
     */
    public function actionPaymentComplete()
    {
        $aResult = array('type' => 'error', 'msg' => 'Payment failed');
        $paymentId = Yii::$app->request->get('paymentId');
        $PayerID = Yii::$app->request->get('PayerID');
        $user = Yii::$app->user->identity;

        if (!empty($paymentId) && !empty($PayerID)) {
            $oModelPayments = Payments::find()->where(array('payment_id' => $paymentId, 'user_id' => $user->id))->one();

            if ($oModelPayments) {
                if ($oModelPayments->payment_state == 'created') {
                    $apiContext = $this->_getApiContext();
                    $payment = Payment::get($paymentId, $this->_getApiContext());

                    $execute = new PaymentExecution();
                    $execute->setPayerId($PayerID);
                    try {

                        $result = $payment->execute($execute, $apiContext);

                        try {

                            $payment = Payment::get($paymentId, $apiContext);

                            if ($payment->getState() == 'approved') {
                                $oPayer = $payment->getPayer();
                                $oPayerInfo = $oPayer->getPayerInfo();
                                $oTransaction = $payment->transactions[0];
                                $sPayerId = $oPayerInfo->getPayerId();

                                $oModelPayments->payer_id = $sPayerId;
                                $oModelPayments->payment_state = $payment->getState();
                                $oModelPayments->payment_amount = $oTransaction->amount->total;
                                $oModelPayments->payment_currency = $oTransaction->amount->currency;
                                $oModelPayments->payment_method = $oPayer->getPaymentMethod();
                                $oModelPayments->invoice_number = $oTransaction->invoice_number;
                                $oModelPayments->status = $oPayer->getStatus();
                                $oModelPayments->payer_email = $oPayerInfo->getEmail();
                                $oModelPayments->payer_first_name = $oPayerInfo->getFirstName();
                                $oModelPayments->payer_last_name = $oPayerInfo->getLastName();
                                $oModelPayments->payer_phone = $oPayerInfo->getPhone();
                                $oModelPayments->payer_country_code = $oPayerInfo->getCountryCode();

                                $oModelPayments->save();

                                $oSubscription = new Subscription();
                                $bSubscribed = $oSubscription->updateSubscription($user->id, $oModelPayments->plan_id, $oModelPayments->payment_cycle);
                                if ($bSubscribed) {
                                    $aResult = array('type' => 'success', 'msg' => 'Your subscription was updated successfully.');
                                }
                            } else {
                                $aResult['msg'] = "Something went wrong. Payment was not completed.";
                            }

                        }
                        catch (Exception $ex) {
                            $aResult['msg'] = $ex->getMessage();
                        }
                    }
                    catch (Exception $ex) {
                        $aResult['msg'] = $ex->getMessage();
                    }

                } else {
                    $aResult['msg'] = "Can't continue, this payment seems that was completed once.";
                }
            } else {
                $aResult['msg'] = "Something went wrong. The payment wasn't found in our system.";
            }
        }

        Yii::$app->getSession()->setFlash($aResult['type'], $aResult['msg']);

        redirect(Yii::$app->urlManager->createAbsoluteUrl('subscription/check-status'));
    }

    /**
     * Finds the Subscription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Subscription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscription::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
