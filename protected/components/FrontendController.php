<?php

class FrontEndController extends BaseController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Return menu data
	 *
	 * @return array
	 */
	public function getMainMenuItems() {
		$menu = [];

		$menu[] = ['label' => Yii::t('app', 'Site'), 'url' => Yii::app()->params['siteUrl'], 'icon' => 'home'];
		if (!Yii::app()->user->isGuest) {
			$menu[] = [
				'label' => Yii::t('app', 'Requests'), 'url' => ['/transfers'],
				'icon' => 'list', 'active' => $this->id == 'transfers',
			];
		}
		$menu[] = ['label' => Yii::t('app', 'Help'), 'url' => ['/site/page'], 'icon' => 'info-sign'];

		return $menu;
	}

	public function getRightMenuItems() {
		$lang = Yii::app()->user->lang;
		$items = [
			[
				'label' => 'A',
				'url' => Yii::app()->request->baseUrl . '/admin.php/transfers/index',
				'visible' => Yii::app()->user->isAdmin(),
				'icon' => 'cog',
				'htmlOptions' => ['title' => Yii::t('app', 'Administration')],
				'linkOptions' => ['id' => 'to-backend'],
			],
			[
				'label' => $lang,
				'items' => [
					[
						'url' => ['/site/lang', 'lang' => 'ru'],
						'label' => 'ru',
						'active' => $lang === 'ru',
					],
					[
						'url' => ['/site/lang', 'lang' => 'en'],
						'label' => 'en',
						'active' => $lang === 'en',
					],
				]
			],
			[
				'label' => Yii::app()->user->name,
				'visible' => !Yii::app()->user->isGuest,
				'items' => [
					[
						'url' => ['/site/logout'],
						'label' => Yii::t('app', 'Logout'),
						'icon' => 'log-out',
					],
				]
			],
			[
				'url' => ['/site/login'],
				'label' => Yii::t('app', 'Login'),
				'visible' => Yii::app()->user->isGuest && $this->route !== 'site/login',
				'icon' => 'log-in',
			],
		];

		return $items;
	}

	public function registerCssAndJs() {
		$cs = Yii::app()->clientScript;
		$baseUrl = Yii::app()->request->baseUrl;

		if (true) { // TODO: minify resource
			// blueprint CSS framework
			$cs->registerCssFile($baseUrl . '/css/dev/common/main.css', 'screen, projection');
			$cs->registerCssFile($baseUrl . '/css/dev/common/print.css', 'print');
			/*
			<!--[if lt IE 8]>
			<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
			<![endif]-->
			*/
			$cs->registerCssFile($baseUrl . '/css/dev/common/main.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/form.css');

			Yii::app()->bootstrap->register();

			$cs->registerCssFile($baseUrl . '/css/dev/common/common.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/icons.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/sprite_main.css');
			$cs->registerCssFile($baseUrl . '/css/dev/frontend/frontend.css');

			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/main.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/common.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/dialogs.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/transfers.js', CClientScript::POS_END);
		}
		else {
			$cs->registerScriptFile($baseUrl . '/js/frontend.min.js', CClientScript::POS_END);
		}
	}
}