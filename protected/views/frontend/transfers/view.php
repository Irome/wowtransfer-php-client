<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs=array(
	'Заявки на перенос'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	array('label'=>'Создать заявку', 'url'=>array('create'), 'icon' => 'plus'),
	array('label'=>'Изменить заявку', 'url'=>array('update', 'id'=>$model->id), 'icon' => 'pencil'),
	array('label'=>'Удалить заявку', 'url'=>'#', 'icon' => 'remove', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Просмотр заявки номер #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'create_transfer_date',
		'status',
		'server',
		'realmlist',
		'realm',
		'username_old',
		'account',
		'options',
		'comment',
	),
)); ?>
