<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */
?>

<div class="view" data-id="<?php echo $data->id ?>">

	<div class="toptions-view-actions">
		<div class="toptions-view-top toptions-view-id">
			<?= $data->getAttributeLabel('id') ?>
			<span class="toptions-view-id-value"><?= $data->id ?></span>
		</div>

		<div class="toptions-view-top">
			<b><?= $data->getAttributeLabel('status') ?></b>
			<span class="tstatus tstatus-<?php echo $data->status ?>">
				<?= ChdTransfer::getStatusTitle($data->status) ?>
			</span>
		</div>

		<b><?= $data->getAttributeLabel('create_transfer_date') ?></b>
		<?= $data->create_transfer_date ?>

	</div>

	<div>
		<a href="#" class="btn btn-default btn-sm pull-right transfer-delete" title="<?= Yii::t('app', 'Delete') ?>">
			<span class="glyphicon glyphicon-remove"></span>
		</a>

		<a href="<?= $this->createUrl('/transfers/update', array('id' => $data->id)); ?>"
		   class="btn btn-default btn-sm pull-right" title="<?= Yii::t('app', 'Change') ?>">
			<span class="glyphicon glyphicon-pencil"></span>
		</a>

		<a href="<?= $this->createUrl('/transfers/view', array('id' => $data->id)); ?>"
		   class="btn btn-default btn-sm pull-right" title="<?= Yii::t('app', 'View') ?>">
			<span class="glyphicon glyphicon-eye-open"></span>
		</a>
	</div>

	<div class="row" style="margin-bottom: 10px;">

		<div class="col-md-5">
			<h4><?= Yii::t('app', 'Remote server') ?></h4>
			<div class="toptions-view-attr">
				<b><?= $data->getAttributeLabel('server') ?></b>
				<?= CHtml::encode($data->server) ?>
			</div>
			<div class="toptions-view-attr">
				<b><?= $data->getAttributeLabel('realmlist') ?></b>
				<?= CHtml::encode($data->realmlist) ?>
			</div>
			<div class="toptions-view-attr">
				<b><?= $data->getAttributeLabel('realm') ?></b>
				<?= CHtml::encode($data->realm) ?>
			</div>
			<div class="toptions-view-attr">
				<b><?= $data->getAttributeLabel('username_old') ?></b>
				<?= CHtml::encode($data->username_old) ?>
			</div>
		</div>

		<div class="col-md-5">
			<h4><?= Yii::t('app', 'Current server') ?></h4>

			<div class="toptions-view-attr">
				<b><?= CHtml::encode($data->getAttributeLabel('username_new')); ?>:</b>
				<?= CHtml::encode($data->username_new); ?>
			</div>
		</div>

	</div>

	<div>
	<? $this->widget('application.components.widgets.TransferOptionsWidget', array(
		'model' => $data,
		'options' => $data->getTransferOptionsToUser()
	));	?>
	</div>

</div>