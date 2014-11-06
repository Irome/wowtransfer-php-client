<?php

//phpinfo();
//exit;

include_once('template.php');
include_once('database.php');

$pages = array(
	'hello' => array(
		'title' => 'Добро пожаловать',
	),
	'requirements' => array(
		'title' => 'Проверка системных тербований',
	),
	'core' => array(
		'title' => 'Выбор ядра WoW сервера',
	),
	'db' => array(
		'title' => 'Подключение к базе',
	),
	'user' => array(
		'title' => 'Создание пользователя',
	),
	'struct' => array(
		'title' => 'Создание таблиц',
	),
	'procedures' => array(
		'title' => 'Хранимые процедуры',
	),
	'privileges' => array(
		'title' => 'Создание прав',
	),
	'finish' => array(
		'title' => 'Заключение',
	),
);
$i = 1;
foreach ($pages as $name => $item)
{
	$pages[$name]['step'] = $i;
	++$i;
}

$template = new InstallerTemplate();

$pageName = isset($_GET['page']) ? $_GET['page'] : 'hello';
$hiddenFields = array();

$page = key_exists($pageName, $pages) ? $pages[$pageName] : reset($pages);
if (!file_exists('page_' . $pageName . '.php'))
{
	$page = reset($pages);
	$pageName = 'hello';
}

$stepCount = count($pages);
$stepPercent = intval($page['step'] * 100 / $stepCount);

$template->readSubmitedFields();

ob_start();
include_once('page_' . $pageName . '.php');
$content = ob_get_clean();

include_once('main.php');