<?php

$fields = array('submit', 'back');

if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$template->writeSubmitedFields();
	header('Location: index.php?page=procedures');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$db = new InstallerDatabaseManager($template);

	if ($db->applyPrivileges() && !$template->hasErrors())
	{
		header('Location: index.php?page=config');
		exit;
	}
}

?>

<div class="alert alert-info">
	На этом шаге пользователю будут даны права на объекты базы данных.
</div>

<form action="" method="post">

	<?php $template->errorSummary(); ?>


	<p class="text-center">Пользователь:
		<span style="font-weight: bold;">
		<?php echo "'" . $template->getFieldValue('db_transfer_user') . "'@'" . $template->getFieldValue('db_transfer_user_host') . "'"; ?>
		</span>
	</p>

	<pre class="sql-code" style="height: 400px;"><?php echo $template->loadDbPrivileges(); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>