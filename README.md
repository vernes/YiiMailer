# YiiMailer

Yii extension for sending emails with layouts using [PHPMailer](http://code.google.com/a/apache-extras.org/p/phpmailer/)

## Features

* Based on latest PHPMailer (version 5.2.2 bundled)
* Supports Yii layouts and translation
* Send full HTML emails with embeded images
* Work with views like you usually do in Yii


## Installation
1. Copy YiiMailer folder to protected/extensions
2. Add 'ext.YiiMailer.YiiMailer' line to your imports in main yii config
3. Copy mail.php config file to protected/config
4. Create email layout file mail.php in protected/views/layouts/ (default path, can be changed in config)
5. Create all the views you want to use in protected/views/mail/ (default path, can be changed in config)
6. Put all images you want to embed in emails in images/mail/ (default path, can be changed in config)

## Usage

Instantiate YiiMailer in your controller controller and pass view and data array:
<pre>
$mail = new YiiMailer('contact', array('message' => $model->body, 'name' => $model->name, 'description' => 'Contact form'));
</pre>
Layout is automatically set from config but you may override it with $mail->setLayout('layoutName')

Render HTML mail and set properties:
<pre>
$mail->render();
$mail->From = $model->email;
$mail->FromName = $model->name;
$mail->Subject = $model->subject;
$mail->AddAddress(Yii::app()->params['adminEmail']);
</pre>
You may use all PHPMailer properties you would usually use.

And finally send email(s):
<pre>
if ($mail->Send()) {
	$mail->ClearAddresses();
	Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
} else {
	Yii::app()->user->setFlash('error','Error while sending email: '.$mail->ErrorInfo);
}
</pre>

## Example

View included example with standard yii contact form.