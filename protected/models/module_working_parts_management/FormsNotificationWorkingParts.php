<?php

/**
 * This is the model class for table "forms_notification_working_parts".
 *
 * The followings are the available columns in table 'forms_notification_working_parts':
 * @property integer $id
 * @property string $owner
 * @property string $first_responsible
 * @property string $method_code
 * @property string $method_description
 * @property integer $id_zone
 * @property string $zone
 * @property integer $id_region
 * @property string $region
 * @property integer $id_equipment
 * @property string $equipment
 * @property string $equipment_failure_reason
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property integer $id_user
 * @property integer $data_completed
 *
 * The followings are the available model relations:
 * @property FormNotificationWorkingPartEmployees[] $formNotificationWorkingPartEmployees
 * @property FormNotificationWorkingPartIpes[] $formNotificationWorkingPartIpes
 * @property FormNotificationWorkingPartRisks[] $formNotificationWorkingPartRisks
 */
class FormsNotificationWorkingParts extends CExportedActiveRecord {

   /**
    * Returns the static model of the specified AR class.
    * Please note that you should have this exact method in all your CActiveRecord descendants!
    * @param string $className active record class name.
    * @return FormsNotificationWorkingParts the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }
   
   /**
    * @return CDbConnection the database connection used for this class
    */
   public function getDbConnection() {
      return Yii::app()->db_rainbow_workingpartsmanagement;
   }
   
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'forms_notification_working_parts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
         array('id', 'numerical'),
         
         array('owner', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('first_responsible', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('equipment_failure_reason', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
           
         array('equipment_studio_others', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('equipment_failure_reason', 'length', 'min'=>3, 'max'=>96, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('failure_reason', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('comments', 'length', 'min'=>3, 'max'=>512, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('equipment', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
            
         array('data_completed', 'boolean'),
         
         array('equipment', 'YiiConditionalValidator',
            'if'=>array(
               array('id_equipment', 'compare', 'compareValue'=>FApplication::EQUIPMENT_OTHERS),
            ),
            'then'=>array(
               array('equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner, first_responsible, method_code, method_description, id_zone, zone, id_region, region, id_equipment, equipment, equipment_failure_reason, status, start_date, end_date, id_user, data_completed', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'employees'=>array(self::HAS_MANY, 'FormNotificationWorkingPartEmployees', 'id_form_notification_working_part'),
			'ipes'=>array(self::HAS_MANY, 'FormNotificationWorkingPartIpes', 'id_form_notification_working_part'),
			'risks'=>array(self::HAS_MANY, 'FormNotificationWorkingPartRisks', 'id_form_notification_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),          
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_OWNER'),
			'first_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_FIRSTRESPONSIBLE'),
			'method_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_METHODCODE'),
			'method_description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_METHODDESCRIPTION'),
			'id_zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_IDZONE'),
			'zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_ZONE'),
			'id_region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_IDREGION'),
			'region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_REGION'),
			'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_IDEQUIPMENT'),
			'equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_EQUIPMENT'),
			'equipment_failure_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_EQUIPMENTFAILUREREASON'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_STATUS'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSNOTIFICATIONWORKINGPARTS_FIELD_ENDDATE'),
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

      $oCriteria->compare('id', $this->id);
      $oCriteria->compare('owner', $this->owner, true);
      $oCriteria->compare('zone', $this->zone, true);
      $oCriteria->compare('region', $this->region, true);
      $oCriteria->compare('equipment', $this->equipment, true);
      $oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('data_completed', true);

      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'start_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getFormNotificationWorkingPart($nId) {
      $oFormNotificationWorkingPart = FormsNotificationWorkingParts::model()->findByPk($nId);
      
      return $oFormNotificationWorkingPart;
   }
   
   public static function getRunningFormsNotificationWorkingParts() {
      return FormsNotificationWorkingParts::model()->findAll('data_completed = 1 AND status <> \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\' ORDER BY start_date DESC');        
   }
   
   public static function getFormsNotificationWorkingParts($bDataCompleted = null, $nIdUser = null, $nIdZone = null, $nIdRegion = null, $nIdEquipment = null) {
      if ((is_null($bDataCompleted)) && (is_null($nIdUser)) && (FString::isNullOrEmpty($nIdZone)) && (FString::isNullOrEmpty($nIdRegion)) && (FString::isNullOrEmpty($nIdEquipment))) $sSentence = 'true ORDER BY start_date DESC';
      else $sSentence = 'ORDER BY start_date DESC';
      $bCondition = false;
               
      if (!is_null($bDataCompleted)) { 
         if ($bDataCompleted) $sSentence = 'data_completed = 1' . FString::STRING_SPACE . $sSentence;
         else $sSentence = 'data_completed = 0' . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!is_null($nIdUser)) {
         if ($bCondition) $sSentence = 'id_user = ' . $nIdUser . ' AND ' . $sSentence;
         else $sSentence = 'id_user = ' . $nIdUser . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdZone)) {
         if ($bCondition) $sSentence = 'id_zone = ' . $nIdZone . ' AND ' . $sSentence;
         else $sSentence = 'id_zone = ' . $nIdZone . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdRegion)) {
         if ($bCondition) $sSentence = 'id_region = ' . $nIdRegion . ' AND ' . $sSentence;
         else $sSentence = 'id_region = ' . $nIdRegion . FString::STRING_SPACE . $sSentence;
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdEquipment)) {
         if ($bCondition) $sSentence = 'id_equipment = ' . $nIdEquipment . ' AND ' . $sSentence;
         else $sSentence = 'id_equipment = ' . $nIdEquipment . FString::STRING_SPACE . $sSentence;
      }
      
      return FormsNotificationWorkingParts::model()->findAll($sSentence);        
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');

      $this->oExportSpecifications['columns'] = array('id', 'owner', 'first_responsible', 'method_code', 'method_description', 'zone', 'region', 'equipment', 'equipment_failure_reason', 'start_date', 'end_date');
        
      return $this->oExportSpecifications; 
   }
}