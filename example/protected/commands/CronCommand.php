<?php
class CronCommand extends CConsoleCommand
{
	public function getHelp()
	{
		echo "Some cron job";
	}

	public function run($args)
	{
		//Do some cron processing...
		$cronResult="Cron job finished successfuly";
		
		$mail = new YiiMailer;
		//use "cron" view from views/mail
		$mail->setView('cron');
		$mail->setData(array('message' => $cronResult, 'name' => get_class($this), 'description' => 'Cron job', 'mailer' => $mail));
		
		//set properties
		$mail->setFrom('from@example.com', 'Console application');
		$mail->setSubject($cronResult);
		$mail->setTo('to@example.com');
		$mail->setAttachment(Yii::getPathOfAlias('webroot.files') . '/yii-1.1.0-validator-cheatsheet.pdf');
		//if you want to use SMTP, configure it in config file or use something like:
		$mail->setSmtp('smtp.gmail.com', 465, 'ssl', true, 'your_email@gmail.com', 'your_password'); // GMail example
		//send
		if ($mail->send()) {
			echo 'Mail sent successfuly';
		} else {
			echo 'Error while sending email: '.$mail->getError();
		}
		echo PHP_EOL;
	}
}