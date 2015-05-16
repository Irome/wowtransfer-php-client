<?php
/*
Show transfer's options

option item has:
- name
- title
- icon (name, URL)
- large image (optionally, depends of icon's name)

*/
?>

<div class="well well-small toptions-block">

<?php
$optionsGlobal = \ToptionsConfigForm::getTransferOptions();
$options = explode(';', $model->options);
?>

<?php if (!$readonly): ?>
	<div>
		<a class="btn btn-default toptions-btn set" title="Установить все">+</a>
		<a class="btn btn-default toptions-btn unset" title="Убрать все">-</a>
		<a class="btn btn-default toptions-btn invert" title="Инвертировать">&pm;</a>
	</div>

	<div id="transfer-options-container">
<?php
	$i = 0;
	foreach ($optionsGlobal as $name => $option) {
		$id = "ChdTransfer_transferOptions_$i";
?>
		<span class="toptions">
			<span class="tdata-icon icon-<?php echo $name; ?>"></span>
		<?php if (isset($option['disabled'])): ?>
			<?php echo CHtml::label($option['label'], $id, array('style' => 'margin-left: 18px; color: gray;')); ?>
		<?php else: ?>
			<?php echo CHtml::checkBox("ChdTransfer[transferOptions][]", in_array($name, $options), array('id' => $id, 'value' => $name)) ?>
			<?php echo CHtml::label($option['label'], $id); ?>
		<?php endif; ?>
		</span>

<?php
		++$i;
	}
?>
	</div>
<?php else: ?>
	<div>
	<?php foreach ($optionsGlobal as $name => $option): ?>
		<span class="toptions">
			<span class="tdata-icon icon-<?php echo $name; ?>"></span>
			<?php if (isset($option['disabled'])): ?>
				<?php echo CHtml::label($option['label'], false, array('style' => 'margin-left: 20px; color: gray;')); ?>
			<?php else: ?>
				<span class="spr <?php echo in_array($name, $options) ? 'checked' : 'unchecked'; ?>"></span>
				<?php echo CHtml::label($option['label'], false); ?>
			<?php endif; ?>
		</span>
	<?php endforeach; ?>
	</div>
<?php endif; //*/ ?>

<div class="clearfix"></div>

</div>
