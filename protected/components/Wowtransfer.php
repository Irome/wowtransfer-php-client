<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	private $serviceBaseUrl = 'http://wowtransfer2/api.php/api/v1/';

	/**
	 * @return array Transfer's options
	 * @todo Make loading from wowtransfer.com
	 *       Make locale
	 */
	public static function getTransferOptions()
	{
		return array(
			'achievement' => array('label' => 'Достижения'),
			'action'      => array('label' => 'Кнопки на панелях'),
			'bind'        => array('label' => 'Бинды'),
			'bag'         => array('label' => 'Вещи в сумках'),
			'bank'        => array('label' => 'Вещи в банке'),
			'criterias'   => array('label' => 'Критерии к достижениям'),
			'critter'     => array('label' => 'Спутники'),
			'currency'    => array('label' => 'Валюта'),
			'equipment'   => array('disabled' => 1, 'label' => 'Наборы экипировки'),
			'glyph'       => array('label' => 'Символы'),
			'inventory'   => array('label' => 'Инвентарь'),
			'mount'       => array('label' => 'Транспорт'),
			'pmacro'      => array('disabled' => 1, 'label' => 'Макросы'),
			'quest'       => array('label' => 'Задания'),
			'questlog'    => array('label' => 'Журнал заданий'),
			'reputation'  => array('label' => 'Репутация', ),
			'skill'       => array('label' => 'Навыки (профессии)'),
			'skillspell'  => array('label' => 'Рецепты'),
			'spell'       => array('label' => 'Заклинания'),
			'statistic'   => array('label' => 'Статистика'),
			'talent'      => array('label' => 'Таланты'),
			'taxi'        => array('label' => 'Перелеты'),
			'title'       => array('label' => 'Звания'),
		);
	}

	/**
	 * @return string Actual version of API
	 */
	public function getApiVersion()
	{
		return '1.0';
	}

	/**
	 * @return string Addon's version
	 */
	public function getAddonVersion()
	{
		return '1.11';
	}

	/**
	 * @return string PHP client version
	 */
	public function getChdphpVersion()
	{
		return '1.0';
	}

	/**
	 * Convert lua-dump to sql script
	 *
	 * @param string  $dumpLua        Lua dump
	 * @param integer $accountId      Accounts' identifier
	 * @param strign  $configuration  Name of configuration
	 *
	 * @return string Sql script (200) or error message (501)
	 */
	public function dumpToSql($dumpLua, $accountId, $configuration)
	{
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file)
			return 'fopen failed... todo!';
		fwrite($file, $dumpLua);
		fclose($file);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->serviceBaseUrl . 'dumps/sql');
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		//curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		$postfields = array(
			'dump_lua' => '@' . $filePath,
			'transferConf' => $configuration,
			'account_id' => $accountId
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		//curl_setopt($ch, CURLOPT_VERBOSE, true);
		//$verbose = fopen('c:/1.txt', 'w');
		//curl_setopt($ch, CURLOPT_STDERR, $verbose);

		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return print_r($result, true);

		unlink($filePath);

		if ($status != 200)
		{
			throw new CHttpException(501, print_r($result, true));
		}

		return $result;
	}
}