<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	Yii::t('app', 'Transfer options')
);
?>

<h1 class="text-center"><?= Yii::t('app', 'Transfer options') ?></h1>

<? if (Yii::app()->user->hasFlash('success')): ?>
<div class="alert alert-success">
	<?= Yii::app()->user->getFlash('success') ?>
</div>
<? endif ?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array(
		'id' => 'toptions-form',
	),
)); ?>

<table class="table table-condensed table-hover">
	<col style="width: 40px;">
	<thead>
	<tr>
		<th></th>
		<th>Title</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($options as $name => $option): ?>
	<tr class="toptions-row">
		<td><?php echo CHtml::checkBox('toptions[' . $name . '][disabled]', !isset($option['disabled']), ['id' => 'opt-' . $name]); ?></td>
		<td><label for="<?= 'opt-' . $name ?>"><?= $option['label']; ?></label></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">
		Save
	</button>
	<a href="<?php echo $this->createUrl('/configs'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-ban-circle"></span>
		Cancel
	</a>
</div>
<?php
$this->endWidget();
unset($form);
