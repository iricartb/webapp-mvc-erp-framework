<?php

/**
 * This is the model class for table "accesscontrol_groups_devices".
 *
 * The followings are the available columns in table 'accesscontrol_groups_devices':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property AccesscontrolDevicesGroupsDevices[] $accesscontrolDevicesGroupsDevices
 */
class AccessControlGroupsDevices extends CExportedActiveRecord {
   
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
      return 'accesscontrol_groups_devices';
   }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),

         array('name', 'unique', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_UNIQUE')),
          
         array('name', 'length', 'min'=>3, 'max'=>30, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'devicesGroupDevices'=>array(self::HAS_MANY, 'AccessControlDevicesGroupsDevices', 'id_group_device'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),
			'name'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_ACCESS_CONTROL_MANAGEMENT), 'MODEL_ACCESSCONTROLGROUPSDEVICES_FIELD_NAME'),
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

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'name ASC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_SMALL),
      ));
	}

   public static function getAccessControlGroupDevice($nId) {
      $oAccessControlGroupDevice = AccessControlGroupsDevices::model()->findByPk($nId);
        
      return $oAccessControlGroupDevice;
   }
   
   public static function getAccessControlGroupsDevices($bShowOnlyUnlockDevices = false) {
      if ($bShowOnlyUnlockDevices) {
         $oAccessControlGroupsDevices = AccessControlGroupsDevices::model()->findAll(); 
         $nCount = 0;
         foreach($oAccessControlGroupsDevices as $oAccessControlGroupDevice) {
            if (AccessControlGroupsDevices::isAccessControlGroupDeviceLocked($oAccessControlGroupDevice->id)) {
               unset($oAccessControlGroupsDevices[$nCount]);  
            }
            
            $nCount++;
         }
         
         return $oAccessControlGroupsDevices;
      }
      else return AccessControlGroupsDevices::model()->findAll();   
   }
   
   public static function getAccessControlGroupDeviceByName($sName) {
      $oAccessControlGroupDevice = AccessControlGroupsDevices::model()->find('name = \'' . $sName . '\'');
        
      return $oAccessControlGroupDevice;
   }
   
   public static function getAccessControlGroupDeviceName($nId) {
      $oAccessControlGroupDevice = AccessControlGroupsDevices::getAccessControlGroupDevice($nId);
      if (!is_null($oAccessControlGroupDevice)) {
         return $oAccessControlGroupDevice->name;      
      }  
      return FString::STRING_EMPTY;
   }
   
   public static function isAccessControlGroupDeviceLocked($nId) {
      $bLocked = false;
      
      $oEmployees = Employees::getEmployeesByIdGroupDevice($nId);
      if (count($oEmployees) > 0) $bLocked = true;
      else $bLocked = false;
      
      return $bLocked;   
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['columns'] = array('name');
        
      return $this->oExportSpecifications; 
   }
}
