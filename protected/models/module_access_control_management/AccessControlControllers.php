<?php

/**
 * This is the model class for table "accesscontrol_controllers".
 *
 * The followings are the available columns in table 'accesscontrol_controllers':
 * @property integer $id
 * @property string $name
 * @property string $ipv4
 * @property string $mac
 * @property string $status
 *
 * The followings are the available model relations:
 * @property AccesscontrolDevicesGroupDevices[] $accesscontrolDevicesGroupDevices
 */
class AccessControlControllers extends CExportedActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return Incidences the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return CDbConnection database connection
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_accesscontrolmanagement;
   }

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'accesscontrol_controllers';
   }
   
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('name', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('ipv4', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('mac', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
          
         array('name', 'length', 'min'=>3, 'max'=>30, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('ipv4', 'match', 'pattern'=>FRegEx::getIPv4Pattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_IPV4')),
         array('mac', 'match', 'pattern'=>FRegEx::getMacPattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_MAC')),
         
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('ipv4', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('mac', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('mac', 'filter', 'filter'=>'strtoupper'),
    
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, ipv4, mac, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
	   return array(
		   'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCONTROLLERS_FIELD_NAME'),
			'ipv4'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCONTROLLERS_FIELD_IPV4'),
         'mac'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCONTROLLERS_FIELD_MAC'),
         'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLCONTROLLERS_FIELD_STATUS'),
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

      $oCriteria = new CDbCriteria;

      $oCriteria->compare('name', $this->name, true);
      $oCriteria->compare('ipv4', $this->ipv4, true);
      $oCriteria->compare('mac', $this->mac, true);
      $oCriteria->compare('status', $this->status, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getAccessControlController($nId) {
      $oAccessControlController = AccessControlControllers::model()->findByPk($nId);
        
      return $oAccessControlController;
   }
   
   public static function getAccessControlControllers() {
      return AccessControlControllers::model()->findAll();   
   }
   
   public static function getAccessControlControllerByName($sName) {
      $oAccessControlController = AccessControlControllers::model()->find('name = \'' . $sName . '\'');
        
      return $oAccessControlController;
   }
   
   public static function getAccessControlControllerByIPv4($sIPv4) {
      $oAccessControlController = AccessControlControllers::model()->find('ipv4 = \'' . $sIPv4 . '\'');
        
      return $oAccessControlController;
   }
   
   public static function getAccessControlControllerName($nId) {
      $oAccessControlController = AccessControlControllers::getAccessControlController($nId);
      if (!is_null($oAccessControlController)) {
         return $oAccessControlController->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name', 'ipv4', 'mac', 'status');
      
      $this->oExportSpecifications['data'][0] = array('status', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(Yii::t(\'frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '\', \'MODEL_ACCESSCONTROLCONTROLLERS_FIELD_STATUS_VALUE_\' . FString::getLastToken(?, \'_\')))', 'FString::STRING_EMPTY');
            
      return $this->oExportSpecifications; 
   } 
}
