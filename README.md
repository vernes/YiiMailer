# YiiMailer

Yii extension for sending emails with layouts using [PHPMailer](https://github.com/PHPMailer/PHPMailer)

## Features

* Based on latest PHPMailer (version 5.2.6 bundled)
* Supports Yii layouts and translation
* Supports web and console applications
* Send full HTML emails with embedded images
* Work with views like you usually do in Yii
* Use test mode to save emails instead of sending them (useful when you don't have mail server installed locally)


## Installation
1. Copy YiiMailer folder to protected/extensions
2. Add 'ext.YiiMailer.YiiMailer' line to your imports in main and/or console yii config
3. Copy mail.php config file to protected/config or add configuration array in 'params' under the key 'YiiMailer'
4. Create email layout file mail.php in protected/views/layouts/ (default path, can be changed in config)
5. Create all the views you want to use in protected/views/mail/ (default path, can be changed in config)
6. Put all images you want to embed in emails in images/mail/ (default path, can be changed in config)

## Usage

Instantiate YiiMailer in your controller or console command and pass view and data array:
<pre>
$mail = new YiiMailer('contact', array('message' => 'Message to send', 'name' => 'John Doe', 'description' => 'Contact form'));
</pre>
or
<pre>
$mail = new YiiMailer();
$mail->setView('contact');
$mail->setData(array('message' => 'Message to send', 'name' => 'John Doe', 'description' => 'Contact form'));
</pre>
Layout is automatically set from config but you may override it with
<pre>
$mail->setLayout('layoutName');
</pre>

Set the properties:
<pre>
$mail->setFrom('from@example.com', 'John Doe');
$mail->setTo(Yii::app()->params['adminEmail']);
$mail->setSubject('Mail subject');
</pre>
You may use all PHPMailer properties you would usually use.

And finally send email(s):
<pre>
if ($mail->send()) {
	Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
} else {
	Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
}
</pre>

### Sending simple messages

You can send email without both the layout and view by using:
<pre>
$mail = new YiiMailer();
//$mail->clearLayout();//if layout is already set in config
$mail->setFrom('from@example.com', 'John Doe');
$mail->setTo(Yii::app()->params['adminEmail']);
$mail->setSubject('Mail subject');
$mail->setBody('Simple message');
$mail->send();
</pre>

Alternatively, you may also send email message with layout but without specific view (set layout and set body) or with view but without layout (clear layout and set view).

### Setting addresses

When using methods for setting addresses (setTo(), setCc(), setBcc(), setReplyTo()) any of the following is valid for arguments:
<pre>
$mail->setTo('john@example.com');
$mail->setTo(array('john@example.com','jane@example.com'));
$mail->setTo(array('john@example.com'=>'John Doe','jane@example.com'));
</pre>

### Sending attachments

You may send one or more attachments using setAttachemnt() method:
<pre>
$mail->setAttachment('something.pdf');
$mail->setAttachment(array('something.pdf','something_else.pdf','another.doc'));
$mail->setAttachment(array('something.pdf'=>'Some file','something_else.pdf'=>'Another file'));
</pre>

### Test mode

When working locally without mail server installed, it may be useful to save emails as files instead of trying to send them and getting errors in the process.
To use test mode, you must specify path to directory where you want to save your emails and set 'testMode' property to 'true' in your config:

<pre>
	'savePath' => 'webroot.assets.mail',
	'testMode' => true,
</pre>

Emails are saved as .eml files and you can use software like Mozilla Thunderbird to open them.

## Examples

Two examples included: one for standard contact form in yii web app and the other one for yii console app.