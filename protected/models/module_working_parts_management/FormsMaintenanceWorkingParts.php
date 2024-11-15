<?php

/**
 * This is the model class for table "forms_maintenance_working_parts".
 *
 * The followings are the available columns in table 'forms_working_parts':
 * @property integer $id
 * @property string $owner
 * @property string $task
 * @property string $priority
 * @property integer $priority_number
 * @property string $first_responsible
 * @property string $second_responsible
 * @property string $third_responsible
 * @property string $fourth_responsible
 * @property string $fifth_responsible
 * @property string $sixth_responsible
 * @property string $method_code
 * @property string $method_description
 * @property string $id_zone
 * @property string $zone
 * @property string $id_region
 * @property string $region
 * @property string $id_equipment
 * @property string $equipment
 * @property string $equipment_failure_reason
 * @property string $failure_reason
 * @property string $failure_solution
 * @property string $comments
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property integer $id_maintenance_form_task
 * @property integer $id_form_work_request
 * @property integer $id_user 
 * @property integer $data_completed
 */
class FormsMaintenanceWorkingParts extends CExportedActiveRecord {
   public $sFilterStatusCreated;
   public $sFilterStatusPending;
   public $sFilterStatusRunning;
   public $sFilterStatusPendingAbsence;
   public $sFilterStatusHalted;
   public $sFilterStatusFinalized;
   public $sComponents;
   public $sNavigation;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsWorkingParts the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()->db_rainbow_workingpartsmanagement;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'forms_maintenance_working_parts';
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
         array('priority', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('priority_number', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('first_responsible', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('second_responsible', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('zone', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('region', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_equipment', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('equipment_failure_reason', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
           
         array('equipment_failure_reason', 'length', 'min'=>3, 'max'=>96, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('failure_reason', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('failure_solution', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
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
			// Please remove those attributes that should not be searched.
			array('id, owner, priority, zone, region, equipment, status, start_date, data_completed', 'safe', 'on'=>'search'),
		);
	}                                               

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
         'equipment_conditions'=>array(self::HAS_MANY, 'FormMaintenanceWorkingPartEquipmentConditions', 'id_form_maintenance_working_part'),
         'information_texts'=>array(self::HAS_MANY, 'FormMaintenanceWorkingPartInformationTexts', 'id_form_maintenance_working_part'),
         'ipes'=>array(self::HAS_MANY, 'FormMaintenanceWorkingPartIPEs', 'id_form_maintenance_working_part'),
         'measures'=>array(self::HAS_MANY, 'FormMaintenanceWorkingPartMeasures', 'id_form_maintenance_working_part'),
         'risks'=>array(self::HAS_MANY, 'FormMaintenanceWorkingPartRisks', 'id_form_maintenance_working_part'),
      );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),            
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_OWNER'),
			'priority'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_PRIORITY'),
         'priority_number'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_PRIORITYNUMBER'),
			'first_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FIRSTRESPONSIBLE'),
			'second_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_SECONDRESPONSIBLE'),
         'third_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_THIRDRESPONSIBLE'),
         'fourth_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FOURTHRESPONSIBLE'),
         'fifth_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FIFTHRESPONSIBLE'),
         'sixth_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_SIXTHRESPONSIBLE'),
         'method_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_METHODCODE'),
			'method_description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_METHODDESCRIPTION'),
         'id_zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_IDZONE'),
         'zone'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_ZONE'),
         'id_region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_IDREGION'),
         'region'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_REGION'),
         'id_equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_IDEQUIPMENT'),
         'equipment'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_EQUIPMENT'),
			'equipment_failure_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_EQUIPMENTFAILUREREASON'),
         'failure_reason'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FAILUREREASON'),
         'failure_solution'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_FAILURESOLUTION'),
         'comments'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_COMMENTS'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STATUS'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_ENDDATE'),
         'id_form_work_request'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_IDFORMWORKREQUEST'),
         'sComponents'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_COMPONENT'),
         'sNavigation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSMAINTENANCEWORKINGPARTS_FIELD_NAVIGATION'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sFilterStatusCreated = null, $sFilterStatusPending = null, $sFilterStatusRunning = null, $sFilterStatusPendingAbsence = null, $sFilterStatusHalted = null, $sFilterStatusFinalized = null) {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$oCriteria = new CDbCriteria;

		$oCriteria->compare('id', $this->id);
		$oCriteria->compare('owner', $this->owner, true);
		$oCriteria->compare('priority', $this->priority, true);
      $oCriteria->compare('zone', $this->zone, true);
		$oCriteria->compare('region', $this->region, true);
		$oCriteria->compare('equipment', $this->equipment, true);
		$oCriteria->compare('status', $this->status, true);
		$oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('data_completed', true);
      
      if ((!is_null($this->sFilterStatusCreated)) || (!is_null($this->sFilterStatusPending))  || (!is_null($this->sFilterStatusRunning)) || (!is_null($this->sFilterStatusPendingAbsence)) || (!is_null($this->sFilterStatusHalted))  || (!is_null($this->sFilterStatusFinalized)) || (!is_null($sFilterStatusCreated)) || (!is_null($sFilterStatusPending)) || (!is_null($sFilterStatusRunning)) || (!is_null($sFilterStatusPendingAbsence)) || (!is_null($sFilterStatusHalted)) || (!is_null($sFilterStatusFinalized))) {
         $sStatusCondition = FString::STRING_EMPTY;
         if (((!is_null($this->sFilterStatusCreated)) && ($this->sFilterStatusCreated)) || ((!is_null($sFilterStatusCreated)) && ($sFilterStatusCreated))) $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_CREATED . '\'';
         if (((!is_null($this->sFilterStatusPending)) && ($this->sFilterStatusPending)) || ((!is_null($sFilterStatusPending)) && ($sFilterStatusPending))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING . '\''; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING . '\'';
         }
         if (((!is_null($this->sFilterStatusRunning)) && ($this->sFilterStatusRunning)) || ((!is_null($sFilterStatusRunning)) && ($sFilterStatusRunning))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModuleWorkingPartsManagement::STATUS_RUNNING . '\''; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_RUNNING . '\'';
         }
         if (((!is_null($this->sFilterStatusPendingAbsence)) && ($this->sFilterStatusPendingAbsence)) || ((!is_null($sFilterStatusPendingAbsence)) && ($sFilterStatusPendingAbsence))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . '\''; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_PENDING_ABSENCE . '\'';
         }
         if (((!is_null($this->sFilterStatusHalted)) && ($this->sFilterStatusHalted)) || ((!is_null($sFilterStatusHalted)) && ($sFilterStatusHalted))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModuleWorkingPartsManagement::STATUS_HALTED . '\''; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_HALTED . '\'';
         }
         if (((!is_null($this->sFilterStatusFinalized)) && ($this->sFilterStatusFinalized)) || ((!is_null($sFilterStatusFinalized)) && ($sFilterStatusFinalized))) {
            if (strlen($sStatusCondition) > 0) $sStatusCondition .= ' OR status = \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\''; 
            else $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\'';
         }
         if ($sStatusCondition != FString::STRING_EMPTY) $oCriteria->addCondition($sStatusCondition);
         else $oCriteria->addCondition('false');
      }
      
      return new CActiveDataProvider($this, array(
         'criteria'=>$oCriteria,
         'sort'=>array(
            'defaultOrder'=>'start_date DESC',
         ),
         'pagination'=>array('pageSize'=>FApplication::GRID_MAX_ITEMS_PER_PAGE_BIG),
      ));
	}
   
   public static function getFormMaintenanceWorkingPart($nId) {
      $oFormMaintenanceWorkingPart = FormsMaintenanceWorkingParts::model()->findByPk($nId);
      
      return $oFormMaintenanceWorkingPart;
   }
   
   public static function getRunningFormsMaintenanceWorkingParts() {
      return FormsMaintenanceWorkingParts::model()->findAll('data_completed = 1 AND status <> \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\' ORDER BY start_date DESC');        
   }
   
   public static function getFormsMaintenanceWorkingParts($bDataCompleted = null, $nIdUser = null, $nIdZone = null, $nIdRegion = null, $nIdEquipment = null, $nIdMaintenanceFormTask = null) {
      if ((is_null($bDataCompleted)) && (is_null($nIdUser)) && (FString::isNullOrEmpty($nIdZone)) && (FString::isNullOrEmpty($nIdRegion)) && (FString::isNullOrEmpty($nIdEquipment)) && (FString::isNullOrEmpty($nIdMaintenanceFormTask))) $sSentence = 'true ORDER BY start_date DESC';
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
         $bCondition = true;
      }
      
      if (!FString::isNullOrEmpty($nIdMaintenanceFormTask)) {
         if ($bCondition) $sSentence = 'id_maintenance_form_task = ' . $nIdMaintenanceFormTask . ' AND ' . $sSentence;
         else $sSentence = 'id_maintenance_form_task = ' . $nIdMaintenanceFormTask . FString::STRING_SPACE . $sSentence;
      }
      
      return FormsMaintenanceWorkingParts::model()->findAll($sSentence);       
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');

      $this->oExportSpecifications['columns'] = array('id', 'owner', 'first_responsible', 'second_responsible', 'third_responsible', 'fourth_responsible', 'fifth_responsible', 'sixth_responsible', 'method_code', 'method_description', 'zone', 'region', 'equipment', 'equipment_failure_reason', 'failure_reason', 'failure_solution', 'comments', 'priority', 'start_date', 'end_date');
        
      return $this->oExportSpecifications; 
   }
}