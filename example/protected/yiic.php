<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/yii.php';
$config=dirname(__FILE__).'/config/console.php';
define('YII_ENABLE_ERROR_HANDLER',false);
define('YII_ENABLE_EXCEPTION_HANDLER',false);
					
// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);

if(isset($config))
{
	$app=Yii::createConsoleApplication($config);
	$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
	$app=Yii::createConsoleApplication(array('basePath'=>dirname(__FILE__).'/cli'));

$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
	$app->commandRunner->addCommands($env);

//fix webroot
Yii::setPathOfAlias('webroot',dirname(__FILE__).'/..');

$app->run();