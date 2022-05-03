<?php

use common\commands\SendEmailCommand;
use frontend\models\Reminders;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


echo 'Cron';
echo '<br>';

// var_dump(env('SMTP_HOST2'));
// echo '<br>';
// var_dump(env('SMTP_EMAIL'));
// echo '<br>';
// var_dump(env('SMTP_PASSWD'));
// echo '<br>';
// var_dump(env('SMTP_PORT2'));
// echo '<br>';
// var_dump(env('SMTP_ENCRIPTION'));
// echo '<br>';
$token = Yii::$app->request->csrfToken;



$reminder_list = Reminders::find()
                ->where(['state' => 'waiting'])
                ->andwhere(['date_alert' => date('Y-m-d')])
                // ->andwhere(['<>', 'group' => 'yes'])
                ->orderBy('days ASC')
                ->all();



if(isset($reminder_list)&&count($reminder_list)>0){
	foreach ($reminder_list as $key => $reminder) { 
		
		/*

		$reminder->certificatName;
		$reminder->company_id;
		$reminder->company->locale;
		// $reminder->alert->notification->title;

		$reminder->company->email;
		$reminder->companyName;
		$reminder->typeName;
		$reminder->labelName;
		$reminder->label->color;
		$reminder->date_alert;
		$reminder->productName;
		$reminder->days;
		$reminder->expire;
		$reminder->state;
		$reminder->notification->title;
		$reminder->notification->subject;
		$reminder->notification->text;

		*/ 



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
		$email_subject = preg_replace($patterns, $replacements, $emailSubject);    // echo $email_subject.'<br>';
		$email_text =  preg_replace($patterns, $replacements, $emailText);         // echo $email_text.'<br>';

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
					echo 'Sended';
				}else{
					echo 'Not sended';
				}

			}
		}


		// echo $reminder->certificatName;
		// echo $certificatName;
		// echo '<br>';

		// echo date('Y-m-d', strtotime($expira));
		// echo '<br>';

		// echo $zile_ramase;
		// echo '<br>';

		// echo $companyName;
		// echo '<br>';

		// echo $companyEmail;
		// echo '<br>';

		// echo $emailSubject;
		// echo '<br>';

		// echo $emailText;
		// echo '<br>';
	}
}

/*
$reminder_list_group = ArrayHelper::map(
            Reminders::find()
            		->select(['id', 'product_id', 'certificat_id'])->asArray()
            		// ->where(['date_alert' => date('Y-m-d')])
            		// ->andwhere(['group' => 'yes'])
            		->where(['group' => 'yes'])
            		->all(), 
            'id', 'product_id', 'certificat_id');


// var_dump($reminder_list_group);

foreach ($reminder_list_group as $key_cert => $reming_group) {

	$reminder_list_group_itm = Reminders::find()
            ->where(['state' => 'waiting'])
            ->andwhere(['date_alert' => date('Y-m-d')])
            ->andwhere(['group' => 'yes'])
            ->andwhere(['certificat_id' => $key_cert])
            ->orderBy('days ASC')
            ->all();


    if(isset($reminder_list_group_itm)&&count($reminder_list_group_itm)>0){
		foreach ($reminder_list_group_itm as $key => $reminder){ 

	        if(isset($reminder->company->locale)){
				$locale = $reminder->company->locale;
			}else{
				$locale = Yii::$app->language;
			}

			$certificatID = $reminder->certificat->id;        // {id}
			$certificatName = $reminder->certificatName;      // {certificatName}
			$expira = $reminder->expire;                      // {dateExpire}
			$zile_ramase = $reminder->days;                   // {daysLeft}
			$companyName = $reminder->companyName;            // {company}
			$companyEmail = $reminder->company->email;   
			$emailSubject = $reminder->notification->{'subject_'.$locale};  

			$emailText = $reminder->notification->{'text_'.$locale};          
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
			$email_subject = preg_replace($patterns, $replacements, $emailSubject);     // echo $email_subject.'<br>';
			$email_text =  preg_replace($patterns, $replacements, $emailText);          // echo $email_text.'<br>';

			if(isset($emails)&&count($emails)>0){
				foreach ($emails as $kem => $email) {

					$send = Yii::$app->commandBus->handle(new SendEmailCommand([
					    'to' => trim($email),
					    'subject' => $email_subject,
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
						echo 'Sended';
					}else{
						echo 'Not sended';
					}

				}
			}
		}
	}
}
*/ 

/*
$reminder_list_group = Reminders::find()
                ->where(['state' => 'waiting'])
                ->andwhere(['date_alert' => date('Y-m-d')])
                ->andwhere(['group' => 'yes'])
                ->orderBy('days ASC')
                ->all();


if(isset($reminder_list_group)&&count($reminder_list_group)>0){
	foreach ($reminder_list_group as $key => $reminder) { 
	

		if(isset($reminder->company->locale)){
			$locale = $reminder->company->locale;
		}else{
			$locale = Yii::$app->language;
		}

		$certificatID = $reminder->certificat->id;        // {id}
		$certificatName = $reminder->certificatName;      // {certificatName}
		$expira = $reminder->expire;                      // {dateExpire}
		$zile_ramase = $reminder->days;                   // {daysLeft}
		$companyName = $reminder->companyName;            // {company}
		$companyEmail = $reminder->company->email;   
		$emailSubject = $reminder->notification->{'subject_'.$locale};  

		$emailText = $reminder->notification->{'text_'.$locale};          
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
		$email_subject = preg_replace($patterns, $replacements, $emailSubject);     // echo $email_subject.'<br>';
		$email_text =  preg_replace($patterns, $replacements, $emailText);          // echo $email_text.'<br>';

		if(isset($emails)&&count($emails)>0){
			foreach ($emails as $kem => $email) {

				$send = Yii::$app->commandBus->handle(new SendEmailCommand([
				    'to' => trim($email),
				    'subject' => $email_subject,
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
					echo 'Sended';
				}else{
					echo 'Not sended';
				}

			}
		}


		
	}
}


*/














// $send = Yii::$app->commandBus->handle(new SendEmailCommand([
//     'to' => 'salutik411@gmail.com',
//     'subject' => Yii::t('frontend', 'Password reset for {name}', ['name'=>Yii::$app->name]),
//     'view' => 'sendNotification',
//     'params' => [
//         'user' => $user,
//         'token' => $token,
//     ]
// ]));

// if($send){
// 	echo 'Sended';
// }else{
// 	echo 'Not sended';
// }






// Yii::$app->mail->compose()
     // ->setFrom(env('SMTP_EMAIL'))
     // ->setTo('salutik411@gmail.com')
     // ->setSubject('Email sent from Yii2-Swiftmailer')
     // ->send();

/*

Yii::$app->mail->compose()
     ->setFrom('somebody@domain.com')
     ->setTo('myemail@yourserver.com')
     ->setSubject('Email sent from Yii2-Swiftmailer')
     ->send();


Yii::$app->mail->compose('@app/mail-templates/email01', [/ *Some params for the view * /])
     ->setFrom('from@domain.com')
     ->setTo('someemail@server.com')
     ->setSubject('Advanced email from Yii2-SwiftMailer')
     ->send();

Yii::$app->mail->compose([
			'html' => '@app/mail-templates/html-email-01', 
			'text' => '@app/mail-templates/text-email-01'], 
			[/ *Some params for the view * /
		])
     ->setFrom('from@domain.com')
     ->setTo('someemail@server.com')
     ->setSubject('Advanced email from Yii2-SwiftMailer')
     ->send();

Yii::$app->mail->compose([
		'html' => '@app/mail-templates/html-email-01', 
		'text' => '@app/mail-templates/text-email-01'], 
		[/ *Some params for the view * /
		])
     ->setFrom('from@domain.com')
     ->setTo('someemail@server.com')
     ->setSubject('Advanced email from Yii2-SwiftMailer')
     ->send();

*/

?>