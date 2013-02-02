<p>Message from <?php echo $name . ': ' . $message ?></p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <tt><?php echo __FILE__; ?></tt></li>
	<li>Layout file: <tt><?php echo $mailer->getViewFile($mailer->getLayoutPath() . '.' . $mailer->getLayout()); ?></tt></li>
</ul>