<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identification
 * @property string $role
 * @property string $passwd
 * @property string $mail_smtp_mail
 * @property string $mail_smtp_host
 * @property integer $mail_smtp_port
 * @property string $mail_smtp_user
 * @property string $mail_smtp_passwd
 * @property integer $mail_smtp_ssl
 * @property integer $notify_events
 * @property string $language
 * @property string $def_application
 *
 * The followings are the available model relations:
 * @property UsersModulesPrivileges[] $usersModulesPrivileges
 */
class Users extends CActiveRecord {
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('first_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('full_name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('identification', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('passwd', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('passwd', 'length', 'max'=>32),
			array('first_name, middle_name, last_name, identification', 'length', 'max'=>12),
         array('full_name', 'length', 'max'=>38),
			array('role', 'length', 'max'=>20),
			array('language', 'length', 'max'=>3),
         array('def_application', 'length', 'max'=>40),
         
         array('passwd', 'match', 'pattern'=>FRegEx::getPasswdPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_PASSWD')),
    
         array('full_name', 'filter', 'filter'=>array($this, 'strcpy_fullname')),
         
         array('mail_smtp_ssl, notify_events', 'boolean'),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, middle_name, last_name, full_name, identification, role, passwd, language, def_application', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usersModulesPrivileges'=>array(self::HAS_MANY, 'UsersModulesPrivileges', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
   public function attributeLabels() {
		return array(
			'id'=>'ID',
			'first_name'=>'First Name',
			'middle_name'=>'Middle Name',
			'last_name'=>'Last Name',
         'full_name'=>'Full Name',
			'identification'=>'Identification',
			'role'=>'Role',
			'passwd'=>'Passwd',
         'notify_events'=>Yii::t('rainbow', 'MODEL_USERS_FIELD_NOTIFYEVENTS'),
			'language'=>'Language',
         'def_application'=>'Def Application',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('first_name', $this->first_name, true);
		$oCriteria->compare('middle_name', $this->middle_name, true);
		$oCriteria->compare('last_name', $this->last_name, true);
      $oCriteria->compare('full_name', $this->full_name, true);
		$oCriteria->compare('identification', $this->identification, true);
		$oCriteria->compare('role', $this->role, true);
		$oCriteria->compare('passwd', $this->passwd, true);
		$oCriteria->compare('language', $this->language, true);
      $oCriteria->compare('def_application', $this->def_application, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$oCriteria,
		));
	}
    
   public static function getUser($nId) {
      $oUser = Users::model()->findByPk($nId);
        
      return $oUser;
   }
   
   public static function getUsers($sModule = null) {
      if (!FString::isNullOrEmpty($sModule)) {
         $sSentence = '(t.role = \'' . FApplication::ROLE_MASTER . '\') OR (t.role = \'' . FApplication::ROLE_ADMIN . '\') OR (module = \'' . $sModule . '\' AND active = 1)';
         return Users::model()->with('usersModulesPrivileges')->findAll($sSentence);  
      }
      else { 
         return Users::model()->findAll('true ORDER BY id ASC');   
      } 
   }
   
   public static function getEmployeeByIdUser($nId) {
      $oEmployee = Employees::model()->find('id_user = ?', array($nId));
      
      return $oEmployee;   
   }
   
   public static function getIsMaster($nId) {
      $oUser = Users::getUser($nId);
        
      if (!is_null($oUser)) return ($oUser->role == FApplication::ROLE_MASTER);     
      else return false;
   }
   
   public static function getIsAdmin($nId) {
      $oUser = Users::getUser($nId);
        
      if (!is_null($oUser)) return ($oUser->role == FApplication::ROLE_ADMIN);     
      else return false;
   }
    
   public static function getIsUser($nId) {
      $oUser = Users::getUser($nId);
        
      if (!is_null($oUser)) return ($oUser->role == FApplication::ROLE_USER);     
      else return false;
   }
    
   public static function getIsModuleAdmin($nId, $sModule) {
      // if actual user is Master or Admin=>access all modules with admin role.
      if ((Users::getIsMaster($nId)) || (Users::getIsAdmin($nId))) return true;
      else {
         $oUser = Users::getUser($nId);
         
         if (!is_null($oUser)) { 
            $oUserModulePrivileges = UsersModulesPrivileges::getUserModulePrivileges($sModule, $oUser->id);
            if (!is_null($oUserModulePrivileges)) return ($oUserModulePrivileges->role == FApplication::ROLE_MODULE_ADMIN);    
         }    
         return false;  
      }
   }
   
   public static function getIsModuleUser($nId, $sModule) {
      // if actual user is Master or Admin=>access all modules=>admin role, non user role.
      if ((Users::getIsMaster($nId)) || (Users::getIsAdmin($nId))) return false;
      else {
         $oUser = Users::getUser($nId);
         
         if (!is_null($oUser)) { 
            $oUserModulePrivileges = UsersModulesPrivileges::getUserModulePrivileges($sModule, $oUser->id);
            if (!is_null($oUserModulePrivileges)) return ($oUserModulePrivileges->role == FApplication::ROLE_MODULE_USER);    
         }    
         return false;  
      }
   }

   public static function getIsModuleRestricedUser($nId, $sModule) {
      // if actual user is Master or Admin=>access all modules=>admin role, non restriced user role.
      if ((Users::getIsMaster($nId)) || (Users::getIsAdmin($nId))) return false;
      else {
         $oUser = Users::getUser($nId);
         
         if (!is_null($oUser)) { 
            $oUserModulePrivileges = UsersModulesPrivileges::getUserModulePrivileges($sModule, $oUser->id);
            if (!is_null($oUserModulePrivileges)) return ($oUserModulePrivileges->role == FApplication::ROLE_MODULE_RESTRICTED_USER);    
         }    
         return false;  
      }
   }
   
   public static function getIsValidDefApplication($nId) {
      $bIsValid = false;
      $oUser = Users::getUser($nId);
      
      if (!is_null($oUser)) {
         if (strlen($oUser->def_application) > 0) {
            return Users::getIsAvaliableModuleForUser($nId, $oUser->def_application);
         }
      }
      
      return $bIsValid;   
   }
   
   public static function getFirstAvaliableModuleForUser($nId) {
      $oListUserModulesPrivileges = Users::getAvaliableModulesForUser($nId);
      
      if (count($oListUserModulesPrivileges) > 0) {
         return $oListUserModulesPrivileges[0]->getName();
      }
      else return null;
   }
   
   public static function getIsAvaliableModuleForUser($nId, $sModule) {
      $oListUserModulesPrivileges = Users::getAvaliableModulesForUser($nId);

      $bIsValid = false;         
      foreach ($oListUserModulesPrivileges as $oModulePrivileges) {
         if ($oModulePrivileges->getName() == $sModule) $bIsValid = true;   
      }
      
      return $bIsValid;
   } 
    
   public static function getAvaliableModulesForUser($nId) {
      $oListUserPrivileges = new ListUserPrivileges($nId);
      return $oListUserPrivileges->getModulesPrivileges(); 
   }
   
   public static function getNumAvaliableModulesForUser($nId) {
      return count(Users::getAvaliableModulesForUser($nId));
   }
   
   public static function getFullName($nId) {
      $oUser = Users::getUser($nId);
      if (!is_null($oUser)) {
         if (strlen($oUser->last_name) > 0) return $oUser->first_name . FString::STRING_SPACE . $oUser->middle_name . FString::STRING_SPACE . $oUser->last_name;
         else return $oUser->first_name . FString::STRING_SPACE . $oUser->middle_name;      
      }
      else return null; 
   }
   
   public static function getUserEmployeeFullName($nId) {
      $sCurrentUser = FString::STRING_EMPTY;
      
      $oEmployee = Users::getEmployeeByIdUser($nId);
      if (!is_null($oEmployee)) $sCurrentUser = $oEmployee->full_name; 
      else {
         $oUser = Users::getUser($nId);
         if (!is_null($oUser)) {
            $sCurrentUser = $oUser->full_name;   
         }
      }  
      
      return $sCurrentUser; 
   }
   
   public static function getUserDefApplication($nId) {
      $sCurrentDefApplication = FString::STRING_EMPTY;
      
      $oUser = Users::getUser($nId);
      if ((!is_null($oUser)) && (!FString::isNullOrEmpty($oUser->def_application))) $sCurrentDefApplication = $oUser->def_application;  
      
      return $sCurrentDefApplication; 
   }
   
   public function strcpy_fullname() {
      if (strlen($this->last_name) > 0) $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name . FString::STRING_SPACE . $this->last_name;
      else $this->full_name = $this->first_name . FString::STRING_SPACE . $this->middle_name;
      
      return $this->full_name;  
   }       
}