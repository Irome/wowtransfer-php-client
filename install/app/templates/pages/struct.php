<?php
use Installer\App;
use Installer\DatabaseManager;

$fields = array('back', 'submit', 'db_transfer_table');

$dbTransferTableName = isset($_POST['db_transfer_table']) ? trim($_POST['db_transfer_table']) : 'chd_transfer';

if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$view->writeSubmitedFields();
	header('Location: index.php?page=user');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	if (empty($dbTransferTableName))
		$view->addError('Введите название таблицы');
	elseif (!preg_match('/^[a-z_]+$/', $dbTransferTableName))
		$view->addError('Название таблицы может состоять из [a-z, _] символов');
	else
	{
		$db = new DatabaseManager($view);

		$db->createStructure();

		if (!$view->hasErrors())
		{
			$view->writeSubmitedFields();
			header('Location: index.php?page=procedures');
			exit;
		}
	}
}

?>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<div class="alert alert-info">
		На этом шаге будут созданы таблицы в базе данных с персонажами.
	</div>

	<label for="db_transfer_table">Таблица для заявок на перенос</label>
	<input type="text" name="db_transfer_table" id="db_transfer_table"
		   value="<?= $dbTransferTableName;?>" class="form-control"
		   list="db_transfer_table_list">
	<datalist id="db_transfer_table_list">
		<option>chd_transfer</option>
	</datalist>

	<pre class="sql-code" style="height: 400px;"><?= App::$app->loadDbStructure(); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $view->printHiddenFields($fields); ?>
	</div>

</form>