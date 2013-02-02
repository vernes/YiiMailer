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
		
		$mail = new YiiMailer();
		//use "cron" view from views/mail
		$mail->setView('cron');
		$mail->setData(array('message' => $cronResult, 'name' => get_class($this), 'description' => 'Cron job', 'mailer' => $mail));
		//render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
		$mail->render();
		//set properties as usually with PHPMailer
		$mail->From = 'from@example.com';
		$mail->FromName = 'Console application';
		$mail->Subject = $cronResult;
		$mail->AddAddress('to@example.com');
		//send
		if ($mail->Send()) {
			$mail->ClearAddresses();
			echo 'Mail sent successfuly';
		} else {
			echo 'Error while sending email: '.$mail->ErrorInfo;
		}
		echo PHP_EOL;
	}
}