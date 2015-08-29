<?php
/* @var $this ConfigsController */
/* @var $model AppConfigForm */
/* @var $cores array */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => ['/configs'],
	Yii::t('app', 'Application')
];

?>
<h1><?= Yii::t('app', 'Application settings') ?></h1>

<div class="alert alert-warning">
	<?= Yii::t('app', 'Settings saves in the file') ?> <code>/protected/config/app-local.php</code>.
</div>

<? if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<? endif; ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'id' => 'config-app-form',
	),
)); ?>

<fieldset>
	<legend><?= Yii::t('app', 'Server') ?></legend>
<?php
	echo $form->textFieldControlGroup($model, 'siteUrl');
	echo $form->emailFieldControlGroup($model, 'emailAdmin');
	echo $form->dropDownListControlGroup($model, 'core', $cores);
	echo $form->numberFieldControlGroup($model, 'maxTransfersCount');
	echo $form->numberFieldControlGroup($model, 'maxAccountCharsCount');
	echo $form->textFieldControlGroup($model, 'adminsStr', [
		'help' => Yii::t('app', 'Administrator`s names separated by semicolon'),
		'autocomplete' => 'off',
	]);
	echo $form->textFieldControlGroup($model, 'modersStr', [
		'help' => Yii::t('app', 'Moderator`s names separated by semicolon'),
		'autocomplete' => 'off',
	]);
	echo $form->textFieldControlGroup($model, 'transferTable');
?>
</fieldset>

<fieldset>
	<legend><?= Yii::t('app', 'Application') ?></legend>

	<?= $form->checkboxControlGroup($model, 'yiiDebug', [
		'help' => '<div class="alert alert-danger">' .
		Yii::t('app', 'Disable on prdaction server') .
		'</div>'
	]) ?>
	<?= $form->dropDownListControlGroup($model, 'yiiTraceLevel', [0, 1, 2, 3, 4, 5], [
		'help' => '<div class="alert alert-info">' .
		'0 - disable. Works only on debug mode.' .
		'</div>',
	]) ?>

</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
		<button type="submit" class="btn btn-primary" name="server">
			Save
		</button>
		<a href="<?php echo $this->createUrl('/configs') ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span> Cancel
		</a>
		<a class="btn btn-default" href="?default=1"
		   onclick="return confirm('Вы уверены?');"
		   >
			Default
		</a>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>