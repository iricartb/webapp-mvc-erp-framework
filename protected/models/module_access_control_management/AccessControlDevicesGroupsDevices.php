<?php

/**
 * This is the model class for table "accesscontrol_devices_groups_devices".
 *
 * The followings are the available columns in table 'accesscontrol_devices_groups_devices':
 * @property integer $id
 * @property integer $id_device
 * @property integer $id_group_device
 *
 * The followings are the available model relations:
 * @property AccesscontrolDevices $idDevice
 * @property AccesscontrolGroupsDevices $idGroupDevice
 */
class AccessControlDevicesGroupsDevices extends CExportedActiveRecord {
   public $sName;
   
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
      return 'accesscontrol_devices_groups_devices';
   }
   
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id_device', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_group_device', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         
         array('id_device', 'UniqueAttributesValidator', 'with'=>'id_group_device', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDDEVICE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDGROUPDEVICE')))),
         array('id_group_device', 'UniqueAttributesValidator', 'with'=>'id_device', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_MULTIPLE_UNIQUE_MM', array('{1}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDGROUPDEVICE'), '{2}'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDDEVICE')))),
             
         // The following rule is used by search().
         // Please remove those attributes that should not be searched.
         array('id_device, id_group_device', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'device'=>array(self::BELONGS_TO, 'AccesscontrolDevices', 'id_device'),
			'groupDevice'=>array(self::BELONGS_TO, 'AccesscontrolGroupsDevices', 'id_group_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
		   'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),  
			'id_device'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDDEVICE'),
			'id_group_device'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_IDGROUPDEVICE'),
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

      $oCriteria->compare('id_device', $this->id_device);
      $oCriteria->compare('id_group_device', $this->id_group_device);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'id_device ASC, id_group_device ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_MEDIUM),
      ));
	}
   
   public static function getAccessControlDeviceGroupDevice($nId) {
      $oAccessControlDeviceGroupDevice = AccessControlDevicesGroupsDevices::model()->findByPk($nId);
      
      return $oAccessControlDeviceGroupDevice;
   }
   
   public static function getAccessControlDevicesGroupsDevices() {
      $oCriteria = new CDbCriteria;
      
      $oCActiveDataProvider = new CActiveDataProvider('AccessControlDevicesGroupsDevices', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_device ASC, t.id_group_device ASC',
         ), 
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
      
      return $oCActiveDataProvider->getData();     
   }
   
   public static function getFullAccessControlDevicesGroupsDevices() {
      $oAccessControlDevicesGroupsDevices = AccessControlDevicesGroupsDevices::model()->findAll();

      foreach ($oAccessControlDevicesGroupsDevices as $oAccessControlDeviceGroupDevice) {
         $oAccessControlDeviceGroupDevice->sName = AccessControlDevicesGroupsDevices::getFullAccessControlDeviceGroupDevice($oAccessControlDeviceGroupDevice->id);
      }
      return $oAccessControlDevicesGroupsDevices;   
   }
   
   public static function getFullAccessControlDeviceGroupDevice($nIdDeviceGroupDevice) {
      $oAccessControlDeviceGroupDevice = AccessControlDevicesGroupsDevices::getAccessControlDeviceGroupDevice($nIdDeviceGroupDevice);
      $sName = FString::STRING_EMPTY;
      if (!is_null($oAccessControlDeviceGroupDevice)) {
         if ((!FString::isNullOrEmpty($oAccessControlDeviceGroupDevice->id_device)) && (!FString::isNullOrEmpty($oAccessControlDeviceGroupDevice->id_group_device))) {
            $sName = AccessControlDevices::getAccessControlDeviceName($oAccessControlDeviceGroupDevice->id_device) . '/' . AccessControlGroupsDevices::getAccessControlGroupDeviceName($oAccessControlDeviceGroupDevice->id_group_device);
         }
      }
      return $sName;  
   }
   
   public static function getAccessControlDevicesGroupsDevicesByIdDevice($nIdDevice) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_device', $nIdDevice);
      
      $oCActiveDataProvider = new CActiveDataProvider('AccessControlDevicesGroupsDevices', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_group_device ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData(); 
   }
   
   public static function getAccessControlDevicesGroupsDevicesByIdGroupDevice($nIdGroupDevice) {
      $oCriteria = new CDbCriteria;
      
      $oCriteria->compare('t.id_group_device', $nIdGroupDevice);
      
      $oCActiveDataProvider = new CActiveDataProvider('AccessControlDevicesGroupsDevices', array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'t.id_device ASC',
         ), 
         'pagination'=>false,
      ));
      
      return $oCActiveDataProvider->getData();  
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('device.name', 'groupDevice.name');
        
      return $this->oExportSpecifications; 
   }
}
