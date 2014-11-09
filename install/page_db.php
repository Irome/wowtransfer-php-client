<?php

$fields = array('db_type', 'db_host', 'db_port', 'db_user', 'db_password', 'db_auth', 'db_characters');

// TODO: take this values from service
$defaultValues = array(
	'trinity_335a' => array(
		'user' => 'trinity',
		'password' => 'trinity',
		'auth' => 'auth',
		'characters' => 'characters',
	),
	'cmangos_335a' => array(
		'user' => 'mangos',
		'password' => 'mangos',
		'auth' => 'realmd',
		'characters' => 'characters',	
	)
);
$default = isset($defaultValues[$_POST['core']]) ? $defaultValues[$_POST['core']] : reset($defaultValues);

$dbHost = isset($_POST['db_host']) ? trim($_POST['db_host']) : 'localhost';
$dbPort = isset($_POST['db_port']) ? intval($_POST['db_port']) : 3306;
$dbUser = isset($_POST['db_user']) ? trim($_POST['db_user']) : $default['user'];
$dbPassword = isset($_POST['db_password']) ? trim($_POST['db_password']) : $default['password'];
$dbAuth = isset($_POST['db_auth']) ? trim($_POST['db_auth']) : $default['auth'];
$dbCharacters = isset($_POST['db_characters']) ? trim($_POST['db_characters']) : $default['characters'];


if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']); // from?
	$template->writeSubmitedFields();
	header('Location: index.php?page=core');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);
	$db = new InstallerDatabaseManager($template);

	$db->checkConnection();

	if (!$template->hasErrors())
	{
		$template->writeSubmitedFields();
		header('Location: index.php?page=user');
		exit;
	}
}
?>

<div class="alert alert-info">
	<p>На этом шаге вводится информация о пользователе, под которым будет устанавливаться приложение.</p>
	Пользователь должен иметь права на
	<ul>
		<li>CREATE USER, опционально.</li>
		<li>CREATE, DROP таблиц базы данных с персонажами.</li>
		<li>CREATE ROUTINE базы данных с персонажами.</li>
		<li>GRANT OPTION (SELECT, INSERT, UPDATE, EXECUTE) базы данных с персонажами.</li>
		<li>GRANT OPTION (SELECT) базы данных с аккаунтами.</li>
	</ul>
</div>

<div class="alert alert-warning">
Важно! Пользователь, под которым происходит установка, не является пользоваетелем,
под которым будет работать приложение!
</div>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<label for="db_type">Тип базы данных</label>
	<select name="db_type" id="db_type" class="form-control">
		<option value="mysql" selected="selected">MySQL</option>
	</select>


	<label for="db_host">Сервер</label>
	<input type="text" name="db_host" id="db_host" value="<?php echo $dbHost; ?>" class="form-control">

	<label for="db_port">Порт</label>
	<input type="text" name="db_port" id="db_port" value="<?php echo $dbPort; ?>" class="form-control">

	<label for="db_port">Пользователь</label>
	<input type="text" name="db_user" id="db_user" value="<?php echo $dbUser; ?>" class="form-control">

	<label for="db_port">Пароль</label>
	<input type="password" name="db_password" id="db_password" value="<?php echo $dbPassword; ?>" class="form-control">


	<label for="db_port">База даннах с персонажами</label>
	<input type="text" name="db_characters" id="db_character" value="<?php echo $dbCharacters; ?>" class="form-control">

	<label for="db_port">База данных с аккаунтами</label>
	<input type="text" name="db_auth" id="db_auth" value="<?php echo $dbAuth; ?>" class="form-control">


	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>