<?
/* @var $this TransfersController frontend */
/* @var $model ChdTransfer model */
?>

<h1>Удаление персонажа по заявке #<?= $model->id; ?></h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?= Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>
