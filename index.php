<?php
if (!file_exists('.installed')) {
	$installUrl = '/' . substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']) + 1) . '/install';
	$installUrl = str_replace('\\', '/', $installUrl);
	header('Location: ' . $installUrl);
	exit;
}

$yii = __DIR__ . '/../../yii/yii.php';
$config = __DIR__ . '/protected/config/frontend.php';


if (file_exists('.gitignore')) {
	// remove the following lines when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG', true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}

require_once($yii);
Yii::createWebApplication($config)->runEnd('frontend');