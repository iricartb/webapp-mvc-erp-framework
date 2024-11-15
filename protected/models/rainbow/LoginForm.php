<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {
	public $sUsername;
	public $sPassword;
	public $bRememberMe;
   public $sErrMessage;
   
	private $oIdentity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(
			// username and password are required
			array('sUsername, sPassword', 'required'),
			// rememberMe needs to be a boolean
			array('bRememberMe', 'boolean'),
			// password needs to be authenticated
			array('sPassword', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'bRememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute, $params) {
		if (!$this->hasErrors()) $this->authenticateUser();    
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login() {
      // Security method for authenticate
	   if (is_null($this->oIdentity)) $this->authenticateUser();

		if ($this->oIdentity->errorCode === FApplication::ACCESS_OK) {
         $nDuration = $this->bRememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->oIdentity, $nDuration);
			return 0;
		}
		else {                                                                                                          
         if ($this->oIdentity->errorCode == FApplication::ACCESS_ERR_USERNAME_OR_PASSWD) { $this->addError('sErrMessage', Yii::t('site', 'LOGIN_BOX_ERR_MESSAGE_USERNAME_OR_PASSWORD')); return -1; }
         else if ($this->oIdentity->errorCode == FApplication::ACCESS_ERR_NO_MODULES_AVALIABLES) { $this->addError('sErrMessage', Yii::t('site', 'LOGIN_BOX_ERR_MESSAGE_MODULES_NOT_AVALIABLES')); return -2; }
         else if ($this->oIdentity->errorCode == FApplication::ACCESS_ERR_NO_MODULES_AVALIABLES_OR_ASSIGNED) { $this->addError('sErrMessage', Yii::t('site', 'LOGIN_BOX_ERR_MESSAGE_MODULES_NOT_AVALIABLES_OR_ASSIGNED')); return -3; }
         else return -4;
      }
	}
   
   private function authenticateUser() {
      $this->oIdentity = new UserIdentity($this->sUsername, $this->sPassword);
      $this->oIdentity->authenticate();
   }
   
   public function isAuthenticate() {
      return (!Yii::app()->user->isGuest);    
   }
}
