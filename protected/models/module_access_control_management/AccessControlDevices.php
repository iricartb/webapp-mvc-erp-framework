<?php

/**
 * This is the model class for table "accesscontrol_devices".
 *
 * The followings are the available columns in table 'accesscontrol_devices':
 * @property integer $id
 * @property string $name
 * @property string $ipv4
 * @property string $type
 * @property string $disabled
 * @property string $sync_date
 * @property string $status
 *
 * The followings are the available model relations:
 * @property AccesscontrolDevicesGroupDevices[] $accesscontrolDevicesGroupDevices
 */
class AccessControlDevices extends CExportedActiveRecord {
   
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
      return 'accesscontrol_devices';
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
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
          
         array('name', 'length', 'min'=>3, 'max'=>30, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

         array('ipv4', 'match', 'pattern'=>FRegEx::getIPv4Pattern(), 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_PATTERN_IPV4')),
         
         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         array('ipv4', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
         
         array('disabled', 'boolean'),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, ipv4, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		   'devicesGroupDevices'=>array(self::HAS_MANY, 'AccessControlDevicesGroupDevices', 'id_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
	   return array(
		   'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_NAME'),
			'ipv4'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_IPV4'),
         'type'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_TYPE'),
         'disabled'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_DISABLED'),
         'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLDEVICES_FIELD_STATUS'),
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
      $oCriteria->compare('status', $this->status, true);
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}
   
   public static function getAccessControlDevice($nId) {
      $oAccessControlDevice = AccessControlDevices::model()->findByPk($nId);
        
      return $oAccessControlDevice;
   }
   
   public static function getAccessControlDevices() {
      return AccessControlDevices::model()->findAll();   
   }
   
   public static function getAccessControlDeviceByName($sName) {
      $oAccessControlDevice = AccessControlDevices::model()->find('name = \'' . $sName . '\'');
        
      return $oAccessControlDevice;
   }
   
   public static function getAccessControlDeviceByIPv4($sIPv4) {
      $oAccessControlDevice = AccessControlDevices::model()->find('ipv4 = \'' . $sIPv4 . '\'');
        
      return $oAccessControlDevice;
   }
   
   public static function getAccessControlDeviceName($nId) {
      $oAccessControlDevice = AccessControlDevices::getAccessControlDevice($nId);
      if (!is_null($oAccessControlDevice)) {
         return $oAccessControlDevice->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function isAccessControlDeviceLocked($nId) {
      $bLocked = false;
      
      $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::getAccessControlDevicesGroupsDevicesByIdDevice($nId);
      foreach($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
         if (!$bLocked) {
            $bLocked = AccessControlGroupsDevices::isAccessControlGroupDeviceLocked($oAccessControlDeviceGroupDevice->id_group_device);
         } 
      }

      return $bLocked;   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name', 'ipv4', 'status');
      
      $this->oExportSpecifications['data'][0] = array('status', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, 'FString::castStrToUpper(Yii::t(\'frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT) . '\', \'MODEL_ACCESSCONTROLDEVICES_FIELD_STATUS_VALUE_\' . FString::getLastToken(?, \'_\')))', 'FString::STRING_EMPTY');
            
      return $this->oExportSpecifications; 
   } 
}
