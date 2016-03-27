<?php

use Installer\App;
use Installer\DatabaseManager;

$settings = App::$app->getSettings();
$fields = ['submit', 'back'];

if (isset($_POST['back'])) {
	header('Location: ' . App::$app->createUrl(['page' => 'struct']));
	exit;
}

if (isset($_POST['submit'])) {
	header('Location: ' . App::$app->createUrl(['page' => 'config']));
	exit;
}
?>

<div class="alert alert-info">
	<?= App::t('This step have a privileges of the database objects') ?>.
</div>

<form action="" method="post">

	<?php $view->errorSummary(); ?>


	<p class="text-center">Пользователь:
        <span class="privileges-username">
            <?= "'" . $settings->getFieldValue('db_transfer_user') . "'@'" . $settings->getFieldValue('db_transfer_user_host') . "'"; ?>
		</span>
	</p>

	<pre class="sql-code"><?= App::$app->loadDbPrivileges (); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </button>
		<button class="btn btn-primary" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>
	</div>

</form>