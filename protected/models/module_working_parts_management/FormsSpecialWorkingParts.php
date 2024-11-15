<?php

/**
 * This is the model class for table "forms_special_working_parts".
 *
 * The followings are the available columns in table 'forms_special_working_parts':
 * @property integer $id
 * @property string $owner
 * @property string $task
 * @property string $first_responsible
 * @property string $third_responsible
 * @property string $method_code
 * @property string $method_description
 * @property string $installation
 * @property string $work
 * @property string $work_others
 * @property string $work_description
 * @property string $supplement_instructions
 * @property integer $permission_renovation
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property integer $id_maintenance_form_task
 * @property integer $id_form_work_request
 * @property integer $id_user
 * @property integer $data_completed
 * 
 * The followings are the available model relations:
 * @property FormSpecialWorkingPartEmployees[] $formSpecialWorkingPartEmployees
 * @property FormSpecialWorkingPartEquipmentConditions[] $formSpecialWorkingPartEquipmentConditions
 * @property FormSpecialWorkingPartIpes[] $formSpecialWorkingPartIpes
 * @property FormSpecialWorkingPartMeasures[] $formSpecialWorkingPartMeasures
 * @property FormSpecialWorkingPartPreventionMeans[] $formSpecialWorkingPartPreventionMeans
 */
class FormsSpecialWorkingParts extends CExportedActiveRecord {
   public $sFilterStatusCreated;
   public $sFilterStatusPending;
   public $sFilterStatusRunning;
   public $sFilterStatusPendingAbsence;
   public $sFilterStatusHalted;
   public $sFilterStatusFinalized;
   public $sNavigation;
   
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsSpecialWorkingParts the static model class
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
		return 'forms_special_working_parts';
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
         array('third_responsible', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')), 
         array('installation', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('work', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('work_description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('status', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('id_user', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_code', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('method_description', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
         array('third_responsible', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
           
         array('installation', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('work_description', 'length', 'min'=>3, 'max'=>96, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('supplement_instructions', 'length', 'min'=>3, 'max'=>255, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         array('work_others', 'length', 'min'=>3, 'max'=>40, 'tooShort'=>Yii::t('system', 'SYS_MODEL_ERROR_TOO_SHORT', array('{1}'=>'3'))),
         
         array('data_completed, permission_renovation', 'boolean'),
         
         array('work_others', 'YiiConditionalValidator',
            'if'=>array(
               array('work', 'compare', 'compareValue'=>strtoupper(FString::STRING_OTHERS)),
            ),
            'then'=>array(
               array('work_others', 'required', 'message'=>Yii::t('system', 'SYS_MODEL_ERROR_EMPTY')),
            ),
         ),
         
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner, installation, work, status, start_date, data_completed', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'employees'=>array(self::HAS_MANY, 'FormSpecialWorkingPartEmployees', 'id_form_special_working_part'),
			'equipment_conditions'=>array(self::HAS_MANY, 'FormSpecialWorkingPartEquipmentConditions', 'id_form_special_working_part'),
			'ipes'=>array(self::HAS_MANY, 'FormSpecialWorkingPartIpes', 'id_form_special_working_part'),
			'measures'=>array(self::HAS_MANY, 'FormSpecialWorkingPartMeasures', 'id_form_special_working_part'),
			'prevention_means'=>array(self::HAS_MANY, 'FormSpecialWorkingPartPreventionMeans', 'id_form_special_working_part'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('system', 'SYS_MODEL_FIELD_ID'),    
			'owner'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_OWNER'),                                                                                              
			'first_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_FIRSTRESPONSIBLE'),
         'third_responsible'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_THIRDRESPONSIBLE'),
         'method_code'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_METHODCODE'),
			'method_description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_METHODDESCRIPTION'),
         'installation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_INSTALLATION'),
			'work'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK'),
			'work_others'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORKOTHERS'),
			'work_description'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORKDESCRIPTION'),
			'supplement_instructions'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_SUPPLEMENTINSTRUCTIONS'),
			'permission_renovation' =>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_PERMISSIONRENOVATION'),
			'status'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STATUS'),
			'start_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_STARTDATE'),
			'end_date'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_ENDDATE'),
		   'id_form_work_request'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_IDFORMWORKREQUEST'),
         'sNavigation'=>Yii::t('frontend_' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT), 'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_NAVIGATION'),
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
      $oCriteria->compare('installation', $this->owner, true);
      $oCriteria->compare('work', $this->owner, true);
      $oCriteria->compare('status', $this->status, true);
      $oCriteria->compare('start_date', FDate::getEnglishDate($this->start_date), true);
      $oCriteria->compare('data_completed', true);

      if ((!is_null($this->sFilterStatusCreated)) || (!is_null($this->sFilterStatusPending))  || (!is_null($this->sFilterStatusRunning))  || (!is_null($this->sFilterStatusPendingAbsence)) || (!is_null($this->sFilterStatusHalted))  || (!is_null($this->sFilterStatusFinalized)) || (!is_null($sFilterStatusCreated)) || (!is_null($sFilterStatusPending)) || (!is_null($sFilterStatusRunning)) || (!is_null($sFilterStatusPendingAbsence)) || (!is_null($sFilterStatusHalted)) || (!is_null($sFilterStatusFinalized))) {
         $sStatusCondition = FString::STRING_EMPTY;
         if (((!is_null($this->sFilterStatusCreated)) && ($this->sFilterStatusCreated)) || ((!is_null($sFilterStatusCreated)) && ($sFilterStatusCreated)))   $sStatusCondition = 'status = \'' . FModuleWorkingPartsManagement::STATUS_CREATED . '\'';
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
   
   public static function getFormSpecialWorkingPart($nId) {
      $oFormSpecialWorkingPart = FormsSpecialWorkingParts::model()->findByPk($nId);
      
      return $oFormSpecialWorkingPart;
   }
   
   public static function getRunningFormsSpecialWorkingParts() {
      return FormsSpecialWorkingParts::model()->findAll('data_completed = 1 AND status <> \'' . FModuleWorkingPartsManagement::STATUS_FINALIZED . '\' ORDER BY start_date DESC');        
   }
   
   public static function getFormsSpecialWorkingParts($bDataCompleted = null, $nIdUser = null, $nIdMaintenanceFormTask = null) {
      if ((is_null($bDataCompleted)) && (is_null($nIdUser)) && (FString::isNullOrEmpty($nIdMaintenanceFormTask))) $sSentence = 'true ORDER BY start_date DESC';
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
      
      if (!FString::isNullOrEmpty($nIdMaintenanceFormTask)) {
         if ($bCondition) $sSentence = 'id_maintenance_form_task = ' . $nIdMaintenanceFormTask . ' AND ' . $sSentence;
         else $sSentence = 'id_maintenance_form_task = ' . $nIdMaintenanceFormTask . FString::STRING_SPACE . $sSentence;
      }
      
      return FormsSpecialWorkingParts::model()->findAll($sSentence);       
   }
   
   public function getExportSpecifications() {
      $this->oExportSpecifications['data'] = array();
      $this->oExportSpecifications['data'][0] = array('start_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][1] = array('end_date', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_DATE, 'FDate::getTimeZoneFormattedDate(\'?\', true)', 'FString::STRING_EMPTY');
      $this->oExportSpecifications['data'][2] = array('work', FWidget::TOOLBOX_EXPORTER_DATA_MODEL_DATA_TYPE_STRING, '$oArrayData[$i][\'work_others\']', 'Yii::t(\'frontend_\' . strtolower(FApplication::MODULE_WORKING_PARTS_MANAGEMENT),\'MODEL_FORMSSPECIALWORKINGPARTS_FIELD_WORK_VALUE_\' . \'?\')', '(\'?\' == strtoupper(FString::STRING_OTHERS))');
            
      $this->oExportSpecifications['columns'] = array('id', 'owner', 'first_responsible', 'third_responsible', 'method_code', 'method_description', 'installation', 'work', 'work_description', 'start_date', 'end_date');
        
      return $this->oExportSpecifications; 
   }
}