<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property string $module
 * @property string $title
 * @property string $message
 * @property string $message_parameter
 * @property integer $translate
 * @property integer $system
 * @property string $send_date
 * @property integer $id_user
 * 
 * The followings are the available model relations:
 * @property EventsUsers[] $eventsUsers
 */
class Events extends CActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return Events the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('title, message, send_date', 'required'),
         
			array('module', 'length', 'max'=>40),
			array('message', 'length', 'max'=>160),
         array('title, message_parameter', 'length', 'max'=>64),
         
         array('id_user', 'numerical', 'integerOnly'=>true),
               
         array('translate, system', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
         
			array('id, module, title, message, message_parameter, translate, system, send_date, id_user', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		   'users'=>array(self::HAS_MANY, 'EventsUsers', 'id_event'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
      return array(
		   'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'module'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_MODULE'),
         'title'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_TITLE'),
			'message'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_MESSAGE'),
         'message_parameter'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_MESSAGE_PARAMETER'),
			'translate'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_TRANSLATE'),
			'system'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_SYSTEM'),
         'send_date'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_SENDDATE'),
         'id_user'=>Yii::t('rainbow', 'MODEL_EVENTS_FIELD_IDUSER'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($nIdUser = null) {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('module', $this->module, true);
      $oCriteria->compare('title', $this->title, true);
		$oCriteria->compare('message', $this->message, true);
      $oCriteria->compare('message_parameter', $this->message_parameter, true);
		$oCriteria->compare('translate', $this->translate);
		$oCriteria->compare('system', $this->system);
      $oCriteria->compare('send_date', $this->send_date, true); 
      
      if (!FString::isNullOrEmpty($nIdUser)) {
         $oCriteria->with = array('users');
         $oCriteria->together = true;
         
         $oCriteria->compare('users.id_user', $nIdUser);
      }
      else $oCriteria->compare('id_user', $this->id_user);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'send_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getEvent($nId) {
      $oEvent = Events::model()->findByPk($nId);
        
      return $oEvent;
   }
   
   public static function getEvents($nIdUser = null) {
      $oCriteria = new CDbCriteria;
      $oCriteria->order = 't.send_date DESC';
      
      if (!FString::isNullOrEmpty($nIdUser)) {
         $oCriteria->addCondition('users.id_user = ' . $nIdUser);
      }
      
      return Events::model()->findAll($oCriteria); 
   }
   
   public static function addEvent($sTitle, $sMessage, $sMessageParameter = null, $sModule = null, $nIdUser = null, $bTranslate = true, $bSystem = true) {
      $oEvent = new Events();
      
      $oEvent->title = $sTitle;
      $oEvent->message = $sMessage;
      
      if (!is_null($sModule)) $oEvent->module = $sModule;
      if (!is_null($sMessageParameter)) $oEvent->message_parameter = $sMessageParameter;
      if (!is_null($nIdUser)) $oEvent->id_user = $nIdUser;
       
      $oEvent->translate = $bTranslate;
      $oEvent->system = $bSystem;
      $oEvent->send_date = date('Y-m-d H:i:s'); 
          
      if ($oEvent->save()) {
         return $oEvent->id;
      } 
      else return false;  
   }
   
   public static function addSystemEvent($sTitle, $sMessage, $sMessageParameter, $sModuleOrigin, $sModuleDestiny, $oDepartments = null, $nIdUser = null) {
      $nIdEvent = Events::addEvent($sTitle, $sMessage, $sMessageParameter, $sModuleOrigin, Yii::app()->user->id);
      if ($nIdEvent) {
         if ((!is_null($oDepartments)) && (count($oDepartments) > 0)) {
            $oEmployees = Employees::getEmployees(null, $oDepartments);
            
            foreach($oEmployees as $oEmployee) {
               if (!is_null($oEmployee->id_user)) {
                  $oUser = Users::getUser($oEmployee->id_user);
                  if ((!is_null($oUser)) && (($oUser->role == FApplication::ROLE_MASTER) || ($oUser->role == FApplication::ROLE_ADMIN) || (UsersModulesPrivileges::getAvaliableUserModulePrivileges($sModuleDestiny, $oUser->id)))) {
                     EventsUsers::addEventUser($oEmployee->id_user, $nIdEvent);
                  }
               }
            }   
         }
         else {
            if (!is_null($nIdUser)) {
               $oUser = Users::getUser($nIdUser);
               if ((!is_null($oUser)) && (($oUser->role == FApplication::ROLE_MASTER) || ($oUser->role == FApplication::ROLE_ADMIN) || (UsersModulesPrivileges::getAvaliableUserModulePrivileges($sModuleDestiny, $oUser->id)))) {
                  EventsUsers::addEventUser($nIdUser, $nIdEvent);    
               }
            }
            else {
               $oUsers = Users::getUsers($sModuleDestiny);
               
               foreach ($oUsers as $oUser) {
                  EventsUsers::addEventUser($oUser->id, $nIdEvent);
               }
            }
         }

         return true;
      }
      else return false; 
   }
}
