<?php
require_once('protected/functions/FApplication.class.php');

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    
   /**
	* Authenticates a user.
	* The example implementation makes sure if the username and password
	* are both 'demo'.
	* In practical applications, this should be changed to authenticate
	* against some persistent user identity storage (e.g. database).
	* @return boolean whether authentication succeeds.
	*/
   
   private $nId;
        
   public function authenticate() {
       
      $oUser = Users::model()->find('identification = binary ? AND passwd = ?', array($this->username, md5($this->password)));
      if (!is_null($oUser)) {
         $this->nId = $oUser->id;
         
         if (Users::getNumAvaliableModulesForUser($oUser->id) > 0) $this->errorCode = FApplication::ACCESS_OK;
         else {
            if ($oUser->role == FApplication::ROLE_MASTER) $this->errorCode = FApplication::ACCESS_ERR_NO_MODULES_AVALIABLES;
            else $this->errorCode = FApplication::ACCESS_ERR_NO_MODULES_AVALIABLES_OR_ASSIGNED;    
         }  
      }
      else $this->errorCode = Fapplication::ACCESS_ERR_USERNAME_OR_PASSWD;
        
      return $this->errorCode;
   }
   
    public function getId() {
        return $this->nId;
    }
}