<?
/* @var $this ConfigsController */
/* @var $whiteServers array */
/* @var $blackServers array */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => ['/configs'],
	Yii::t('app', 'Remote servers')
];
?>

<h1><?= Yii::t('app', 'Remote servers') ?></h1>

<p>Удаленные сервера World of Warcraft с которых можно переносить персонажей.</p>

<p>
	По-умолчанию все сервера, зарегистрированные на сервисе, находятся в черном списке,
	то есть переносить с них персонажей нельзя.
</p>

<p>Данные синхронизируются с сервисом раз в сутки.
	Для ручной синхронизации нужно нажать кнопку <i>Синхронизация</i>.
</p>

<div>
	<a class="btn btn-success pull-right">Синхронизация</a>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-md-6">
		<h3>Черный список</h3>
		<? if (empty($blackServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<? else: ?>
			<ul>
			<? foreach ($blackServers as $server): ?>
				<li><?= $server['title'] ?></li>
			<? endforeach; ?>
			</ul>
		<? endif ?>
	</div>
	<div class="col-md-6">
		<h3>Белый список</h3>
		<? if (empty($whiteServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<? else: ?>
		<ul>
			<? foreach ($blackServers as $server): ?>
				<li></li>
			<? endforeach; ?>
		</ul>
		<? endif ?>
	</div>
</div>

