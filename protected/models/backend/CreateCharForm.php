<?php

/**
 *
 */
class CreateCharForm
{
	/**
	 * @var ChdTransfer
	 */
	private $_transfer;

	/**
	 * @var string
	 */
	private $transferConfig;

	public function __construct($transfer) {
		$this->_transfer = $transfer;
	}

	/**
	 * @return array
	 */
	public static function getDefaultResult() {
		return [
			'errors'   => [],
			'warnings' => [],
			'sql'      => '',
			'queries'  => [],
		];
	}

	/**
	 * @param string $config
	 * @return \CreateCharForm
	 */
	public function setTransferConfig($config) {
		$this->transferConfig = $config;
		return $this;
	}

	/**
	 * Runs the SQL script
	 *
	 * @param string $sql
	 * @param integer $accountGuid
	 *
	 * @return array
	 *    index => [
	 *      ['query'] => string,
	 *      ['status'] => count of updated rows,
	 *    ],
	 *    ['errors'] => array of string,
	 */
	private function runSql($sql, $accountGuid) {
		$result = [];

		if (empty($sql)) {
			$result['error'] = Yii::t('app', 'Empty SQL script');
			return $result;
		}

		$queries = explode(';', $sql);
		$db = Yii::app()->db;

		$transaction = $db->beginTransaction();

		$queryNumber = 1;
		try {
			$queryItem = [
				'query' => '',
				'status' => 0
			];

			$command = $db->createCommand();

			$queryItem['query'] = 'SET @ACC_GUID = ' . $accountGuid;
			$command->text = $queryItem['query'];
			$queryItem['status'] = $command->execute();
			$result[] = $queryItem;

			foreach ($queries as $query) {
				++$queryNumber;
				$query = trim($query);
				if (empty($query)) {
					continue;
				}

				$queryItem['query'] = substr($query, 0, 255);
				$command->text = $query;
				$queryItem['status'] =  $command->execute();
				$result[] = $queryItem;
			}

			$transaction->commit();
		}
		catch (\Exception $ex) {
			$queryItem['status'] = 'failed';
			$result[] = $queryItem;
			$transaction->rollback();
			$result['error'] = Yii::t('app', 'Query') . ' #' . $queryNumber . ' ' . $ex->getMessage();
		}

		return $result;
	}

	/**
	 * @return integer GUID of character, 0 on error
	 */
	private function fetchCharacterGuid()
	{
		$sql = 'SELECT @CHAR_GUID';
		$command = Yii::app()->db->createCommand($sql);
		return (int)$command->queryScalar();
	}

	/**
	 * @param string $configName
	 *
	 * @return array ['sql'] => 'SQL script'
	 *               ['queries'] => array (
	 *                 'query' => string,
	 *                 'status' => integer,
	 *               ),
	 *               ['error'] => string
	 *               ['guid'] => GUID of character
	 */
	public function createChar() {
		$result = self::getDefaultResult();

		if ($this->_transfer->char_guid > 0) {
			$result['errors'][] = Yii::t('app', 'Character exists! GUID = {n}', [$this->_transfer->char_guid]);
			return $result;
		}
		if (empty($this->transferConfig)) {
			$result['errors'][] = Yii::t('app', 'Empty transfer configuration');
			return $result;
		}

		$dumpLua = $this->_transfer->luaDumpFromDb();
		$toptions = $this->_transfer->getTransferOptionsFromDb();
		$service = new WowtransferUI();

		try {
			// TODO: service will be return a queries
			$result['sql'] = $service->dumpToSql($dumpLua, $this->_transfer->account_id, $this->transferConfig, $toptions);
			if ($service->getLastError()) {
				$result['errors'][] = Yii::t('app', 'From the service') . ': ' . $service->getLastError();
			}
		}
		catch (\Exception $e) {
			$result['errors'][] = $e->getMessage();
			return $result;
		}

		$queries = $this->runSql($result['sql'], $this->_transfer->account_id);
		if (isset($queries['error'])) {
			$result['errors'][] = $queries['error'];
			unset($queries['error']);
		}
		else {
			$guid = $this->fetchCharacterGuid();
			$result['guid'] = $guid;
			$this->_transfer->char_guid = $guid;
			$this->_transfer->create_char_date = new CDbExpression('NOW()');
			if (!$this->_transfer->save(false, ['char_guid', 'create_char_date'])) {
				$result['errors'][] = Yii::t('app', 'Saving failed');
			}
		}
		$result['queries'] = $queries;

		return $result;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function getSql() {
		$dumpLua = $this->_transfer->luaDumpFromDb();
		$toptions = $this->_transfer->getTransferOptionsFromDb();
		$service = new WowtransferUI();

		$sql = $service->dumpToSql($dumpLua, $this->_transfer->account_id, $this->transferConfig, $toptions);

		if ($service->getLastError()) {
			throw new \Exception(Yii::t('app', 'From the service') . ': ' . $service->getLastError());
		}

		return $sql;
	}
}