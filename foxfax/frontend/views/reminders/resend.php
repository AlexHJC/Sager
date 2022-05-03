

<?php

use common\commands\SendEmailCommand;
use frontend\models\Reminders;


$token = Yii::$app->request->csrfToken;



$reminder_list = Reminders::find()
                ->where(['id' => $id])
                // ->andwhere(['date_alert' => date('Y-m-d')])
                ->orderBy('days ASC')
                ->all();


if(isset($reminder_list)&&count($reminder_list)>0){
	foreach ($reminder_list as $key => $reminder) { 

		if(isset($reminder->company->locale)){
			$locale = $reminder->company->locale;
		}else{
			$locale = Yii::$app->language;
		}

		// $notification = notifications;
		$certificatID = $reminder->certificat->id;        // {id}
		$certificatName = $reminder->certificatName;      // {certificatName}
		$expira = $reminder->expire;                      // {dateExpire}
		$zile_ramase = $reminder->days;                   // {daysLeft}
		$companyName = $reminder->companyName;            // {company}
		$companyEmail = $reminder->company->email;   
		// $emailSubject = $reminder->notification->subject;  
		$emailSubject = $reminder->notification->{'subject_'.$locale};  

		$emailText = $reminder->notification->{'text_'.$locale};          
		// $emailText = $reminder->notification->text;          
		$emails = $pieces = explode(",", $reminder->company->email);

		$patterns = array();
		$patterns[0] = '/{certificatName}/';
		$patterns[1] = '/{dateExpire}/';
		$patterns[2] = '/{daysLeft}/';
		$patterns[3] = '/{company}/';
		$patterns[4] = '/{id}/';
		$replacements = array();
		$replacements[0] = $certificatName;
		$replacements[1] = date('Y-m-d', strtotime($expira));
		$replacements[2] = $zile_ramase;
		$replacements[3] = $companyName;
		$replacements[4] = $certificatID;
		$email_subject = preg_replace($patterns, $replacements, $emailSubject);  //echo $email_subject.'<br>';
		$email_text =  preg_replace($patterns, $replacements, $emailText);       //echo $email_text.'<br>';

		if(isset($emails)&&count($emails)>0){
			foreach ($emails as $kem => $email) {

				$send = Yii::$app->commandBus->handle(new SendEmailCommand([
				    'to' => trim($email),
				    'subject' => $email_subject,
				    // 'subject' => Yii::t('frontend', 'Password reset for {name}', ['name'=>Yii::$app->name]),
				    'view' => 'sendNotification',   //views/mail/template
				    'params' => [
				        'emailText' => $email_text,
				        'token' => $token,
				    ]
				]));

				if($send){
					$Reminder_status = Reminders::findOne($reminder->id);
					$Reminder_status->state = 'sent';
					$Reminder_status->last_send = date('Y-m-d h:m:s');
					$Reminder_status->save();
					$result['status'] = 'succes';
					$result['id'] = $reminder->id;
				}else{
					$result['status'] = 'error';
					$result['id'] = $reminder->id;
				}
				
				if($bulk){
				    return $result;
                } else {
                    echo json_encode($result);
                }
				

			}
		}



	}
}






?>