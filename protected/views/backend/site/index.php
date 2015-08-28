<?php
/* @var $this SiteController */
?>
<h1><?= Yii::t('app', 'Administration') ?></h1>

<ul>

	<li>
		<a href="<?= $this->createUrl('/transfers') ?>">
			<?= Yii::t('app', 'Transfer requests') ?>
		</a>
		<ul>
			<li><?= Yii::t('app', 'View') ?>,
				<?= Yii::t('app', 'Deleting') ?>,
				<?= Yii::t('app', 'Updating') ?>.
			</li>
			<li><?= Yii::t('', 'Create the character') ?></li>
			<li>Просмотр lua-дампов</li>
		</ul>
	</li>

	<li><a href="<?= $this->createUrl('/tconfigs/index'); ?>">
			<?= Yii::t('app', 'Transfer configurations') ?>
		</a>
		<ul>
			<li><?= Yii::t('app', 'View') ?></li>
		</ul>
	</li>

	<li><a href="<?= $this->createUrl('/configs'); ?>"><?= Yii::t('app', 'Settings') ?></a>
		<ul>
			<li>
				<a href="<?= $this->createUrl('/configs/app'); ?>">
					<?= Yii::t('app', 'Application') ?>
				</a>
			</li>
			<li>
				<a href="<?= $this->createUrl('/configs/service'); ?>">
					<?= Yii::t('app', 'Service connection') ?>
				</a>
			</li>
			<li>
				<a href="<?= $this->createUrl('/configs/toptions'); ?>">
					<?= Yii::t('app', 'Transfer options') ?>
				</a>
			</li>
			<li>
				<a href="<?= $this->createUrl('/configs/remoteservers') ?>">
					<?= Yii::t('app', 'Remote servers') ?>
				</a>
			</li>
		</ul>
	</li>

</ul>