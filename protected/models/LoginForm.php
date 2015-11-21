<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	/**
	 * @var string
	 */
	public $username;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var UserIdentity|null
	 */
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return [
			// username and password are required
			['username, password', 'required'],
			['username', 'length', 'min' => 1, 'max' => 32],
			// password needs to be authenticated
			['password', 'authenticate'],
		];
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return [
			'username' => Yii::t('app', 'Account'),
			'password' => Yii::t('app', 'Password'),
		];
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			if(!$this->_identity->authenticate()) {
				if ($this->_identity->errorCode === UserIdentity::ERROR_ACCOUNT_ONLINE) {
					$this->addError('error', Yii::t('app', 'Account is online.'));
				}
				else {
					$this->addError('error', Yii::t('app', 'Incorrect username or password.'));
				}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		$this->username = strtolower($this->username);

		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			Yii::app()->user->login($this->_identity, 0);
			if (in_array($this->username, Config::getInstance()->getAdmins())) {
				Yii::app()->user->setState('role', 'admin');
			}
			elseif (in_array($this->username, Config::getInstance()->getModers())) {
				Yii::app()->user->setState('role', 'moderator');
			}
			else {
				Yii::app()->user->setState('role', 'user');
			}
			return true;
		}

		return false;
	}
}
